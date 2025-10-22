<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index()
    {
        $santri = Santri::all();
        $tahunajaran = TahunAjaran::all(); // <- ambil data tahun ajaran
        return view('santri.homeSantri', compact('santri', 'tahunajaran'));
    }

    public function create()
    {
        $tahunajaran = TahunAjaran::all();
        return view('santri.index', compact('tahunajaran'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'angkatan' => 'nullable|string|max:100',
            'status' => 'required|string',
        ]);

        Santri::create($validated);
        return redirect()->route('santri.index')->with('success', 'Data santri berhasil ditambahkan!');
    }

    public function edit(Santri $santri)
    {
        return view('santri.editSantri', compact('santri'));
    }

    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'angkatan' => 'nullable|string|max:100',
            'status' => 'required|string',
        ]);

        $santri->update($validated);
        return redirect()->route('santri.index')->with('success', 'Data santri berhasil diperbarui!');
    }

    public function destroy(Santri $santri)
    {
        $santri->delete();
        return redirect()->route('santri.index')->with('success', 'Data santri berhasil dihapus!');
    }
}
