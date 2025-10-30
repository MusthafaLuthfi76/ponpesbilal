<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $tahunajaran = TahunAjaran::orderBy('id_tahunAjaran', 'desc')->get();
        return view('tahunajaran.indexthnajar', compact('tahunajaran'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:20',
            'semester' => 'required|string|max:50',
        ]);

        TahunAjaran::create($validated);

        return redirect()->route('tahunajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan!');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tahun' => 'required|string|max:20',
            'semester' => 'required|string|max:50',
        ]);

        $tahunajaran = TahunAjaran::findOrFail($id);
        $tahunajaran->update($validated);

        return redirect()->route('tahunajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui!');
    }

    // Hapus data
    public function destroy($id)
    {
        $tahunajaran = TahunAjaran::findOrFail($id);
        $tahunajaran->delete();

        return redirect()->route('tahunajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus!');
    }
}
