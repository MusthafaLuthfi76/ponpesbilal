<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TahunAjaran;
use App\Models\UjianTahfidz;
use App\Models\Pendidik;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;

class UjianTahfidzController extends Controller
{
    public function index(Request $request)
    {
        // Query ujian tahfidz dengan eager loading relasi
        $query = UjianTahfidz::with(['santri', 'tahunAjaran', 'penguji']);

        // Filter berdasarkan search (nama santri atau NIS) - PREFIX MATCH ONLY
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('santri', function($q) use ($search) {
                $q->where('nama', 'like', "{$search}%")
                  ->orWhere('nis', 'like', "{$search}%");
            });
        }

        // Filter berdasarkan semester melalui relasi tahun ajaran
        if ($request->filled('semester')) {
            $query->whereHas('tahunAjaran', function($q) use ($request) {
                $q->where('semester', $request->semester);
            });
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun')) {
            $query->where('tahun_ajaran_id', $request->tahun);
        }
        
        // Group berdasarkan santri + tahun ajaran + jenis ujian + sekali duduk + penguji
        $ujianListRaw = $query->orderBy('created_at', 'desc')->get();
        
        // Group data
        $ujianGrouped = $ujianListRaw->groupBy(function($ujian) {
            return $ujian->nis . '_' . 
                   $ujian->tahun_ajaran_id . '_' . 
                   $ujian->jenis_ujian . '_' . 
                   $ujian->sekali_duduk . '_' . 
                   $ujian->id_penguji;
        });
        
        // Transform group menjadi collection dengan agregat data
        $ujianListGrouped = $ujianGrouped->map(function($group) {
            $first = $group->first();
            
            // Hitung agregat
            $juzList = $group->pluck('juz')->filter()->unique()->sort()->values();
            $totalKesalahan = $group->sum('total_kesalahan');
            $totalTajwid = $group->sum('tajwid');
            $totalItqan = $group->sum('itqan');
            
            return (object) [
                'id' => $first->id, // ID untuk link detail
                'nis' => $first->nis,
                'santri' => $first->santri,
                'tahunAjaran' => $first->tahunAjaran,
                'penguji' => $first->penguji,
                'jenis_ujian' => $first->jenis_ujian,
                'sekali_duduk' => $first->sekali_duduk,
                'juz_count' => $juzList->count(),
                'juz_list' => $juzList->implode(', '),
                'juz' => $juzList->count() > 0 ? $juzList->implode(', ') : null, // untuk kompatibilitas view
                'tajwid' => $totalTajwid > 0 ? $totalTajwid : null, // untuk kompatibilitas view
                'itqan' => $totalItqan > 0 ? $totalItqan : null, // untuk kompatibilitas view
                'total_kesalahan' => $totalKesalahan,
                'created_at' => $first->created_at,
            ];
        })->values();
        
        // Manual pagination (karena sudah di-group)
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $ujianList = new \Illuminate\Pagination\LengthAwarePaginator(
            $ujianListGrouped->forPage($currentPage, $perPage),
            $ujianListGrouped->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        $tahunList = TahunAjaran::orderBy('tahun', 'desc')->get();
        $pendidikList = Pendidik::orderBy('nama', 'asc')->get();
        $santriList = Santri::orderBy('nama', 'asc')->get();

        // Return view dengan data - VARIABEL SUDAH KONSISTEN
        return view('nilaiTahfidz.index', compact('ujianList', 'tahunList', 'pendidikList', 'santriList'));
    }

    public function show($id, Request $request)
    {
        // Ambil data santri dengan relasi halaqah & tahunAjaran
        $santri = Santri::with(['halaqah.pendidik', 'tahunAjaran'])
            ->findOrFail($id);

        // Ambil semua ujian tahfidz santri ini untuk grouping
        $semuaUjian = UjianTahfidz::where('nis', $santri->nis)
            ->with(['tahunAjaran', 'penguji'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Group ujian berdasarkan kombinasi: jenis_ujian + tahun_ajaran_id + id_penguji + sekali_duduk + tanggal (hari)
        $ujianGroups = $semuaUjian->groupBy(function($ujian) {
            $tanggal = $ujian->created_at ? $ujian->created_at->format('Y-m-d') : 'unknown';
            return $ujian->jenis_ujian . '_' . $ujian->tahun_ajaran_id . '_' . $ujian->id_penguji . '_' . $ujian->sekali_duduk . '_' . $tanggal;
        });
        
        // Ambil group yang dipilih (dari request atau group pertama)
        $selectedGroupKey = $request->get('group');
        if ($selectedGroupKey && $ujianGroups->has($selectedGroupKey)) {
            $ujianList = $ujianGroups->get($selectedGroupKey);
        } else {
            $ujianList = $ujianGroups->first() ?? collect();
        }
        
        // Ambil ujian pertama dari group yang dipilih untuk mendapatkan penguji, jenis_ujian, dan sekali_duduk
        $ujianPertama = $ujianList->first();

        // Hitung total kesalahan dari ujian yang ditampilkan (group yang dipilih)
        $totalTajwid = $ujianList->sum('tajwid') ?? 0;
        $totalItqan = $ujianList->sum('itqan') ?? 0;
        $totalKeseluruhan = $ujianList->sum('total_kesalahan') ?? 0;

        // Dropdown tahun ajaran
        $tahunAjaranList = \App\Models\TahunAjaran::orderBy('tahun', 'desc')->get();
        
        // Ambil daftar pendidik untuk dropdown (jika belum ada ujian)
        $pendidikList = \App\Models\Pendidik::orderBy('nama', 'asc')->get();

        return view('nilaiTahfidz.detail', compact(
            'santri',
            'ujianList',
            'ujianPertama',
            'ujianGroups',
            'selectedGroupKey',
            'totalTajwid',
            'totalItqan',
            'totalKeseluruhan',
            'tahunAjaranList',
            'pendidikList'
        ));
    }

    /**
     * Menyimpan data ujian tahfidz baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'tahunAjaran' => 'required',
            'jenis_ujian' => 'required',
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
            'sekali_duduk' => 'required',
            'id_penguji' => 'required|exists:pendidik,id_pendidik'
        ]);

        // Hitung total kesalahan (tajwid + itqan)
        $totalKesalahan = $request->tajwid + $request->itqan;

        $data = [
            'nis' => $request->nis,
            'tahun_ajaran_id' => $request->tahunAjaran,
            'jenis_ujian' => $request->jenis_ujian,
            'juz' => $request->juz,
            'tajwid' => $request->tajwid,
            'itqan' => $request->itqan,
            'total_kesalahan' => $totalKesalahan,
            'sekali_duduk' => $request->sekali_duduk
        ];

        // Tambahkan id_penguji jika ada
        if ($request->filled('id_penguji')) {
            $data['id_penguji'] = $request->id_penguji;
        }

        try {
            UjianTahfidz::create($data);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Nilai juz ini sudah pernah diinput untuk kombinasi ujian yang sama.');
            }
            throw $e;
        }

        return redirect()
            ->route('nilaiTahfidz.show', $request->nis)
            ->with('success', 'Data nilai tahfidz berhasil ditambahkan');
    }

    /**
     * Update data ujian tahfidz
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_ujian' => 'required|string|in:UTS,UAS',
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
        ]);

        // Cari data ujian berdasarkan ID
        $ujianTahfidz = UjianTahfidz::findOrFail($id);

        // Cek duplikat juz untuk ujian yang sama (kecuali record yang sedang diedit)
        $duplicate = UjianTahfidz::where('nis', $ujianTahfidz->nis)
            ->where('tahun_ajaran_id', $ujianTahfidz->tahun_ajaran_id)
            ->where('jenis_ujian', $validated['jenis_ujian'])
            ->where('sekali_duduk', $ujianTahfidz->sekali_duduk)
            ->where('id_penguji', $ujianTahfidz->id_penguji)
            ->where('juz', $validated['juz'])
            ->where('id', '!=', $id)
            ->first();

        if ($duplicate) {
            return redirect()
                ->route('nilaiTahfidz.show', $ujianTahfidz->nis)
                ->with('error', 'Juz ' . $validated['juz'] . ' sudah ada untuk ujian ini.');
        }

        // Hitung total kesalahan
        $totalKesalahan = $validated['tajwid'] + $validated['itqan'];

        // Update data
        $ujianTahfidz->update([
            'jenis_ujian' => $validated['jenis_ujian'],
            'juz' => $validated['juz'],
            'tajwid' => $validated['tajwid'],
            'itqan' => $validated['itqan'],
            'total_kesalahan' => $totalKesalahan,
        ]);

        // Redirect kembali ke halaman detail santri
        return redirect()
            ->route('nilaiTahfidz.show', $ujianTahfidz->nis)
            ->with('success', 'Data ujian berhasil diupdate');
    }

    /**
     * Menampilkan form edit (opsional)
     */
    public function edit($id)
    {
        $ujianTahfidz = UjianTahfidz::with('santri')->findOrFail($id);
        $tahunAjaranList = \App\Models\TahunAjaran::orderBy('tahun', 'desc')->get();
        
        return view('nilaiTahfidz.edit', compact('ujianTahfidz', 'tahunAjaranList'));
    }

    /**
     * Menghapus data ujian tahfidz
     */
    public function destroy($id)
    {
        // Cari data ujian berdasarkan ID untuk mendapatkan kombinasi group
        $ujianTahfidz = UjianTahfidz::findOrFail($id);
        
        // Hapus semua ujian dengan kombinasi yang sama (nis, tahun_ajaran, jenis_ujian, sekali_duduk, penguji)
        $deletedCount = UjianTahfidz::where('nis', $ujianTahfidz->nis)
            ->where('tahun_ajaran_id', $ujianTahfidz->tahun_ajaran_id)
            ->where('jenis_ujian', $ujianTahfidz->jenis_ujian)
            ->where('sekali_duduk', $ujianTahfidz->sekali_duduk)
            ->where('id_penguji', $ujianTahfidz->id_penguji)
            ->delete();

        return redirect()->back()->with('success', "Data ujian tahfidz berhasil dihapus ({$deletedCount} juz)");
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
            'jenis_ujian' => 'required|in:UTS,UAS',
            'sekali_duduk' => 'required|in:ya,tidak',
            'id_penguji' => 'required|exists:pendidik,id_pendidik',
            'nis' => 'required|exists:santri,nis',
        ]);

        $duplicate = UjianTahfidz::where('nis', $request->nis)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('jenis_ujian', $request->jenis_ujian)
            ->where('sekali_duduk', $request->sekali_duduk)
            ->where('id_penguji', $request->id_penguji)
            ->exists();

        if ($duplicate) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Ujian ini sudah pernah dibuat untuk santri, penguji, dan semester yang sama.');
        }

        try {
            UjianTahfidz::create([
                'nis' => $request->nis,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'jenis_ujian' => $request->jenis_ujian,
                'sekali_duduk' => $request->sekali_duduk,
                'id_penguji' => $request->id_penguji,
                'juz' => null,
                'tajwid' => null,
                'itqan' => null,
                'total_kesalahan' => 0,
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Ujian ini sudah ada.');
            }
            throw $e;
        }

        return redirect()
            ->route('nilaiTahfidz.index')
            ->with('success', 'Ujian baru berhasil ditambahkan');
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
            'id_penguji' => 'required|exists:pendidik,id_pendidik',
        ]);

        $exists = UjianTahfidz::where('nis', $data['nis'])
            ->where('tahun_ajaran_id', $data['tahun_ajaran_id'])
            ->where('jenis_ujian', $data['jenis_ujian'])
            ->where('sekali_duduk', $data['sekali_duduk'])
            ->where('id_penguji', $data['id_penguji'])
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
        try {
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
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()
                    ->route('nilaiTahfidz.inputNilai', $id)
                    ->with('error', 'Juz ' . $request->juz . ' sudah pernah diinput untuk kombinasi ujian ini.');
            }
            throw $e;
        }

        return redirect()
            ->route('nilaiTahfidz.inputNilai', $id)
            ->with('success', 'Juz ' . $request->juz . ' berhasil ditambahkan');
    }

    public function create($nis)
    {
        $santri = Santri::with(['tahunAjaran','halaqah'])->findOrFail($nis);
        $tahunAjaran = TahunAjaran::all();

        return view('nilaiTahfidz.create', compact('santri', 'tahunAjaran'));
    }
}