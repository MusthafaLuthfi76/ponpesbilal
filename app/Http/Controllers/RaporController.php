<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\NilaiAkademik;
use App\Models\UjianTahfidz;
use Barryvdh\DomPDF\Facade\Pdf;

class RaporController extends Controller
{
    public function index()
    {
        $query = Santri::query();

        // Filter berdasarkan nama (hanya jika search tidak kosong)
        if (request()->has('search') && request('search') !== '') {
            $search = request('search');
            $query->where('nama', 'LIKE', "%{$search}%");
        }

        // Ambil data santri
        $santri = $query->orderBy('nama', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        return view('rapor.index', compact('santri'));
    }

   public function cetak($nis)
{
    $santri = Santri::with([
        'nilaiAkademik.mataPelajaran',
        'ujianTahfidz',
        'setoran'
    ])
    ->where('nis', $nis)
    ->firstOrFail();

    // ================
    // NILAI AKADEMIK
    // ================
    $nilaiAkademik = $santri->nilaiAkademik;

    // ================
    // NILAI KESANTRIAN (optional)
    // ================
    $nilaiKesantrian = collect();

    // ================
    // BAGIAN SETORAN
    // ================
    $setoran = $santri->setoran;

    // Total halaman (contoh: 12–15 → 4 halaman)
    $totalHalaman = $setoran->sum(function($s){
        if ($s->halaman_awal && $s->halaman_akhir) {
            return ($s->halaman_akhir - $s->halaman_awal + 1);
        }
        return 0;
    });

    // List halaman untuk ditampilkan (contoh: 12–15, 20–25)
    $daftarHalaman = $setoran->map(function($s){
        if ($s->halaman_awal && $s->halaman_akhir) {
            return $s->halaman_awal . '–' . $s->halaman_akhir;
        }
        return null;
    })
    ->filter()
    ->implode(', ');

    // Daftar Juz unik: "29, 30"
    $daftarJuz = $setoran->pluck('juz')
        ->unique()
        ->filter()
        ->implode(', ');

    if ($daftarJuz == '') {
        $daftarJuz = '-';
    }

    // ================
    // LOAD PDF
    // ================
    $pdf = Pdf::loadView('rapor.pdf', [
        'santri'          => $santri,
        'nilaiAkademik'   => $nilaiAkademik,
        'nilaiKesantrian' => $nilaiKesantrian,

        // Variabel tambahan untuk Bagian Tahfizh
        'totalHalaman'    => $totalHalaman,
        'daftarHalaman'   => $daftarHalaman,
        'daftarJuz'       => $daftarJuz,
    ]);

    return $pdf->stream('Rapor_' . $santri->nama . '.pdf');
}
}