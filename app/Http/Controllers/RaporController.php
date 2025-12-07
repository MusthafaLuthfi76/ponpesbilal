<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\NilaiAkademik;
use App\Models\UjianTahfidz;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RaporController extends Controller
{
    public function index()
    {
        // Ambil semua angkatan untuk dropdown (TIDAK BOLEH TERFILTER)
        $angkatanList = Santri::distinct()
            ->whereNotNull('angkatan')
            ->where('angkatan', '!=', '')
            ->orderBy('angkatan', 'asc')
            ->pluck('angkatan');

        // Query utama santri
        $query = Santri::query();

        // Filter search
        if (request('search')) {
            $query->where('nama', 'LIKE', '%' . request('search') . '%');
        }

        // Filter angkatan
        if (request('angkatan')) {
            $query->where('angkatan', request('angkatan'));
        }

        // Ambil data santri
        $santri = $query->orderBy('nama', 'asc')
                        ->paginate(10)
                        ->appends(request()->query());

        return view('rapor.index', compact('santri', 'angkatanList'));
    }

    public function cetak($nis)
    {
        $santri = Santri::with([
            'nilaiAkademik.mataPelajaran',
            'ujianTahfidz',
            'setoran',
            'nilaiKesantrian' 
        ])
        ->where('nis', $nis)
        ->firstOrFail();

        // ================
        // NILAI AKADEMIK
        // ================
        $nilaiAkademik = $santri->nilaiAkademik;

        // ================
        // NILAI KESANTRIAN - TRANSFORM DATA
        // ================
        $nilaiKesantrianFormatted = $this->formatNilaiKesantrian($santri);

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
            'nilaiKesantrian' => $nilaiKesantrianFormatted, // ← PAKAI YANG SUDAH DIFORMAT

            // Variabel tambahan untuk Bagian Tahfizh
            'totalHalaman'    => $totalHalaman,
            'daftarHalaman'   => $daftarHalaman,
            'daftarJuz'       => $daftarJuz,
        ]);

        return $pdf->stream('Rapor_' . $santri->nama . '.pdf');
    }

    /**
     * Cetak bulk rapor (multiple santri sekaligus)
     */
    public function cetakBulk(Request $request)
    {
        // Validasi input
        $request->validate([
            'nis' => 'required|array|min:1',
            'nis.*' => 'required|exists:santri,nis'
        ], [
            'nis.required' => 'Pilih minimal 1 santri',
            'nis.min' => 'Pilih minimal 1 santri',
            'nis.*.exists' => 'Data santri tidak valid'
        ]);

        $nisList = $request->nis;
        
        // Ambil semua data santri yang dipilih
        $santriList = Santri::with([
            'nilaiAkademik.mataPelajaran',
            'ujianTahfidz',
            'setoran',
            'nilaiKesantrian'  
        ])
        ->whereIn('nis', $nisList)
        ->orderBy('nama', 'asc')
        ->get();

        // Generate HTML untuk setiap santri
        $html = '';
        foreach ($santriList as $index => $santri) {
            // Proses data setoran
            $setoran = $santri->setoran;

            // Total halaman
            $totalHalaman = $setoran->sum(function($s){
                if ($s->halaman_awal && $s->halaman_akhir) {
                    return ($s->halaman_akhir - $s->halaman_awal + 1);
                }
                return 0;
            });

            // List halaman
            $daftarHalaman = $setoran->map(function($s){
                if ($s->halaman_awal && $s->halaman_akhir) {
                    return $s->halaman_awal . '–' . $s->halaman_akhir;
                }
                return null;
            })
            ->filter()
            ->implode(', ');

            // Daftar Juz
            $daftarJuz = $setoran->pluck('juz')
                ->unique()
                ->filter()
                ->implode(', ');

            if ($daftarJuz == '') {
                $daftarJuz = '-';
            }

            // Transform nilai kesantrian
            $nilaiKesantrianFormatted = $this->formatNilaiKesantrian($santri);

            // Render view untuk santri ini
            $html .= view('rapor.pdf', [
                'santri'          => $santri,
                'nilaiAkademik'   => $santri->nilaiAkademik,
                'nilaiKesantrian' => $nilaiKesantrianFormatted, // ← PAKAI YANG SUDAH DIFORMAT
                'totalHalaman'    => $totalHalaman,
                'daftarHalaman'   => $daftarHalaman,
                'daftarJuz'       => $daftarJuz,
            ])->render();
            
            // Tambahkan page break kecuali untuk halaman terakhir
            if ($index < count($santriList) - 1) {
                $html .= '<div style="page-break-after: always;"></div>';
            }
        }

        // Generate PDF dari HTML gabungan
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        $timestamp = now()->format('YmdHis');
        $filename = "Rapor_Bulk_{$timestamp}.pdf";
        
        return $pdf->stream($filename);
    }

    /**
     * Helper: Format nilai kesantrian dari database ke format PDF
     * 
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Support\Collection
     */
    private function formatNilaiKesantrian($santri)
    {
        // Karena nilaiKesantrian adalah hasMany, ambil yang pertama saja
        // Atau bisa disesuaikan dengan logic bisnis kamu
        $nilaiKesantrian = $santri->nilaiKesantrian->first();

        if (!$nilaiKesantrian) {
            return collect(); // Return empty collection jika null
        }

        return collect([
            [
                'aspek' => 'Ibadah',
                'nilai' => $nilaiKesantrian->nilai_ibadah ?? '-',
                'keterangan' => $this->getKeteranganNilai($nilaiKesantrian->nilai_ibadah)
            ],
            [
                'aspek' => 'Akhlak',
                'nilai' => $nilaiKesantrian->nilai_akhlak ?? '-',
                'keterangan' => $this->getKeteranganNilai($nilaiKesantrian->nilai_akhlak)
            ],
            [
                'aspek' => 'Kerapian',
                'nilai' => $nilaiKesantrian->nilai_kerapian ?? '-',
                'keterangan' => $this->getKeteranganNilai($nilaiKesantrian->nilai_kerapian)
            ],
            [
                'aspek' => 'Kedisiplinan',
                'nilai' => $nilaiKesantrian->nilai_kedisiplinan ?? '-',
                'keterangan' => $this->getKeteranganNilai($nilaiKesantrian->nilai_kedisiplinan)
            ],
        ]);
    }

    /**
     * Helper: Konversi nilai huruf ke keterangan bahasa Arab
     * 
     * @param  string|null  $nilai
     * @return string
     */
    private function getKeteranganNilai($nilai)
{
    if (!$nilai || $nilai === '-') {
        return '-';
    }
    
    $nilai = strtoupper(trim($nilai));
    
    // HAPUS KURUNG - HANYA BAHASA ARAB/INDONESIA SAJA
    $keteranganMap = [
        'A'   => 'Mumtaz',
        'A-'  => 'Mumtaz',
        'B+'  => 'Jayyid Jiddan',
        'B'   => 'Jayyid Jiddan',
        'B-'  => 'Jayyid Jiddan',
        'C+'  => 'Jayyid',
        'C'   => 'Jayyid',
        'C-'  => 'Jayyid',
        'D'   => 'Maqbul',
        'E'   => 'Dha\'if',
    ];
    
    return $keteranganMap[$nilai] ?? $nilai;
}
}