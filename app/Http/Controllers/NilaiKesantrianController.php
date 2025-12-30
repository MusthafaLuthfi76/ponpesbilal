<?php

namespace App\Http\Controllers;

use App\Models\NilaiKesantrian;
use App\Models\Santri;
use App\Models\TahunAjaran;
use App\Http\Controllers\Controller; // Pastikan ini ada jika menggunakan namespace Controller
use Illuminate\Http\Request;

class NilaiKesantrianController extends Controller
{
    /**
     * Tampilkan daftar penilaian kesantrian per tahun ajaran.
     */
    public function index(Request $request)
    {
        $query = NilaiKesantrian::select('id_tahunAjaran')
            ->selectRaw('COUNT(*) as total_santri')
            ->with('tahunAjaran')
            ->groupBy('id_tahunAjaran');

        if ($request->filled('id_tahunAjaran')) {
            $query->where('id_tahunAjaran', $request->id_tahunAjaran);
        }

        $nilaiKesantrianList = $query->orderBy('id_tahunAjaran', 'desc')->get();

        $tahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();

        return view('nilaikesantrian.index', compact(
            'nilaiKesantrianList',
            'tahunAjaran'
        ));
    }

    /**
     * Mulai input nilai untuk tahun ajaran yang dipilih.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tahunAjaran' => 'required|exists:tahunajaran,id_tahunAjaran',
        ]);

        return redirect()->route('nilaikesantrian.show', $request->id_tahunAjaran)
            ->with('success', 'Silakan assign santri untuk Tahun Ajaran ini.');
    }


    /**
     * Tampilkan detail dan input nilai per tahun ajaran.
     */
    public function show($id_tahunAjaran, Request $request)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id_tahunAjaran);

        $nilaiSantri = NilaiKesantrian::with('santri')
            ->where('id_tahunAjaran', $id_tahunAjaran)
            ->get();

        $querySantriBelum = Santri::query();

        if ($request->filled('angkatan')) {
            $querySantriBelum->where('angkatan', $request->angkatan);
        }
        if ($request->filled('search_nama')) {
            $querySantriBelum->where('nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        $querySantriBelum->whereDoesntHave('nilaiKesantrian', function ($q) use ($id_tahunAjaran) {
            $q->where('id_tahunAjaran', $id_tahunAjaran);
        });

        $santriBelumAssign = $querySantriBelum->get();

        $angkatanList = Santri::select('angkatan')->distinct()->pluck('angkatan');

        $activeTab = $request->get('tab', 'uts');

        return view('nilaikesantrian.detail', compact(
            'tahunAjaran',
            'nilaiSantri',
            'santriBelumAssign',
            'angkatanList',
            'activeTab'
        ));
    }


    /**
     * Assign santri ke penilaian kesantrian per tahun ajaran.
     */
    public function assignStore(Request $request, $id_tahunAjaran)
    {
        $request->validate(['nis' => 'required|array']);

        foreach ($request->nis as $nis) {
            NilaiKesantrian::firstOrCreate([
                'nis' => $nis,
                'id_tahunAjaran' => $id_tahunAjaran,
            ]);
        }

        return redirect()->route('nilaikesantrian.show', [
            'id_tahunAjaran' => $id_tahunAjaran,
            'tab' => 'assign'
        ])->with('success', 'Santri berhasil di tambah ke penilaian kesantrian tahun ajaran ini.');
    }

    public function unassign($id)
    {
        $nilai = NilaiKesantrian::find($id);

        if (!$nilai) {
            return back()->with('error', 'Data Nilai Kesantrian tidak ditemukan.');
        }

        // Simpan data untuk redirect kembali
        $id_tahunAjaran = $nilai->id_tahunAjaran;

        $nilai->delete();

        return redirect()->route('nilaikesantrian.show', [
            'id_tahunAjaran' => $id_tahunAjaran,
        ])->with('success', 'Santri berhasil di hapus dari penilaian kesantrian ini.');
    }


    /**
     * UPDATE NILAI KESANTRIAN SECARA MASSAL (Update Massal)
     */
    public function updateNilaiMassal(Request $request)
    {
        $data = $request->input('nilai', []);
        $periode = $request->input('periode'); // 'uts' atau 'uas'

        if (empty($data)) {
            return redirect()->back()->with('error', 'Tidak ada data nilai yang dikirim.');
        }

        foreach ($data as $id_nilai => $fields) {
            $nilai = NilaiKesantrian::find($id_nilai);
            if (!$nilai) continue;

            $updateData = [];

            foreach ($fields as $komponen => $value) {
                $value = strtoupper(trim($value));

                // Validasi pola: A, A+, A-, ..., E (dan kosong)
                if ($value !== '' && !preg_match('/^[A-E][+-]?$/', $value)) {
                    \Log::warning("Nilai tidak valid — ID $id_nilai, komponen $komponen: '$value'");
                    continue;
                }

                $fieldName = $periode === 'uts'
                    ? $komponen . '_uts'
                    : ($periode === 'uas' ? $komponen . '_uas' : null);

                if ($fieldName && in_array($fieldName, $nilai->getFillable())) {
                    $updateData[$fieldName] = $value === '' ? null : $value;
                }
            }

            if (!empty($updateData)) {
                $nilai->update($updateData);
            }
        }

        $periodeText = strtoupper($periode);
        return redirect()->back()->with('success', "Nilai kesantrian periode {$periodeText} berhasil diperbarui.");
    }

    // --- FUNGSI STANDAR CRUD INDIVIDUAL (Jika masih diperlukan) ---

    /**
     * FORM EDIT NILAI
     */
    public function edit($id)
    {
        $nilai = NilaiKesantrian::findOrFail($id);
        $santri = Santri::all();
        $mapel = MataPelajaran::all();
        $tahunAjaran = TahunAjaran::all();
        return view('nilaikesantrian.edit', compact('nilai', 'santri', 'mapel', 'tahunAjaran'));
    }

    /**
     * UPDATE NILAI INDIVIDUAL
     */
    public function updateNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $nilai = NilaiKesantrian::findOrFail($id);
        $nilai->update(['nilai' => $request->nilai]);

        return redirect()->route('nilaikesantrian.index')
            ->with('success', 'Nilai kesantrian berhasil diperbarui.');
    }

    /**
     * HAPUS NILAI
     */
    public function destroyNilai($id)
    {
        $nilai = NilaiKesantrian::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilaikesantrian.index')
            ->with('success', 'Nilai kesantrian berhasil dihapus.');
    }

    // FUNGSI LAMA SEPERTI create(), indexTahunAjaran(), assign(), updateAll(), showByTahun() DIHAPUS UNTUK KONSISTENSI
}
