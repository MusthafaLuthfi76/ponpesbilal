<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index()
    {
        $santri = Santri::with('tahunAjaran')->get();
        $tahunajaran = TahunAjaran::all();
        return view('santri.homeSantri', compact('santri', 'tahunajaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:santri,nis',
            'nama' => 'required|string|max:100',
            'angkatan' => 'nullable|string|max:10',
            'status' => 'required|in:MA,MTS,Alumni,Keluar',
            'id_tahunAjaran' => 'nullable|exists:tahunajaran,id_tahunAjaran',
        ]);

        Santri::create($validated);
        return redirect()->route('santri.index')->with('success', 'Data santri berhasil ditambahkan!');
    }

    public function update(Request $request, $nis)
    {
        $santri = Santri::findOrFail($nis);

        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:santri,nis,' . $nis . ',nis',
            'nama' => 'required|string|max:100',
            'angkatan' => 'nullable|string|max:10',
            'status' => 'required|in:MA,MTS,Alumni,Keluar',
            'id_tahunAjaran' => 'nullable|exists:tahunajaran,id_tahunAjaran',
        ]);

        $santri->update($validated);
        return redirect()->route('santri.index')->with('success', 'Data santri berhasil diperbarui!');
    }

    public function destroy($nis)
    {
        $santri = Santri::findOrFail($nis);
        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil dihapus!');
    }
}
