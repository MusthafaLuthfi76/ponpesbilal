<?php

namespace App\Http\Controllers;

use App\Models\NilaiKesantrian;
use App\Models\Santri;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Http\Controllers\Controller; // Pastikan ini ada jika menggunakan namespace Controller
use Illuminate\Http\Request;

class NilaiKesantrianController extends Controller
{
    /**
     * TAMPILKAN SEMUA KOMBINASI MATA PELAJARAN + TAHUN AJARAN KESANTRIAN (Index)
     */
    public function index(Request $request)
    {
        // Ambil unique kombinasi id_matapelajaran + id_tahunAjaran dari nilai kesantrian
        $query = NilaiKesantrian::select('id_matapelajaran', 'id_tahunAjaran')
            ->distinct()
            ->with(['mataPelajaran', 'tahunAjaran']);

        // Filter berdasarkan tahun ajaran jika dipilih
        if ($request->filled('id_tahunAjaran')) {
            $query->where('id_tahunAjaran', $request->id_tahunAjaran);
        }

        $nilaiKesantrianList = $query->orderBy('id_tahunAjaran', 'desc')
            ->orderBy('id_matapelajaran', 'desc')
            ->get();

        // Ambil semua Tahun Ajaran untuk filter modal
        $tahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();

        // Ambil HANYA 1 Mata Pelajaran Kesantrian (untuk tambah data baru)
        $matapelajaranKesantrian = MataPelajaran::where('nama_matapelajaran', 'LIKE', '%Kesantrian%')->get();

        return view('nilaikesantrian.index', compact('nilaiKesantrianList', 'matapelajaranKesantrian', 'tahunAjaran'));
    }

    /**
     * SIMPAN MATA PELAJARAN KESANTRIAN BARU (Dari Modal di Index)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_matapelajaran_template' => 'required|exists:matapelajaran,id_matapelajaran',
            'id_tahunAjaran' => 'required|exists:tahunajaran,id_tahunAjaran',
        ]);

        $mapelKesantrian = MataPelajaran::findOrFail($request->id_matapelajaran_template);

        // TIDAK membuat mata pelajaran baru, hanya redirect ke halaman detail untuk assign santri
        // dengan tahun ajaran yang dipilih

        return redirect()->route('nilaikesantrian.show', [
            'id_matapelajaran' => $mapelKesantrian->id_matapelajaran,
            'id_tahunAjaran' => $request->id_tahunAjaran
        ])->with('success', 'Silakan assign santri untuk Tahun Ajaran ini.');
    }


    /**
     * TAMPILKAN DETAIL DAN DATA INPUT/ASSIGN (Show)
     */
    public function show($id_matapelajaran, $id_tahunAjaran, Request $request)
    {
        $mapel = MataPelajaran::findOrFail($id_matapelajaran);
        $tahunAjaran = TahunAjaran::findOrFail($id_tahunAjaran);

        // 1. Data Santri yang SUDAH memiliki record Nilai Kesantrian
        $nilaiSantri = NilaiKesantrian::with('santri')
            ->where('id_matapelajaran', $id_matapelajaran)
            ->where('id_tahunAjaran', $id_tahunAjaran)
            ->get();

        // 2. Data Santri yang BELUM memiliki record Nilai Kesantrian (untuk tab Assign)
        $querySantriBelum = Santri::query();

        if ($request->filled('angkatan')) {
            $querySantriBelum->where('angkatan', $request->angkatan);
        }
        if ($request->filled('search_nama')) {
            $querySantriBelum->where('nama', 'LIKE', '%' . $request->search_nama . '%');
        }

        $querySantriBelum->whereDoesntHave('nilaiKesantrian', function ($q) use ($id_matapelajaran, $id_tahunAjaran) {
            $q->where('id_matapelajaran', $id_matapelajaran)
                ->where('id_tahunAjaran', $id_tahunAjaran);
        });

        $santriBelumAssign = $querySantriBelum->get();

        // Ambil daftar angkatan untuk filter
        $angkatanList = Santri::select('angkatan')->distinct()->pluck('angkatan');

        // Tentukan tab aktif
        $activeTab = $request->get('tab', 'uts'); // Default ke tab UTS

        return view('nilaikesantrian.detail', compact(
            'mapel',
            'tahunAjaran',
            'nilaiSantri',
            'santriBelumAssign',
            'angkatanList',
            'activeTab'
        ));
    }


    /**
     * SIMPAN SANTRI KE MAPEL KESANTRIAN (Assign Store)
     */
    public function assignStore(Request $request, $id_matapelajaran, $id_tahunAjaran)
    {
        $request->validate(['nis' => 'required|array']);

        foreach ($request->nis as $nis) {
            NilaiKesantrian::firstOrCreate([
                'nis' => $nis,
                'id_matapelajaran' => $id_matapelajaran,
                'id_tahunAjaran' => $id_tahunAjaran,
            ]);
        }

        return redirect()->route('nilaikesantrian.show', [
            'id_matapelajaran' => $id_matapelajaran,
            'id_tahunAjaran' => $id_tahunAjaran,
            'tab' => 'assign'
        ])->with('success', 'Santri berhasil di-assign ke Mata Pelajaran Kesantrian ini.');
    }

    public function unassign($id)
    {
        $nilai = NilaiKesantrian::find($id);

        if (!$nilai) {
            return back()->with('error', 'Data Nilai Kesantrian tidak ditemukan.');
        }

        // Simpan data untuk redirect kembali
        $id_matapelajaran = $nilai->id_matapelajaran;
        $id_tahunAjaran = $nilai->id_tahunAjaran;

        $nilai->delete();

        return redirect()->route('nilaikesantrian.show', [
            'id_matapelajaran' => $id_matapelajaran,
            'id_tahunAjaran' => $id_tahunAjaran,
        ])->with('success', 'Santri berhasil di-unassign dari mata pelajaran ini.');
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

    /**
     * UPDATE MATA PELAJARAN KESANTRIAN
     */
    public function update(Request $request, $id_matapelajaran)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id_matapelajaran);

        $data = $request->validate([
            'nama_matapelajaran' => ['required', 'string', 'max:100'],
            'kkm' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_UTS' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_UAS' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_praktik' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        // Validasi total bobot = 100%
        $totalBobot = $data['bobot_UTS'] + $data['bobot_UAS'] + $data['bobot_praktik'];
        if ($totalBobot != 100) {
            return back()->withInput()->withErrors(['bobot_total' => "Total bobot harus 100% (saat ini: $totalBobot%)"]);
        }

        $mataPelajaran->update($data);

        return redirect()->route('nilaikesantrian.index')
            ->with('success', 'Mata Pelajaran Kesantrian berhasil diperbarui');
    }

    /**
     * DELETE MATA PELAJARAN KESANTRIAN
     */
    public function destroy($id_matapelajaran)
    {
        try {
            $mataPelajaran = MataPelajaran::findOrFail($id_matapelajaran);

            // Hapus semua nilai kesantrian terkait
            NilaiKesantrian::where('id_matapelajaran', $id_matapelajaran)->delete();

            // Hapus mata pelajaran
            $mataPelajaran->delete();

            return redirect()->route('nilaikesantrian.index')
                ->with('success', 'Mata Pelajaran Kesantrian berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('nilaikesantrian.index')
                ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
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
