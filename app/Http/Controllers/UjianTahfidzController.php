<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TahunAjaran;
use App\Models\UjianTahfidz;
use App\Models\Pendidik;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;

class UjianTahfidzController extends Controller
{
    public function index(Request $request)
    {
        // Ambil SEMUA santri dengan relasi ujian (UTS/UAS saja)
        $query = Santri::with([
            'ujianTahfidz' => function ($q) {
                $q->with(['tahunAjaran', 'penguji'])
                    ->whereIn('jenis_ujian', ['UTS', 'UAS']);
            }
        ])->orderBy('nama');

        // 🔍 Filter 1: Search (nama/nis)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // 🔍 Filter 2: Tahun Ajaran (id_tahunAjaran)
        $filterTahunAjaranId = $request->input('tahun');
        $filterSemester = $request->input('semester');

        // Kumpulkan santri yang memenuhi filter → lalu filter ujian-nya secara manual
        $santriList = $query->get();

        $grouped = [];

        foreach ($santriList as $santri) {
            // Ambil semua ujian UTS/UAS milik santri ini
            $allUjians = $santri->ujianTahfidz->filter(function ($ujian) use ($filterTahunAjaranId, $filterSemester) {
                $ta = $ujian->tahunAjaran;

                // ✅ Filter berdasarkan TAHUN AJARAN ID
                if ($filterTahunAjaranId && $ujian->tahun_ajaran_id != $filterTahunAjaranId) {
                    return false;
                }

                // ✅ Filter berdasarkan SEMESTER (case-insensitive & trim)
                if ($filterSemester) {
                    $semesterDb = $ta?->semester;
                    if (!$semesterDb) return false;

                    // Normalisasi: bandingkan lowercase
                    if (strtolower(trim($semesterDb)) !== strtolower(trim($filterSemester))) {
                        return false;
                    }
                }

                return true;
            });

            // Jika ada ujian yang lolos filter → lanjut
            if ($allUjians->isEmpty()) {
                continue; // skip santri ini
            }

            // Group ujian per tahun_ajaran_id (untuk satu santri, bisa ada >1 tahun)
            $ujianPerTahun = $allUjians->groupBy('tahun_ajaran_id');

            foreach ($ujianPerTahun as $tahunAjaranId => $ujians) {
                $tahunAjaran = $ujians->first()->tahunAjaran;

                $hasUTS = $ujians->contains('jenis_ujian', 'UTS');
                $hasUAS = $ujians->contains('jenis_ujian', 'UAS');

                $representative = $ujians->firstWhere('jenis_ujian', 'UAS')
                    ?? $ujians->firstWhere('jenis_ujian', 'UTS')
                    ?? $ujians->first();

                $grouped[] = (object) [
                    'santri' => $santri,
                    'tahunAjaran' => $tahunAjaran,
                    'has_uts' => $hasUTS,
                    'has_uas' => $hasUAS,
                    'ujian_utama' => $representative,
                    'total_ujian' => $ujians->count(),
                    'ujians' => $ujians,
                ];
            }
        }

        // 📅 Sort by newest ujian_utama
        usort($grouped, function ($a, $b) {
            $dateA = $a->ujian_utama?->created_at ?? now();
            $dateB = $b->ujian_utama?->created_at ?? now();
            return $dateB <=> $dateA;
        });

        // 📄 Pagination
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = array_slice($grouped, ($currentPage - 1) * $perPage, $perPage);
        $ujianList = new LengthAwarePaginator($pagedData, count($grouped), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // 💡 Data pendukung
        $tahunList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $pendidikList = Pendidik::orderBy('nama')->get();

        return view('nilaiTahfidz.index', compact('ujianList', 'tahunList', 'pendidikList'));
    }

    public function show($id, Request $request)
    {
        // ===============================
        // 1. DATA SANTRI
        // ===============================
        $santri = Santri::with(['halaqah.pendidik'])->findOrFail($id);

        // ===============================
        // 2. AMBIL SEMUA UJIAN TAHFIDZ SANTRI
        // ===============================
        $semuaUjian = UjianTahfidz::where('nis', $santri->nis)
            ->with(['tahunAjaran', 'penguji'])
            ->orderBy('created_at', 'desc')
            ->get();

        // ===============================
        // 3. GROUPING: TAHUN AJARAN + SEMESTER
        // (UTS & UAS digabung)
        // ===============================
        $ujianGroups = $semuaUjian->groupBy(function ($ujian) {
            $ta = $ujian->tahunAjaran;
            $taId = $ujian->tahun_ajaran_id ?? '0';
            $semester = $ta?->semester ? ucwords(strtolower(trim($ta->semester))) : 'Unknown';
            return "{$taId}_{$semester}";
        });

        // ===============================
        // 4. LABEL DROPDOWN (SEMESTER SAJA)
        // ===============================
        $groupLabels = [];
        foreach ($ujianGroups as $key => $items) {
            $first = $items->first();
            $ta = $first->tahunAjaran;

            if (!$ta) continue;

            // ✅ Gunakan semester yang sudah dinormalisasi (sama seperti di key)
            $semester = ucwords(strtolower(trim($ta->semester)));
            $label = "{$ta->tahun} {$semester}";
            $groupLabels[$key] = $label;
        }


        // ===============================
        // 5. PILIH SEMESTER AKTIF
        // - dari dropdown (jika ada)
        // - atau semester terbaru
        // ===============================
        $selectedGroupKey = $request->get('group');

        if (!$selectedGroupKey) {
            $taIdParam = $request->get('tahun_ajaran_id');
            $semesterParam = $request->get('semester'); // opsional fallback

            if ($taIdParam && $semesterParam) {
                // Normalisasi semester dari query string juga!
                $normSemester = ucwords(strtolower(trim($semesterParam)));
                $selectedGroupKey = "{$taIdParam}_{$normSemester}";
            }
        }


        // ===============================
        // 6. LIST UJIAN YANG DITAMPILKAN
        // ===============================
        $ujianList = $selectedGroupKey && $ujianGroups->has($selectedGroupKey)
            ? $ujianGroups->get($selectedGroupKey)
            : $ujianGroups->first() ?? collect();

        // ===============================
        // 7. INFO HEADER & SUMMARY
        // ===============================
        $ujianPertama = $ujianList->first();
        $tahunAjaranAktif = $ujianPertama?->tahunAjaran;

        // Summary semester (UTS + UAS)
        $totalTajwid = $ujianList->sum('tajwid');
        $totalItqan = $ujianList->sum('itqan');
        $totalKeseluruhan = $ujianList->sum('total_kesalahan');

        // ===============================
        // 8. DATA PENDUKUNG (MODAL / FORM)
        // ===============================
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $pendidikList = Pendidik::orderBy('nama', 'asc')->get();

        // ===============================
        // 9. RETURN VIEW
        // ===============================
        return view('nilaiTahfidz.detail', compact(
            'santri',
            'ujianList',
            'ujianPertama',
            'ujianGroups',
            'groupLabels',
            'selectedGroupKey',
            'totalTajwid',
            'totalItqan',
            'totalKeseluruhan',
            'tahunAjaranList',
            'pendidikList',
            'tahunAjaranAktif'
        ));
    }


    /**
     * Menyimpan data ujian tahfidz baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:santri,nis',
            'jenis_ujian' => 'required|in:UTS,UAS',
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
            'sekali_duduk' => 'required|in:ya,tidak',
            // Validasi untuk input hidden yang kita tambahkan di view
            'tahun_ajaran_id' => 'nullable|exists:tahunajaran,id_tahunAjaran',
            'id_penguji' => 'nullable|exists:pendidik,id_pendidik',
        ]);

        // Gunakan nilai dari input, jika kosong default null
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        $idPenguji = $request->input('id_penguji');

        // Cek duplikasi (Logic disesuaikan agar tetap aman meskipun tahun/penguji null)
        $query = UjianTahfidz::where('nis', $request->nis)
            ->where('jenis_ujian', $request->jenis_ujian)
            ->where('sekali_duduk', $request->sekali_duduk)
            ->where('juz', $request->juz);

        // Jika sedang melihat tahun ajaran tertentu, cek duplikasi berdasarkan tahun itu juga
        if ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        }

        $existingJuz = $query->first();

        if ($existingJuz) {
            return redirect()
                ->route('nilaiTahfidz.show', $request->nis)
                ->with('error', 'Juz ' . $request->juz . ' sudah pernah diinput untuk kombinasi ini: ' .
                    $request->jenis_ujian . ' - ' . ucfirst($request->sekali_duduk));
        }

        // Hitung total kesalahan (tajwid + itqan)
        $totalKesalahan = $request->tajwid + $request->itqan;

        $data = [
            'nis' => $request->nis,
            'jenis_ujian' => $request->jenis_ujian,
            'juz' => $request->juz,
            'tajwid' => $request->tajwid,
            'itqan' => $request->itqan,
            'total_kesalahan' => $totalKesalahan,
            'sekali_duduk' => $request->sekali_duduk,
            'tahun_ajaran_id' => $tahunAjaranId,
            'id_penguji' => $idPenguji,
            'is_header' => 0,
        ];

        UjianTahfidz::create($data);

        return redirect()
            ->route('nilaiTahfidz.show', $request->nis)
            ->with('success', 'Data nilai tahfidz berhasil ditambahkan');
    }

    /**
     * Update data ujian tahfidz
     */
    public function update(Request $request, $id)
    {
        // Validasi input (sama seperti sebelumnya)
        $validated = $request->validate([
            'jenis_ujian' => 'required|string|in:UTS,UAS',
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
            'sekali_duduk' => 'required|in:ya,tidak',
            'nis' => 'required|exists:santri,nis',
            'tahun_ajaran_id' => 'required|exists:tahunajaran,id_tahunAjaran',
            'id_penguji' => 'required|exists:pendidik,id_pendidik',
        ]);

        // Ambil data target (hanya untuk ambil context)
        $target = UjianTahfidz::findOrFail($id);

        // ✅ UPDATE SEMUA JUZ DALAM SESI YANG SAMA
        // Kriteria sesi: nis + jenis_ujian + tahun_ajaran_id + id_penguji
        $affected = UjianTahfidz::where([
            'nis' => $validated['nis'],
            'jenis_ujian' => $validated['jenis_ujian'],
            'tahun_ajaran_id' => $validated['tahun_ajaran_id'],
            'id_penguji' => $validated['id_penguji'],
        ])->update([
            'sekali_duduk' => $validated['sekali_duduk'],
            // Opsional: juga update tahun_ajaran_id & id_penguji jika diizinkan berubah
            // 'tahun_ajaran_id' => $validated['tahun_ajaran_id'],
            // 'id_penguji' => $validated['id_penguji'],
            'updated_at' => now(),
        ]);

        // ✅ Update hanya record ini untuk nilai juz-nya (tajwid, itqan, juz)
        $target->update([
            'juz' => $validated['juz'],
            'tajwid' => $validated['tajwid'],
            'itqan' => $validated['itqan'],
            'total_kesalahan' => $validated['tajwid'] + $validated['itqan'],
            // Catatan: 'sekali_duduk' sudah diupdate massal di atas
        ]);

        return redirect()
            ->route('nilaiTahfidz.show', $validated['nis'])
            ->with('success', "Data ujian juz {$validated['juz']} berhasil diupdate. Status 'sekali duduk' diterapkan ke seluruh sesi.");
    }

    /**
     * Menampilkan form edit
     */
    public function edit($id)
    {
        $ujianTahfidz = UjianTahfidz::with('santri')->findOrFail($id);
        $tahunAjaranList = \App\Models\TahunAjaran::orderBy('tahun', 'desc')->get();

        // Tambahkan ini agar penguji bisa dipilih di form edit
        $pendidikList = \App\Models\Pendidik::orderBy('nama', 'asc')->get();

        return view('nilaiTahfidz.edit', compact('ujianTahfidz', 'tahunAjaranList', 'pendidikList'));
    }



    /**
     * Menghapus data ujian tahfidz
     */
    public function destroy($id)
    {
        $ujian = UjianTahfidz::findOrFail($id);

        // Hanya hapus record ini (bisa header atau detail)
        $ujian->delete();

        // Redirect ke detail santri (bukan index) agar halaman tidak "error 404 missing"
        return redirect()
            ->route('nilaiTahfidz.show', $ujian->nis)
            ->with('success', 'Data ujian berhasil dihapus.');
    }

    /**
     * Menghapus data ujian tahfidz
     */
    public function destroyUjian($id)
    {
        // Ambil 1 ujian untuk dapatkan identitas (nis & tahun_ajaran_id)
        $ujian = UjianTahfidz::findOrFail($id);

        $nis = $ujian->nis;
        $tahunAjaranId = $ujian->tahun_ajaran_id;

        // ✅ Hapus SEMUA ujian dengan kombinasi NIS + TAHUN AJARAN yang sama
        $deletedCount = UjianTahfidz::where('nis', $nis)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->delete();


        return redirect()
            ->route('nilaiTahfidz.index')
            ->with('success', "Berhasil menghapus {$deletedCount} data ujian terkait.");
    }

    /**
     * Menampilkan form untuk membuat ujian baru
     */
    public function createUjianBaru()
    {
        $tahunAjaranList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $pendidikList = Pendidik::orderBy('nama', 'asc')->get();
        $santriList = Santri::orderBy('nama', 'asc')->get();

        return view('nilaiTahfidz.create-ujian', compact('tahunAjaranList', 'pendidikList', 'santriList'));
    }

    /**
     * Menyimpan ujian baru (tanpa nilai)
     */
    public function storeUjianBaru(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahunajaran,id_tahunAjaran',
            'id_penguji' => 'required|exists:pendidik,id_pendidik',
            'nis' => 'required|exists:santri,nis',
        ]);

        $nis = $request->nis;
        $tahunAjaranId = $request->tahun_ajaran_id;

        // Cek ujian yang sudah ada untuk santri + tahun ajaran ini
        $existingUjians = UjianTahfidz::where('nis', $nis)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->whereIn('jenis_ujian', ['UTS', 'UAS'])
            ->pluck('jenis_ujian')
            ->toArray();

        // Tentukan jenis ujian otomatis
        if (in_array('UAS', $existingUjians)) {
            return back()->with('error', 'Santri ini sudah menyelesaikan UAS pada semester ini.');
        } elseif (in_array('UTS', $existingUjians)) {
            $jenisUjian = 'UAS'; // Sudah UTS → lanjut ke UAS
        } else {
            $jenisUjian = 'UTS'; // Belum ada → mulai dari UTS
        }

        // Cek duplikat (aman)
        if (UjianTahfidz::where('nis', $nis)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->where('jenis_ujian', $jenisUjian)
            ->exists()
        ) {
            return back()->with('error', "Ujian $jenisUjian untuk santri ini pada semester ini sudah ada.");
        }

        // Buat record
        UjianTahfidz::create([
            'nis' => $nis,
            'tahun_ajaran_id' => $tahunAjaranId,
            'jenis_ujian' => $jenisUjian,
            'sekali_duduk' => $request->sekali_duduk,
            'id_penguji' => $request->id_penguji,
            'juz' => null,
            'tajwid' => null,
            'itqan' => null,
            'is_header' => true,
        ]);

        return redirect()
            ->route('nilaiTahfidz.index')
            ->with('success', "Ujian $jenisUjian berhasil dibuat.");
    }

    /**
     * Memperbarui data ujian (tanpa mengubah nilai tahfidz)
     */
    public function updateUjian(Request $request, UjianTahfidz $ujian)
    {
        $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahunajaran,id_tahunAjaran',
            'id_penguji' => 'required|exists:pendidik,id_pendidik',
        ]);

        // Cek duplikat: hindari konflik dengan ujian lain milik santri yang sama
        // kecuali dirinya sendiri (ignore current record)
        $exists = UjianTahfidz::where('nis', $ujian->nis)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('jenis_ujian', $request->jenis_ujian)
            ->where('id', '!=', $ujian->id)
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ujian dengan jenis dan tahun ajaran yang sama untuk santri ini sudah ada.');
        }

        $ujian->update([
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'is_header' => true,
            'id_penguji' => $request->id_penguji,
        ]);

        return redirect()
            ->route('nilaiTahfidz.index')
            ->with('success', 'Data ujian berhasil diperbarui.');
    }

    /**
     * AJAX: Check duplicate ujian existence
     */
    public function checkDuplicateUjian(Request $request)
    {
        $data = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahunajaran,id_tahunAjaran',
            'jenis_ujian' => 'required|in:UTS,UAS',
            'sekali_duduk' => 'required|in:ya,tidak',
            'nis' => 'required|exists:santri,nis',
        ]);

        $exists = UjianTahfidz::where('nis', $data['nis'])
            ->where('tahun_ajaran_id', $data['tahun_ajaran_id'])
            ->where('jenis_ujian', $data['jenis_ujian'])
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Menampilkan halaman input nilai untuk ujian
     */
    public function inputNilai($id)
    {
        $ujian = UjianTahfidz::with(['santri', 'tahunAjaran', 'penguji'])->findOrFail($id);

        // Ambil semua juz yang sudah diinput untuk ujian ini
        $juzList = UjianTahfidz::where('nis', $ujian->nis)
            ->where('tahun_ajaran_id', $ujian->tahun_ajaran_id)
            ->where('jenis_ujian', $ujian->jenis_ujian)
            ->where('sekali_duduk', $ujian->sekali_duduk)
            ->where('id_penguji', $ujian->id_penguji)
            ->whereNotNull('juz')
            ->orderBy('juz', 'desc')
            ->get();

        // Ambil juz yang sudah digunakan
        $juzUsed = $juzList->pluck('juz')->toArray();

        return view('nilaiTahfidz.input-nilai', compact('ujian', 'juzList', 'juzUsed'));
    }

    /**
     * Menyimpan nilai ujian (tambah juz baru)
     */
    public function storeNilai(Request $request, $id)
    {
        $request->validate([
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
        ]);

        $ujian = UjianTahfidz::findOrFail($id);

        // Cek apakah juz ini sudah ada untuk ujian yang sama
        $existingJuz = UjianTahfidz::where('nis', $ujian->nis)
            ->where('tahun_ajaran_id', $ujian->tahun_ajaran_id)
            ->where('jenis_ujian', $ujian->jenis_ujian)
            ->where('sekali_duduk', $ujian->sekali_duduk)
            ->where('id_penguji', $ujian->id_penguji)
            ->where('juz', $request->juz)
            ->whereNotNull('juz')
            ->first();

        if ($existingJuz) {
            return redirect()
                ->route('nilaiTahfidz.inputNilai', $id)
                ->with('error', 'Juz ' . $request->juz . ' sudah pernah diinput untuk ujian ini');
        }

        // Hitung total kesalahan
        $totalKesalahan = $request->tajwid + $request->itqan;

        // Buat record baru untuk juz ini
        UjianTahfidz::create([
            'nis' => $ujian->nis,
            'tahun_ajaran_id' => $ujian->tahun_ajaran_id,
            'jenis_ujian' => $ujian->jenis_ujian,
            'sekali_duduk' => $ujian->sekali_duduk,
            'id_penguji' => $ujian->id_penguji,
            'juz' => $request->juz,
            'tajwid' => $request->tajwid,
            'itqan' => $request->itqan,
            'total_kesalahan' => $totalKesalahan,
            'is_header' => 0,
        ]);

        return redirect()
            ->route('nilaiTahfidz.inputNilai', $id)
            ->with('success', 'Juz ' . $request->juz . ' berhasil ditambahkan');
    }

    public function create($nis)
    {
        $santri = Santri::with(['tahunAjaran', 'halaqah'])->findOrFail($nis);
        $tahunAjaran = TahunAjaran::all();

        return view('nilaiTahfidz.create', compact('santri', 'tahunAjaran'));
    }
}
