<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\UjianTahfidz;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NilaiTahfidzController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar dengan eager loading relasi
       $query = Santri::with(['halaqah', 'ujianTahfidz.tahunAjaran']);

        // Filter berdasarkan search (nama santri)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        
        // Filter berdasarkan semester melalui relasi
        if ($request->filled('semester')) {
            $query->whereHas('tahunAjaran', function($q) use ($request) {
                $q->where('semester', $request->semester);
            
            });
        }


        // Filter berdasarkan tahun ajaran melalui relasi
        // ✔ Filter tahun ajaran dari relasi TahunAjaran
        if ($request->filled('tahun')) {
            $query->whereHas('tahunAjaran', function($q) use ($request) {
                $q->where('id_tahunAjaran', $request->tahun);
            
            });
        }
        
        $tahunList = \App\Models\TahunAjaran::orderBy('tahun', 'desc')->get();
        
        // Ambil data dengan pagination
        $santri = $query->orderBy('nama', 'asc')->paginate(4);

        // Return view dengan data
        return view('nilaiTahfidz.index', compact('santri', 'tahunList'));

    }

        public function show($id)
{
    // Ambil data santri dengan relasi halaqah & tahunAjaran
    $santri = Santri::with(['halaqah.pendidik', 'tahunAjaran'])
        ->findOrFail($id);

    // Ambil semua ujian tahfidz santri ini
    $ujianList = UjianTahfidz::where('nis', $santri->nis)
    ->with('tahunAjaran')
    ->orderBy('created_at', 'desc')
    ->get();


    // Hitung total kesalahan
    $totalTajwid = $ujianList->sum('tajwid');
    $totalItqan = $ujianList->sum('itqan');
    $totalKeseluruhan = $ujianList->sum('total_kesalahan');

    // 🔥 Tambahkan list tahun ajaran untuk dropdown
    $tahunAjaranList = \App\Models\TahunAjaran::orderBy('tahun', 'desc')->get();

    return view('nilaiTahfidz.detail', compact(
        'santri',
        'ujianList',
        'totalTajwid',
        'totalItqan',
        'totalKeseluruhan',
        'tahunAjaranList'
    ));
}


        public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|exists:santri,nis',
            'jenis_ujian' => 'required|in:UTS,UAS',
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
            'tahun_ajaran_id' => 'nullable|exists:tahunajaran,id_tahunAjaran',
            'sekali_duduk' => 'nullable|in:ya,tidak',

        ]);

        $validated['total_kesalahan'] = $validated['tajwid'] + $validated['itqan'];

        UjianTahfidz::create($validated);

        return redirect()->back()->with('success', 'Data ujian berhasil ditambahkan!');
    }

        public function edit($id)
    {
        $ujian = UjianTahfidz::findOrFail($id);
        return view('nilaiTahfidz.edit', compact('ujian'));
    }

        public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenis_ujian' => 'required|in:UTS,UAS',
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
            'tahun_ajaran_id' => 'nullable|exists:tahunajaran,id_tahunAjaran',
            'sekali_duduk' => 'nullable|in:ya,tidak',
        ]);

        $validated['total_kesalahan'] = $validated['tajwid'] + $validated['itqan'];

        $ujian = UjianTahfidz::findOrFail($id);
        $ujian->update($validated);

        return redirect()->route('nilaiTahfidz.show', $ujian->nis)
                         ->with('success', 'Data ujian berhasil diperbarui!');
    }

        public function destroy($id)
    {
        $ujian = UjianTahfidz::findOrFail($id);
        $nis = $ujian->nis;
        $ujian->delete();

        return redirect()->route('nilaiTahfidz.show', $nis)
                         ->with('success', 'Data ujian berhasil dihapus!');
    }

  

    

}
