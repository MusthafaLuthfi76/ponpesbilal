<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Example static stats; can be replaced with real data later.
        $stats = [
            'santri_ma' => 176,
            'santri_mts' => 145,
            'alumni' => 245,
            'mata_pelajaran' => 20,
        ];

        return view('dashboard', [
            'user' => Auth::user(),
            'stats' => $stats,
        ]);
    }
}