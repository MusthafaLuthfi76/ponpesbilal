<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiAkademik;
use App\Models\Santri;
use App\Models\Matapelajaran;
use App\Models\TahunAjaran;

class NilaiAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nilai = NilaiAkademik::with(['santri','mataPelajaran','tahunAjaran'])->get();
        $santri = Santri::all();
        $matapelajaran = Matapelajaran::all();
        $tahunajaran = TahunAjaran::all();

        return view('nilaiakademik.index', compact('nilai','santri','matapelajaran','tahunajaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:santri,nis',
            'id_matapelajaran' => 'required|exists:matapelajaran,id_matapelajaran',
            'nilai_UTS' => 'nullable|numeric|min:0|max:100',
            'nilai_UAS' => 'nullable|numeric|min:0|max:100',
            'nilai_praktik' => 'nullable|numeric|min:0|max:100',
            'nilai_keaktifan' => 'nullable|numeric|min:0|max:100',
        ]);

        $data = $request->only('nis','id_matapelajaran','nilai_UTS','nilai_UAS','nilai_praktik','nilai_keaktifan');
        // Hitung rata-rata
        $nilaiCount = collect([$data['nilai_UTS'],$data['nilai_UAS'],$data['nilai_praktik'],$data['nilai_keaktifan']])->filter()->count();
        if($nilaiCount > 0){
            $data['nilai_rata_rata'] = round(
                (array_sum(array_filter([$data['nilai_UTS'],$data['nilai_UAS'],$data['nilai_praktik'],$data['nilai_keaktifan']])) / $nilaiCount),2
            );
            $avg = $data['nilai_rata_rata'];
            if($avg >= 85) $data['predikat']='A';
            elseif($avg >= 70) $data['predikat']='B';
            elseif($avg >= 55) $data['predikat']='C';
            else $data['predikat']='D';

            $data['keterangan'] = ($avg >= 55) ? 'LULUS' : 'TIDAK LULUS';
        }

        NilaiAkademik::create($data);

        return redirect()->route('nilaiakademik.index')->with('success','Data nilai berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|exists:santri,nis',
            'id_matapelajaran' => 'required|exists:matapelajaran,id_matapelajaran',
            'nilai_UTS' => 'nullable|numeric|min:0|max:100',
            'nilai_UAS' => 'nullable|numeric|min:0|max:100',
            'nilai_praktik' => 'nullable|numeric|min:0|max:100',
            'nilai_keaktifan' => 'nullable|numeric|min:0|max:100',
        ]);

        $nilai = NilaiAkademik::findOrFail($id);
        $data = $request->only('nis','id_matapelajaran','nilai_UTS','nilai_UAS','nilai_praktik','nilai_keaktifan');

        // Hitung rata-rata lagi
        $nilaiCount = collect([$data['nilai_UTS'],$data['nilai_UAS'],$data['nilai_praktik'],$data['nilai_keaktifan']])->filter()->count();
        if($nilaiCount > 0){
            $data['nilai_rata_rata'] = round(
                (array_sum(array_filter([$data['nilai_UTS'],$data['nilai_UAS'],$data['nilai_praktik'],$data['nilai_keaktifan']])) / $nilaiCount),2
            );
            $avg = $data['nilai_rata_rata'];
            if($avg >= 85) $data['predikat']='A';
            elseif($avg >= 70) $data['predikat']='B';
            elseif($avg >= 55) $data['predikat']='C';
            else $data['predikat']='D';

            $data['keterangan'] = ($avg >= 55) ? 'LULUS' : 'TIDAK LULUS';
        }

        $nilai->update($data);

        return redirect()->route('nilaiakademik.index')->with('success','Data nilai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $nilai = NilaiAkademik::findOrFail($id);
        $nilai->delete();

        return redirect()->route('nilaiakademik.index')->with('success','Data nilai berhasil dihapus.');
    }
}
