<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Pendidik;
use Illuminate\Http\Request;
use App\Models\KelompokHalaqah;

class HalaqahController extends Controller
{
    public function index()
    {
        $pendidik = Pendidik::all();
        $kelompok = KelompokHalaqah::paginate(10);

        return view('halaqah.index', compact('kelompok', 'pendidik'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required|max:100',
            'id_pendidik' => 'required|exists:pendidik,id_pendidik',
        ]);

        KelompokHalaqah::create($request->only(['nama_kelompok', 'id_pendidik']));
        return redirect()->back()->with('success', 'Kelompok berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok' => 'required|max:100',
            'id_pendidik' => 'required|exists:pendidik,id_pendidik',
        ]);

        KelompokHalaqah::findOrFail($id)->update($request->only(['nama_kelompok', 'id_pendidik']));
        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KelompokHalaqah::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function show($id)
    {
        $kelompok = KelompokHalaqah::with('pendidik')->findOrFail($id);
        $santri = Santri::where('id_halaqah', $id)->paginate(5);
        $availableSantri = Santri::whereNull('id_halaqah')->orWhere('id_halaqah', '!=', $id)->get();
        $allKelompok = KelompokHalaqah::all();

        return view('halaqah.show', compact('kelompok', 'santri', 'availableSantri', 'allKelompok'));
    }

    public function removeSantri($id_halaqah, $nis)
    {
        try {
            // Cari santri berdasarkan NIS
            $santri = \App\Models\Santri::where('nis', $nis)->firstOrFail();

            // Set id_halaqah menjadi null
            $santri->id_halaqah = null;
            $santri->save();

            return redirect()
                ->route('halaqah.show', $id_halaqah)
                ->with('success', 'Santri berhasil dikeluarkan dari kelompok halaqah');
        } catch (\Exception $e) {
            return redirect()
                ->route('halaqah.show', $id_halaqah)
                ->with('error', 'Gagal mengeluarkan santri: ' . $e->getMessage());
        }
    }

    // Method untuk menampilkan halaman tambah santri
    public function showAddSantri($id_halaqah)
    {
        $kelompok = KelompokHalaqah::findOrFail($id_halaqah);

        // Ambil santri yang belum punya kelompok (halaqah_id = null)
        $santri = \App\Models\Santri::whereNull('id_halaqah')
            ->orderBy('nama', 'asc')
            ->get();

        return view('halaqah.add-santri', compact('kelompok', 'santri'));
    }

    // Method untuk proses tambah santri
    // Method untuk proses tambah santri (support multiple)
    public function addSantri(Request $request, $id_halaqah)
    {
        $request->validate([
            'santri' => 'required|array|min:1',
            'santri.*' => 'exists:santri,nis'
        ], [
            'santri.required' => 'Pilih minimal 1 santri',
            'santri.min' => 'Pilih minimal 1 santri'
        ]);

        try {
            $successCount = 0;
            $errorCount = 0;

            foreach ($request->santri as $nis) {
                $santri = \App\Models\Santri::where('nis', $nis)->first();

                if ($santri && $santri->id_halaqah === null) {
                    $santri->id_halaqah = $id_halaqah;
                    $santri->save();
                    $successCount++;
                } else {
                    $errorCount++;
                }
            }

            if ($successCount > 0) {
                return redirect()
                    ->route('halaqah.show', $id_halaqah)
                    ->with('success', "{$successCount} santri berhasil ditambahkan ke kelompok halaqah");
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Gagal menambahkan santri. Santri mungkin sudah memiliki kelompok.');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan santri: ' . $e->getMessage());
        }
    }
}
