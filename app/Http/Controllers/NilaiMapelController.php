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
    public function index()
    {
        $mapel = MataPelajaran::with('tahunAjaran')->get();

        return view('nilaiakademik.index', compact('mapel'));
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

    foreach ($request->nis as $nis) {
        NilaiAkademik::create([
            'id_matapelajaran' => $id_matapelajaran,
            'nis' => $nis,
            'nilai_UTS' => 0,
            'nilai_UAS' => 0,
            'nilai_praktik' => 0,
            'jumlah_izin' => 0,
            'jumlah_sakit' => 0,
            'jumlah_ghaib' => 0
        ]);
    }

    return redirect()->route('nilaiakademik.mapel.show', $id_matapelajaran)
        ->with('success', 'Santri berhasil diassign ke mata pelajaran.');
}


    /**
     * Update nilai per santri
     */
    public function update(Request $request, $id_nilai)
    {
        $nilai = NilaiAkademik::findOrFail($id_nilai);

        $request->validate([
            'nilai_UTS' => 'nullable|numeric|min:0|max:100',
            'nilai_UAS' => 'nullable|numeric|min:0|max:100',
            'nilai_praktik' => 'nullable|numeric|min:0|max:100',
            'jumlah_izin' => 'required|integer|min:0',
            'jumlah_sakit' => 'required|integer|min:0',
            'jumlah_ghaib' => 'required|integer|min:0',
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
                (($prak ?? 0) * 0.30)
            , 2);
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
            'jumlah_izin' => $request->jumlah_izin,
            'jumlah_sakit' => $request->jumlah_sakit,
            'jumlah_ghaib' => $request->jumlah_ghaib,
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

    public function updateAll(Request $request, $id_mapel)
{
    // Validasi minimal
    if (!$request->has('nilai')) {
        return back()->with('error', 'Tidak ada data nilai yang dikirimkan.');
    }

    foreach ($request->nilai as $id_nilai => $data) {

        $uts     = $data['uts'] ?? 0;
        $uas     = $data['uas'] ?? 0;
        $praktik = $data['praktik'] ?? 0;

        $izin  = $data['izin'] ?? 0;
        $sakit = $data['sakit'] ?? 0;
        $ghaib = $data['ghaib'] ?? 0;

        // Hitung rata-rata
        $rata = ($uts + $uas + $praktik) / 3;

        // Tentukan predikat
        if ($rata >= 90)       $predikat = 'A';
        elseif ($rata >= 80)  $predikat = 'B';
        elseif ($rata >= 70)  $predikat = 'C';
        elseif ($rata >= 60)  $predikat = 'D';
        else                  $predikat = 'E';

        // Tentukan keterangan
        $keterangan = ($rata >= 75) ? 'Lulus' : 'Tidak Lulus';

        // Update database
        \DB::table('nilaiakademik')
            ->where('id_nilai_akademik', $id_nilai)
            ->update([
                'nilai_UTS'      => $uts,
                'nilai_UAS'      => $uas,
                'nilai_praktik'  => $praktik,
                'jumlah_izin'    => $izin,
                'jumlah_sakit'   => $sakit,
                'jumlah_ghaib'   => $ghaib,
                'nilai_rata_rata'=> $rata,
                'predikat'       => $predikat,
                'keterangan'     => $keterangan,
                'updated_at'     => now()
            ]);
    }

    return back()->with('success', 'Semua nilai berhasil diperbarui!');
}

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

    return view('nilaiakademik.show', [
        'nilai' => [$nilai],  // dibuat array agar foreach tetap jalan
        'mapel' => $mapel
    ]);
}

}
