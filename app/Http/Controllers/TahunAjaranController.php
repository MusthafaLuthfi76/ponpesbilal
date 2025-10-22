<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    // Menampilkan semua data tahun ajaran
    public function index()
    {
        $tahunajaran = TahunAjaran::all();
        return view('tahunajaran.indexthnajar', compact('tahunajaran'));
    }

    // Simpan data tahun ajaran baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:20',
            'semester' => 'required|string|max:50',
        ]);

        TahunAjaran::create($validated);

        return redirect()->route('tahunajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan!');
    }

    // Tampilkan form edit data tahun ajaran (opsional, kalau pakai modal bisa dihapus)
    public function edit(TahunAjaran $tahunajaran)
    {
        return view('tahunajaran.editthnajar', compact('tahunajaran'));
    }

    // Update data tahun ajaran
    public function update(Request $request, TahunAjaran $tahunajaran)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:20',
            'semester' => 'required|string|max:50',
        ]);

        $tahunajaran->update($validated);

        return redirect()->route('tahunajaran.index')->with('success', 'Tahun ajaran berhasil diperbarui!');
    }

    // Hapus data tahun ajaran
    public function destroy(TahunAjaran $tahunajaran)
    {
        $tahunajaran->delete();
        return redirect()->route('tahunajaran.index')->with('success', 'Tahun ajaran berhasil dihapus!');
    }
}
