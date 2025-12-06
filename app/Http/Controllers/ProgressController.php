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
        return view('progress.index');
    }

    // Proses pencarian & menampilkan hasil dalam card box
    public function search(Request $request)
    {
        $q = $request->q;
        $perPage = $request->get('per_page', 10); // Default 10 per halaman

        // Cari semua santri yang cocok dengan nama atau NIS dengan pagination
        $results = Santri::where('nis', $q)
            ->orWhere('nama', 'LIKE', "%$q%")
            ->paginate($perPage)
            ->appends(['q' => $q, 'per_page' => $perPage]);

        return view('progress.index', [
            'results' => $results,
            'searchQuery' => $q,
            'perPage' => $perPage
        ]);
    }

    // Menampilkan detail santri berdasarkan NIS
    public function show(Request $request, $nis)
    {
        $santri = Santri::where('nis', $nis)->first();

        if (!$santri) {
            return redirect()->route('progress.index')->with('error', 'Santri tidak ditemukan');
        }

        // Ambil setoran terakhir untuk menentukan bulan terakhir
        $setoranTerakhir = Setoran::where('nis', $santri->nis)
            ->orderBy('tanggal_setoran', 'desc')
            ->first();

        // Tentukan bulan akhir (bulan setoran terakhir atau bulan sekarang jika tidak ada setoran)
        $bulanAkhir = $setoranTerakhir 
            ? Carbon::parse($setoranTerakhir->tanggal_setoran)
            : now();

        // ---- DATA SETORAN BULANAN UNTUK GRAFIK ----
        $bulanCount = 6; // tampilkan 6 bulan terakhir dari setoran terakhir
        $bulanMulai = $bulanAkhir->copy()->subMonths($bulanCount - 1)->startOfMonth();

        $monthlyData = Setoran::where('nis', $santri->nis)
            ->selectRaw("SUM(halaman_akhir - halaman_awal + 1) as total_halaman, DATE_FORMAT(tanggal_setoran, '%Y-%m') as bulan")
            ->where('tanggal_setoran', '>=', $bulanMulai)
            ->where('tanggal_setoran', '<=', $bulanAkhir->copy()->endOfMonth())
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->get();

        // Format untuk Chart
        $labels = [];
        $values = [];

        // Isi semua bulan dari bulan mulai sampai bulan akhir
        for ($i = $bulanCount - 1; $i >= 0; $i--) {
            $bulan = $bulanAkhir->copy()->subMonths($i)->format('Y-m');
            $labels[] = Carbon::parse($bulan . '-01')->translatedFormat('F Y');

            $row = $monthlyData->firstWhere('bulan', $bulan);
            $values[] = $row ? (int) $row->total_halaman : 0;
        }

        // Data lain
        $latestJuzSetoran = Setoran::where('nis', $santri->nis)->max('juz');
        $latestJuzUjian = UjianTahfidz::where('nis', $santri->nis)->max('juz');
        $latestJuz = max($latestJuzSetoran, $latestJuzUjian);

        $bulanIni = $values[$bulanCount - 1];
        $bulanLalu = $values[$bulanCount - 2];

        if ($bulanLalu == 0 && $bulanIni > 0) $bedaPersen = 100;
        else if ($bulanLalu == 0 && $bulanIni == 0) $bedaPersen = 0;
        else $bedaPersen = round((($bulanIni - $bulanLalu) / $bulanLalu) * 100);

        // Pagination untuk timeline dengan pilihan per page
        $perPage = $request->get('per_page', 20); // Default 20 per halaman
        $timeline = Setoran::where('nis', $santri->nis)
            ->orderBy('tanggal_setoran', 'desc')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('progress.index', [
            'santri' => $santri,
            'latestJuz' => $latestJuz,
            'bulanIni' => $bulanIni,
            'bulanLalu' => $bulanLalu,
            'bedaPersen' => $bedaPersen,
            'timeline' => $timeline,
            'chartLabels' => $labels,
            'chartValues' => $values,
            'perPage' => $perPage,
            'bulanMulai' => $bulanMulai->translatedFormat('F Y'),
            'bulanAkhir' => $bulanAkhir->translatedFormat('F Y')
        ]);
    }
}