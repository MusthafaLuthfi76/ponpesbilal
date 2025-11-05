<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Santri;
use Illuminate\Http\Request;

class SetoranController extends Controller
{
    // Menampilkan halaman setoran santri
    public function index($nis)
    {
        $santri = Santri::where('nis', $nis)->firstOrFail();
        $setoran = Setoran::where('nis', $nis)
            ->orderBy('tanggal_setoran', 'desc')
            ->get();

        return view('halaqah.setoran', compact('santri', 'setoran'));
    }

    // Menyimpan setoran baru
    public function store(Request $request, $nis)
    {
        $request->validate([
            'tanggal_setoran' => 'required|date',
            'juz' => 'nullable|string|max:10',
            'surah' => 'required|string|max:100',
            'ayat' => 'required|string|max:50',
            'status' => 'required|in:Lancar,Kurang Lancar,Tidak Lancar',
            'catatan' => 'nullable|string'
        ]);

        try {
            Setoran::create([
                'nis' => $nis,
                'tanggal_setoran' => $request->tanggal_setoran,
                'juz' => $request->juz,
                'surah' => $request->surah,
                'ayat' => $request->ayat,
                'status' => $request->status,
                'catatan' => $request->catatan
            ]);

            return redirect()
                ->route('setoran.index', $nis)
                ->with('success', 'Setoran berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan setoran: ' . $e->getMessage());
        }
    }

    // Update setoran
    public function update(Request $request, $nis, $id_setoran)
    {
        $request->validate([
            'tanggal_setoran' => 'required|date',
            'juz' => 'nullable|string|max:10',
            'surah' => 'required|string|max:100',
            'ayat' => 'required|string|max:50',
            'status' => 'required|in:Lancar,Kurang Lancar,Tidak Lancar',
            'catatan' => 'nullable|string'
        ]);

        try {
            $setoran = Setoran::where('id_setoran', $id_setoran)
                ->where('nis', $nis)
                ->firstOrFail();

            $setoran->update([
                'tanggal_setoran' => $request->tanggal_setoran,
                'juz' => $request->juz,
                'surah' => $request->surah,
                'ayat' => $request->ayat,
                'status' => $request->status,
                'catatan' => $request->catatan
            ]);

            return redirect()
                ->route('setoran.index', $nis)
                ->with('success', 'Setoran berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memperbarui setoran: ' . $e->getMessage());
        }
    }

    // Delete setoran
    public function destroy($nis, $id_setoran)
    {
        try {
            $setoran = Setoran::where('id_setoran', $id_setoran)
                ->where('nis', $nis)
                ->firstOrFail();

            $setoran->delete();

            return redirect()
                ->route('setoran.index', $nis)
                ->with('success', 'Setoran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus setoran: ' . $e->getMessage());
        }
    }
}
