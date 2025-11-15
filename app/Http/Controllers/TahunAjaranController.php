<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TahunAjaranController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $tahunajaran = TahunAjaran::orderBy('id_tahunAjaran', 'desc')
                ->paginate(10); // <<< tampil 10 data per halaman

        return view('tahunajaran.indexthnajar', compact('tahunajaran'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tahunajaran')->where(function ($q) use ($request) {
                    return $q->where('semester', $request->semester);
                }),
            ],
            'semester' => 'required|string|max:50',
        ],
        [
            'tahun.unique' => 'Tahun dan semester ini sudah terdaftar.'
        ]);

        TahunAjaran::create($validated);

        return redirect()->route('tahunajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan!');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tahun' => [
                'required',
                'string',
                'max:20',
                Rule::unique('tahunajaran')
                    ->where(function ($q) use ($request) {
                        return $q->where('semester', $request->semester);
                    })
                    ->ignore($id, 'id_tahunAjaran')
            ],
            'semester' => 'required|string|max:50',
        ],
        [
            'tahun.unique' => 'Tahun dan semester ini sudah terdaftar.'
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
