<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Pendidik;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $tahunId = $request->input('tahun');

        $query = MataPelajaran::with('tahunAjaran');
        if ($q) {
            $query->where(function($w) use ($q){
                $w->where('id_matapelajaran','like',"%$q%")
                ->orWhere('nama_matapelajaran','like',"%$q%");
            });
        }
        if ($tahunId) {
            $query->where('id_tahunAjaran', $tahunId);
        }

        $mataPelajaran = $query->orderBy('id_matapelajaran')->paginate(10)->appends($request->query());
        $tahunAjaran = TahunAjaran::orderBy('tahun')->get();

        return view('matapelajaran.index', compact('mataPelajaran', 'tahunAjaran', 'tahunId', 'q'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_matapelajaran' => ['required', 'integer', 'unique:matapelajaran,id_matapelajaran'],
            'nama_matapelajaran' => ['required', 'string', 'max:100'],
            'kkm' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_UTS' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_UAS' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_praktik' => ['required', 'numeric', 'min:0', 'max:100'],
            'id_pendidik' => ['nullable', 'exists:pendidik,id_pendidik'],
            'id_tahunAjaran' => ['required', 'exists:tahunajaran,id_tahunAjaran'],
        ]);

        MataPelajaran::create($data);
        return redirect()->route('matapelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);

        $data = $request->validate([
            'nama_matapelajaran' => ['required', 'string', 'max:100'],
            'kkm' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_UTS' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_UAS' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_praktik' => ['required', 'numeric', 'min:0', 'max:100'],
            'id_pendidik' => ['nullable', 'exists:pendidik,id_pendidik'],
            'id_tahunAjaran' => ['required', 'exists:tahunajaran,id_tahunAjaran'],
        ]);

        $mataPelajaran->update($data);
        return redirect()->route('matapelajaran.index')->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()->route('matapelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus');
    }
}
