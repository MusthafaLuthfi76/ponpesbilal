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
                $q->where('id', $request->tahun);

            
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

        // Tambahkan nilai angka & huruf otomatis
        foreach ($ujianList as $u) {
            $kesalahan = $u->total_kesalahan;

            // Nilai angka skala 1–100
            // Setiap 1 kesalahan = dikurangi 1 poin
            $u->nilai_angka = max(0, 100 - $kesalahan);

            // Konversi ke huruf
            if ($u->nilai_angka >= 90) {
                $u->nilai_huruf = 'A';
            } elseif ($u->nilai_angka >= 80) {
                $u->nilai_huruf = 'B';
            } elseif ($u->nilai_angka >= 70) {
                $u->nilai_huruf = 'C';
            } else {
                $u->nilai_huruf = 'D';
            }
        }

        // Hitung total kesalahan
        $totalTajwid = $ujianList->sum('tajwid');
        $totalItqan = $ujianList->sum('itqan');
        $totalKeseluruhan = $ujianList->sum('total_kesalahan');

        // Dropdown tahun ajaran
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

    /**
     * Menyimpan data ujian tahfidz baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'tahunAjaran' => 'required',
            'jenis_ujian' => 'required',
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
            'sekali_duduk' => 'required'
        ]);

        // Hitung total kesalahan (tajwid + itqan)
        $totalKesalahan = $request->tajwid + $request->itqan;

        UjianTahfidz::create([
            'nis' => $request->nis,
            'tahun_ajaran_id' => $request->tahunAjaran,
            'jenis_ujian' => $request->jenis_ujian,
            'juz' => $request->juz,
            'tajwid' => $request->tajwid,
            'itqan' => $request->itqan,
            'total_kesalahan' => $totalKesalahan,
            'sekali_duduk' => $request->sekali_duduk
        ]);

        return redirect()
            ->route('nilaiTahfidz.show', $request->nis)
            ->with('success', 'Data nilai tahfidz berhasil ditambahkan');
    }

    /**
     * Update data ujian tahfidz
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'jenis_ujian' => 'required|string|in:UTS,UAS',
            'juz' => 'required|integer|min:1|max:30',
            'tajwid' => 'required|integer|min:0',
            'itqan' => 'required|integer|min:0',
            'sekali_duduk' => 'required|in:ya,tidak',
        ]);

        // Hitung total kesalahan (tajwid + itqan)
        $validated['total_kesalahan'] = $validated['tajwid'] + $validated['itqan'];

        // Cari data ujian berdasarkan ID
        $ujianTahfidz = UjianTahfidz::findOrFail($id);

        // Update data
        $ujianTahfidz->update($validated);

        // Redirect kembali ke halaman detail santri
        return redirect()
            ->route('nilaiTahfidz.show', $ujianTahfidz->nis)
            ->with('success', 'Data nilai tahfidz berhasil diupdate');
    }

    /**
     * Menampilkan form edit (opsional)
     */
    public function edit($id)
    {
        $ujianTahfidz = UjianTahfidz::with('santri')->findOrFail($id);
        $tahunAjaranList = \App\Models\TahunAjaran::orderBy('tahun', 'desc')->get();
        
        return view('nilaiTahfidz.edit', compact('ujianTahfidz', 'tahunAjaranList'));
    }

    /**
     * Menghapus data ujian tahfidz
     */
    public function destroy($id)
    {
        // Cari data ujian berdasarkan ID
        $ujianTahfidz = UjianTahfidz::findOrFail($id);
        
        // Simpan NIS untuk redirect
        $nis = $ujianTahfidz->nis;
        
        // Hapus data
        $ujianTahfidz->delete();

        // Redirect kembali ke halaman detail santri
        return redirect()
            ->route('nilaiTahfidz.show', $nis)
            ->with('success', 'Data nilai tahfidz berhasil dihapus');
    }
}