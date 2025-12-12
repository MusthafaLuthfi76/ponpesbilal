<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Santri;
use App\Models\MataPelajaran;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah berdasarkan status santri
        $santri_mts = Santri::where('status', 'MTS')->count();
        $santri_ma = Santri::where('status', 'MA')->count();
        $alumni = Santri::where('status', 'Alumni')->count();

        // Hitung jumlah mata pelajaran
        $mata_pelajaran = MataPelajaran::count();

        $stats = [
            'santri_ma'        => $santri_ma,
            'santri_mts'       => $santri_mts,
            'alumni'           => $alumni,
            'mata_pelajaran'   => $mata_pelajaran,
        ];

        return view('dashboard', [
            'user' => Auth::user(),
            'stats' => $stats,
        ]);
    }
}
