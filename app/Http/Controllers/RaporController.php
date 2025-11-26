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
    // Pakai eager loading untuk ambil seluruh relasi
    $santri = Santri::with(['nilaiAkademik', 'ujianTahfidz'])
                    ->where('nis', $nis)
                    ->firstOrFail();

    $nilaiKesantrian = collect(); // masih kosong

    $pdf = Pdf::loadView('rapor.pdf', compact(
        'santri',
        'nilaiKesantrian'
    ));

    return $pdf->stream('Rapor_' . $santri->nama . '.pdf');
}

    
}
