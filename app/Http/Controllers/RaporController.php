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
        'ujianTahfidz'
    ])
    ->where('nis', $nis)
    ->firstOrFail();

    // Ambil nilai akademik secara rapi
    $nilaiAkademik = $santri->nilaiAkademik;

    // Jika ada section nilai kesantrian (opsional)
    $nilaiKesantrian = collect();

    $pdf = Pdf::loadView('rapor.pdf', compact(
        'santri',
        'nilaiAkademik',
        'nilaiKesantrian'
    ));

    return $pdf->stream('Rapor_' . $santri->nama . '.pdf');
}

    
}
