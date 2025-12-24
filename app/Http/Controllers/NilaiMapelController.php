<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiAkademik;
use App\Models\Santri;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\DB;

class NilaiMapelController extends Controller
{
    /**
     * Halaman awal -> daftar mata pelajaran + tahun ajaran
     */
    public function index(Request $request)
    {
        // Ambil filter dari query string (GET)
        $selectedTA = $request->id_tahun_ajaran ?? '';

        // Ambil semua Tahun Ajaran untuk dropdown
        $tahunAjaranList = TahunAjaran::orderBy('tahun')
            ->orderBy('semester')
            ->get();

        // Query Mapel
        $query = MataPelajaran::with('tahunAjaran');

        // Jika filter tahun ajaran dipilih → terapkan filter
        if ($selectedTA !== '') {
            $query->where('id_tahun_ajaran', $selectedTA);
        }

        $mapel = $query->get();

        return view('nilaiakademik.index', [
            'mapel' => $mapel,
            'tahunAjaranList' => $tahunAjaranList,
            'selectedTA' => $selectedTA
        ]);
    }

    /**
     * Detail nilai per mata pelajaran
     */
    public function show($id_mapel)
    {
        $mapel = MataPelajaran::with('tahunAjaran')->findOrFail($id_mapel);

        $nilai = NilaiAkademik::with(['santri'])
            ->where('id_matapelajaran', $id_mapel)
            ->get();

        return view('nilaiakademik.show', compact('mapel', 'nilai'));
    }

    /**
     * Halaman assign santri ke mapel
     */
    public function assignForm(Request $request, $id_mapel)
    {
        $mapel = Matapelajaran::with('tahunAjaran')->findOrFail($id_mapel);

        $assignedNis = DB::table('nilaiakademik')
            ->where('id_matapelajaran', $id_mapel)
            ->pluck('nis')
            ->toArray();

        $santriQuery = Santri::whereNotIn('nis', $assignedNis);

        // Filter
        if ($request->angkatan) {
            $santriQuery->where('angkatan', $request->angkatan);
        }
        if ($request->status) {
            $santriQuery->where('status', $request->status);
        }
        if ($request->search) {
            $santriQuery->where('nama', 'like', '%' . $request->search . '%');
        }

        // Pagination fleksibel
        $perPage = $request->per_page ?? 20;
        $santri = $santriQuery->orderBy('nama')->paginate($perPage)->withQueryString();

        // Options Dropdown
        $angkatanOptions = Santri::select('angkatan')->distinct()->orderBy('angkatan')->get();
        $statusOptions = Santri::select('status')->distinct()->orderBy('status')->get();

        return view('nilaiakademik.assign', compact(
            'mapel',
            'santri',
            'angkatanOptions',
            'statusOptions'
        ));
    }

    /**
     * Proses assign santri
     */
    public function assignStore(Request $request, $id_matapelajaran)
    {
        $request->validate([
            'nis' => 'required|array'
        ]);

        // 🔑 Ambil mata pelajaran untuk dapatkan id_tahunAjaran
        $mapel = MataPelajaran::findOrFail($id_matapelajaran);

        // Jika mata pelajaran tidak punya id_tahunAjaran, ambil dari santri atau default
        $idTahunAjaran = $mapel->id_tahunAjaran
            ?? Santri::where('nis', $request->nis[0])->value('id_tahunAjaran')
            ?? TahunAjaran::orderBy('id_tahunAjaran', 'desc')->value('id_tahunAjaran')
            ?? 1; // fallback aman

        foreach ($request->nis as $nis) {
            NilaiAkademik::create([
                'id_matapelajaran' => $id_matapelajaran,
                'nis' => $nis,
                'id_tahunAjaran' => $idTahunAjaran,
                'nilai_UTS' => 0,
                'nilai_UAS' => 0,
                'nilai_praktik' => 0,
                // Kolom absensi baru untuk UTS
                'izin_uts' => 0,
                'sakit_uts' => 0,
                'ghaib_uts' => 0,
                // Kolom absensi baru untuk UAS
                'izin_uas' => 0,
                'sakit_uas' => 0,
                'ghaib_uas' => 0,
                'nilai_rata_rata' => 0,
                'predikat' => null,
                'keterangan' => null,
            ]);
        }

        return redirect()->route('nilaiakademik.mapel.show', $id_matapelajaran)
            ->with('success', 'Santri berhasil diassign ke mata pelajaran.');
    }

    /**
     * Update nilai per santri (untuk form single update)
     */
    public function update(Request $request, $id_nilai)
    {
        $nilai = NilaiAkademik::findOrFail($id_nilai);

        $request->validate([
            'nilai_UTS' => 'nullable|numeric|min:0|max:100',
            'nilai_UAS' => 'nullable|numeric|min:0|max:100',
            'nilai_praktik' => 'nullable|numeric|min:0|max:100',
            'izin_uts' => 'required|integer|min:0',
            'sakit_uts' => 'required|integer|min:0',
            'ghaib_uts' => 'required|integer|min:0',
            'izin_uas' => 'required|integer|min:0',
            'sakit_uas' => 'required|integer|min:0',
            'ghaib_uas' => 'required|integer|min:0',
        ]);

        $uts = $request->nilai_UTS;
        $uas = $request->nilai_UAS;
        $prak = $request->nilai_praktik;

        // Hitung nilai rata-rata berbobot
        $rata = null;
        if ($uts !== null || $uas !== null || $prak !== null) {
            $rata = round(
                (($uts ?? 0) * 0.30) +
                    (($uas ?? 0) * 0.40) +
                    (($prak ?? 0) * 0.30),
                2
            );
        }

        // Predikat + keterangan
        $predikat = null;
        $ket = null;

        if ($rata !== null) {
            if ($rata >= 85) $predikat = 'A';
            elseif ($rata >= 70) $predikat = 'B';
            elseif ($rata >= 55) $predikat = 'C';
            else $predikat = 'D';

            $ket = ($rata >= 55) ? 'LULUS' : 'TIDAK LULUS';
        }

        $nilai->update([
            'nilai_UTS' => $uts,
            'nilai_UAS' => $uas,
            'nilai_praktik' => $prak,
            // Absensi UTS
            'izin_uts' => $request->izin_uts,
            'sakit_uts' => $request->sakit_uts,
            'ghaib_uts' => $request->ghaib_uts,
            // Absensi UAS
            'izin_uas' => $request->izin_uas,
            'sakit_uas' => $request->sakit_uas,
            'ghaib_uas' => $request->ghaib_uas,
            // Hasil perhitungan
            'nilai_rata_rata' => $rata,
            'predikat' => $predikat,
            'keterangan' => $ket,
        ]);

        return back()->with('success', 'Nilai berhasil diperbarui.');
    }

    /**
     * Menghapus nilai santri
     */
    public function destroy($id_nilai)
    {
        $nilai = NilaiAkademik::findOrFail($id_nilai);
        $mapel = $nilai->id_matapelajaran;

        $nilai->delete();

        return redirect()->route('nilaiakademik.mapel.show', $mapel)
            ->with('success', 'Data santri berhasil dihapus dari mapel.');
    }

    /**
     * Update nilai secara massal (per periode)
     */
    public function updateAll(Request $request, $id_mapel)
    {
        $request->validate([
            'periode' => 'required|in:uts,uas',
            'id_tahunAjaran' => 'required|exists:tahunajaran,id_tahunAjaran',
            'nilai' => 'required|array',
        ]);

        $periode = $request->periode;
        $updated = 0;

        foreach ($request->input('nilai', []) as $id_nilai => $data) {
            $nilai = NilaiAkademik::find($id_nilai);
            if (!$nilai) continue;

            $updateData = [];

            // === Update nilai & absensi sesuai periode ===
            if ($periode === 'uts') {
                // Nilai UTS
                if (isset($data['nilai_UTS']) && is_numeric($data['nilai_UTS'])) {
                    $updateData['nilai_UTS'] = max(0, min(100, (float) $data['nilai_UTS']));
                }
                // Absensi UTS
                $updateData['izin_uts'] = isset($data['izin_uts']) ? max(0, (int) $data['izin_uts']) : $nilai->izin_uts;
                $updateData['sakit_uts'] = isset($data['sakit_uts']) ? max(0, (int) $data['sakit_uts']) : $nilai->sakit_uts;
                $updateData['ghaib_uts'] = isset($data['ghaib_uts']) ? max(0, (int) $data['ghaib_uts']) : $nilai->ghaib_uts;
            } elseif ($periode === 'uas') {
                // Nilai UAS dan Praktik
                if (isset($data['nilai_UAS']) && is_numeric($data['nilai_UAS'])) {
                    $updateData['nilai_UAS'] = max(0, min(100, (float) $data['nilai_UAS']));
                }
                if (isset($data['nilai_praktik']) && is_numeric($data['nilai_praktik'])) {
                    $updateData['nilai_praktik'] = max(0, min(100, (float) $data['nilai_praktik']));
                }
                // Absensi UAS
                $updateData['izin_uas'] = isset($data['izin_uas']) ? max(0, (int) $data['izin_uas']) : $nilai->izin_uas;
                $updateData['sakit_uas'] = isset($data['sakit_uas']) ? max(0, (int) $data['sakit_uas']) : $nilai->sakit_uas;
                $updateData['ghaib_uas'] = isset($data['ghaib_uas']) ? max(0, (int) $data['ghaib_uas']) : $nilai->ghaib_uas;
            }

            // === Hitung ulang nilai akhir ===
            $uts = $updateData['nilai_UTS'] ?? $nilai->nilai_UTS ?? 0;
            $uas = $updateData['nilai_UAS'] ?? $nilai->nilai_UAS ?? 0;
            $prak = $updateData['nilai_praktik'] ?? $nilai->nilai_praktik ?? 0;

            // Bobot: 30% UTS, 40% UAS, 30% Praktik
            $rata = round(($uts * 0.3) + ($uas * 0.4) + ($prak * 0.3), 2);
            $rata = min(100.0, max(0.0, $rata)); // clamp antara 0–100

            $predikat = match (true) {
                $rata >= 85 => 'A',
                $rata >= 80 => 'B',
                $rata >= 55 => 'C',
                default => 'D',
            };

            $keterangan = $rata >= 55 ? 'LULUS' : 'TIDAK LULUS';

            $updateData['nilai_rata_rata'] = $rata;
            $updateData['predikat'] = $predikat;
            $updateData['keterangan'] = $keterangan;

            // Simpan
            $nilai->update($updateData);
            $updated++;
        }

        return back()->with('success', "Berhasil memperbarui {$updated} data nilai periode " . strtoupper($periode) . ".");
    }

    /**
     * Detail nilai per santri
     */
    public function detail($id_nilai)
    {
        // Ambil nilai akademik berdasarkan ID nilai + relasi
        $nilai = NilaiAkademik::with([
            'santri',
            'mataPelajaran.tahunAjaran',
            'mataPelajaran.pendidik'
        ])->findOrFail($id_nilai);

        // Ambil mapel dari relasi nilai
        $mapel = $nilai->mataPelajaran;

        return view('nilaiakademik.show', [ // Ganti view menjadi 'show'
            'nilai' => $nilai, // Kirim object langsung (bukan array)
            'mapel' => $mapel
        ]);
    }
}
