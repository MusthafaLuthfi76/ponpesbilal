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
        return view('santri.Santri', compact('santri', 'tahunajaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:santri,nis',
            'nama' => 'required|string|max:100',
            'angkatan' => 'nullable|string|max:10',
            'status' => 'required|in:MA,MTS,Alumni,Keluar',
            'id_tahunAjaran' => 'nullable|exists:tahunajaran,id_tahunAjaran',
            'id_halaqah' => 'nullable',
        ]);

        Santri::create($validated);
        return redirect()->route('santri.index')->with('success', 'Data santri berhasil ditambahkan!');
    }
    public function create()
    {
        $tahunajaran = TahunAjaran::all();
        return view('santri.createSantri', compact('tahunajaran'));
    }

    /**
     * Show the form for editing the specified santri.
     */
    public function edit(string $nis)
    {
        $santri = Santri::where('nis', $nis)->firstOrFail();
        $tahunajaran = TahunAjaran::all();
        return view('santri.editSantri', compact('santri', 'tahunajaran'));
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
            'id_halaqah' => 'nullable',
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
