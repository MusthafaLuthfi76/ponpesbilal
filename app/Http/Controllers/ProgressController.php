<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Setoran;
use App\Models\UjianTahfidz;
use Carbon\Carbon;
use DB;

class ProgressController extends Controller
{
    // Menampilkan halaman pencarian (form)
    public function index()
    {
        return view('progress.index'); // form pencarian
        
    }

    // Proses pencarian & menampilkan hasil progress
    public function search(Request $request)
{
    $q = $request->q;

    $santri = Santri::where('nis', $q)
        ->orWhere('nama', 'LIKE', "%$q%")
        ->first();

    if (!$santri) {
        return view('progress.index', [
            'results' => [],
        ]);
    }

    // ---- DATA SETORAN BULANAN UNTUK GRAFIK ----
    $bulanCount = 6; // tampilkan 6 bulan terakhir

    $monthlyData = Setoran::where('nis', $santri->nis)
        ->selectRaw("SUM(halaman) as total_halaman, DATE_FORMAT(tanggal_setoran, '%Y-%m') as bulan")
        ->where('tanggal_setoran', '>=', now()->subMonths($bulanCount - 1)->startOfMonth())
        ->groupBy('bulan')
        ->orderBy('bulan', 'asc')
        ->get();

    // Format untuk Chart.js
    $labels = [];
    $values = [];

    // Isi semua bulan (agar tidak bolong)
    for ($i = $bulanCount - 1; $i >= 0; $i--) {
        $bulan = now()->subMonths($i)->format('Y-m');
        $labels[] = Carbon::parse($bulan . '-01')->translatedFormat('F Y');

        $row = $monthlyData->firstWhere('bulan', $bulan);
        $values[] = $row ? (int) $row->total_halaman : 0;
    }

    // Data lain seperti sebelumnya…
    // -------------------------------
    $latestJuzSetoran = Setoran::where('nis', $santri->nis)->max('juz');
    $latestJuzUjian = UjianTahfidz::where('nis', $santri->nis)->max('juz');
    $latestJuz = max($latestJuzSetoran, $latestJuzUjian);

    $bulanIni = $values[$bulanCount - 1];
    $bulanLalu = $values[$bulanCount - 2];

    if ($bulanLalu == 0 && $bulanIni > 0) $bedaPersen = 100;
    else if ($bulanLalu == 0 && $bulanIni == 0) $bedaPersen = 0;
    else $bedaPersen = round((($bulanIni - $bulanLalu) / $bulanLalu) * 100);

    $timeline = Setoran::where('nis', $santri->nis)
        ->orderBy('tanggal_setoran', 'desc')
        ->take(20)
        ->get();

    return view('progress.index', [
        'santri' => $santri,
        'latestJuz' => $latestJuz,
        'bulanIni' => $bulanIni,
        'bulanLalu' => $bulanLalu,
        'bedaPersen' => $bedaPersen,
        'timeline' => $timeline,
        'chartLabels' => $labels,
        'chartValues' => $values
    ]);
}

}
