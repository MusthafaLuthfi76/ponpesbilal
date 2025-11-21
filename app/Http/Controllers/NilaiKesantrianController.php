<?php

namespace App\Http\Controllers;

use App\Models\NilaiKesantrian;
use App\Models\Santri;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class NilaiKesantrianController extends Controller
{
    /**
     * TAMPILKAN SEMUA NILAI KESANTRIAN
     */
    public function index(Request $request)
{
    $santri = Santri::all();
    $matapelajaran = MataPelajaran::all();
    $tahunAjaran = TahunAjaran::all();

    // Query base
    $query = NilaiKesantrian::with(['santri', 'mataPelajaran', 'tahunAjaran']);

    // FILTER TAHUN AJARAN
    if ($request->filled('id_tahunAjaran')) {
        $query->where('id_tahunAjaran', $request->id_tahunAjaran);
    }

    // FILTER MATA PELAJARAN
    if ($request->filled('id_matapelajaran')) {
        $query->where('id_matapelajaran', $request->id_matapelajaran);
    }

    // SEARCH NIS
    if ($request->filled('search_nis')) {
        $query->where('nis', 'like', '%' . $request->search_nis . '%');
    }

    // SEARCH NAMA SANTRI
    if ($request->filled('search_nama')) {
        $query->whereHas('santri', function ($q) use ($request) {
            $q->where('nama_lengkap', 'like', '%' . $request->search_nama . '%');
        });
    }

    $nilai = $query->orderBy('id_nilai_kesantrian', 'desc')->paginate(20);

    return view('nilaikesantrian.index', compact(
        'nilai', 
        'santri', 
        'matapelajaran', 
        'tahunAjaran'
    ));
}


    /**
     * FORM TAMBAH NILAI KESANTRIAN
     */
    public function create()
    {
        $santri = Santri::all();
        $mataPelajaran = MataPelajaran::all();
        $tahunAjaran = TahunAjaran::all();

        return view('nilaikesantrian.create', compact('santri', 'mataPelajaran', 'tahunAjaran'));
    }

    /**
     * SIMPAN NILAI BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:santri,nis',
            'id_matapelajaran' => 'required|exists:matapelajaran,id_matapelajaran',
            'id_tahunAjaran' => 'nullable|exists:tahunajaran,id_tahunAjaran',
            'nilai_akhlak' => 'nullable|string|max:10',
            'nilai_ibadah' => 'nullable|string|max:10',
            'nilai_kerapian' => 'nullable|string|max:10',
            'nilai_kedisiplinan' => 'nullable|string|max:10',
            'nilai_ekstrakulikuler' => 'nullable|string|max:10',
            'nilai_buku_pegangan' => 'nullable|string|max:10',
        ]);

        // Cegah duplikasi — respect constraint database
        $exists = NilaiKesantrian::where([
            'nis' => $request->nis,
            'id_matapelajaran' => $request->id_matapelajaran,
            'id_tahunAjaran' => $request->id_tahunAjaran,
        ])->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'Nilai untuk kombinasi Santri / Mata Pelajaran / Tahun Ajaran sudah ada.']);
        }

        NilaiKesantrian::create($request->all());

        return redirect()->route('nilaikesantrian.index')
            ->with('success', 'Nilai kesantrian berhasil ditambahkan.');
    }

    /**
     * FORM EDIT NILAI
     */
    public function edit($id)
    {
        $data = NilaiKesantrian::findOrFail($id);
        $santri = Santri::all();
        $mataPelajaran = MataPelajaran::all();
        $tahunAjaran = TahunAjaran::all();

        return view('nilaikesantrian.edit', compact('data', 'santri', 'mataPelajaran', 'tahunAjaran'));
    }

    /**
     * UPDATE NILAI
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|exists:santri,nis',
            'id_matapelajaran' => 'required|exists:matapelajaran,id_matapelajaran',
            'id_tahunAjaran' => 'nullable|exists:tahunajaran,id_tahunAjaran',
            'nilai_akhlak' => 'nullable|string|max:10',
            'nilai_ibadah' => 'nullable|string|max:10',
            'nilai_kerapian' => 'nullable|string|max:10',
            'nilai_kedisiplinan' => 'nullable|string|max:10',
            'nilai_ekstrakulikuler' => 'nullable|string|max:10',
            'nilai_buku_pegangan' => 'nullable|string|max:10',
        ]);

        $nilai = NilaiKesantrian::findOrFail($id);

        // Cek duplikasi jika ganti santri/mapel/TA
        $exists = NilaiKesantrian::where('id_nilai_kesantrian', '!=', $id)
            ->where([
                'nis' => $request->nis,
                'id_matapelajaran' => $request->id_matapelajaran,
                'id_tahunAjaran' => $request->id_tahunAjaran,
            ])->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'Nilai untuk kombinasi ini sudah ada.']);
        }

        $nilai->update($request->all());

        return redirect()->route('nilaikesantrian.index')
            ->with('success', 'Nilai kesantrian berhasil diperbarui.');
    }

    /**
     * HAPUS NILAI
     */
    public function destroy($id)
    {
        $nilai = NilaiKesantrian::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilaikesantrian.index')
            ->with('success', 'Nilai kesantrian berhasil dihapus.');
    }
}
