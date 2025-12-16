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
            'nilaiKesantrian',
            'tahunAjaran'
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
        // PERHITUNGAN NILAI TAHFIDZ
        // ================
        $nilaiTahfidzData = $this->hitungNilaiTahfidz($santri);
        
        // ================
        // LIST JUZ YANG DIUJIKAN
        // ================
        $daftarJuzDiuji = $santri->ujianTahfidz
            ->pluck('juz')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->implode(', ');

        // ================
        // LOAD PDF
        // ================
        $pdf = Pdf::loadView('rapor.pdf', [
            'santri'               => $santri,
            'nilaiAkademik'        => $nilaiAkademik,
            'nilaiKesantrian'      => $nilaiKesantrianFormatted,

            // Variabel Setoran
            'totalHalaman'         => $totalHalaman,
            'daftarHalaman'        => $daftarHalaman,
            'daftarJuz'            => $daftarJuz,

            // VARIABEL NILAI TAHFIDZ SAJA (TANPA TAHSIN)
            'nilaiTahfidz'         => $nilaiTahfidzData['nilai_akhir'],
            'nilaiHurufTahfidz'    => $nilaiTahfidzData['nilai_huruf'],
            'totalJuzDiuji'        => $nilaiTahfidzData['total_juz'],
            'targetJuz'            => $nilaiTahfidzData['target_juz'],
            'totalKesalahan'       => $nilaiTahfidzData['total_kesalahan'],
            'nilaiMaksimal'        => $nilaiTahfidzData['nilai_maksimal'],
            
            // LIST JUZ YANG DIUJIKAN
            'daftarJuzDiuji'       => $daftarJuzDiuji,
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
            'nilaiKesantrian',
            'tahunAjaran'
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

            // HITUNG NILAI TAHFIDZ SAJA
            $nilaiTahfidzData = $this->hitungNilaiTahfidz($santri);
            
            // LIST JUZ YANG DIUJIKAN
            $daftarJuzDiuji = $santri->ujianTahfidz
                ->pluck('juz')
                ->filter()
                ->unique()
                ->sort()
                ->values()
                ->implode(', ');

            // Render view untuk santri ini
            $html .= view('rapor.pdf', [
                'santri'               => $santri,
                'nilaiAkademik'        => $santri->nilaiAkademik,
                'nilaiKesantrian'      => $nilaiKesantrianFormatted,
                'totalHalaman'         => $totalHalaman,
                'daftarHalaman'        => $daftarHalaman,
                'daftarJuz'            => $daftarJuz,

                // VARIABEL NILAI TAHFIDZ SAJA (TANPA TAHSIN)
                'nilaiTahfidz'         => $nilaiTahfidzData['nilai_akhir'],
                'nilaiHurufTahfidz'    => $nilaiTahfidzData['nilai_huruf'],
                'totalJuzDiuji'        => $nilaiTahfidzData['total_juz'],
                'targetJuz'            => $nilaiTahfidzData['target_juz'],
                'totalKesalahan'       => $nilaiTahfidzData['total_kesalahan'],
                'nilaiMaksimal'        => $nilaiTahfidzData['nilai_maksimal'],
                
                // LIST JUZ YANG DIUJIKAN
                'daftarJuzDiuji'       => $daftarJuzDiuji,
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
     * METHOD: Hitung Nilai Tahfidz
     * 
     * @param  \App\Models\Santri  $santri
     * @return array
     */
    private function hitungNilaiTahfidz($santri)
    {
        // 1️⃣ Ambil data ujian tahfidz
        $ujianTahfidz = $santri->ujianTahfidz;

        // 2️⃣ Hitung total juz & kesalahan
        $totalJuz = $ujianTahfidz->pluck('juz')->filter()->unique()->count();
        $totalKesalahan = $ujianTahfidz->sum('total_kesalahan');

        // 3️⃣ Tentukan target juz berdasarkan semester, kelas, jenjang
        $targetJuz = $this->getTargetJuz($santri);

        // 4️⃣ Hitung nilai maksimal berdasarkan selisih
        $selisih = max(0, $targetJuz - $totalJuz);

        $nilaiMaks = match (true) {
            $selisih === 0 => 100,
            $selisih === 1 => 90,
            $selisih <= 3  => 80,
            default        => 70,
        };

        // 5️⃣ Pengurangan & nilai akhir
        $pengurangan = min($totalKesalahan, 20) * 0.5;
        $nilaiAkhir = max(0, $nilaiMaks - $pengurangan);

        // 6️⃣ Nilai huruf
        $nilaiHuruf = match (true) {
            $nilaiAkhir >= 90 => 'A',
            $nilaiAkhir >= 80 => 'B',
            $nilaiAkhir >= 70 => 'C',
            $nilaiAkhir >= 60 => 'D',
            default           => 'E',
        };

        return [
            'total_juz'       => $totalJuz,
            'target_juz'      => $targetJuz,
            'total_kesalahan' => $totalKesalahan,
            'nilai_maksimal'  => $nilaiMaks,
            'nilai_akhir'     => round($nilaiAkhir, 1), // 1 desimal
            'nilai_huruf'     => $nilaiHuruf,
        ];
    }

    /**
     * METHOD: Tentukan Target Juz
     * 
     * RUMUS BERDASARKAN CHAT WA:
     * - Semester GENAP: 2 juz (semua kelas)
     * - Semester GANJIL: 3 juz (semua kelas MTS & MA)
     * 
     * @param  \App\Models\Santri  $santri
     * @return int
     */
    private function getTargetJuz($santri)
    {
        // Cek apakah relasi tahunAjaran ada
        if (!$santri->tahunAjaran) {
            return 3; // Default semester ganjil
        }

        $semester = strtolower($santri->tahunAjaran->semester ?? '');

        // 🔹 SEMESTER GENAP → TARGET = 2 JUZ (untuk semua kelas)
        if ($semester === 'genap') {
            return 2;
        }

        // 🔹 SEMESTER GANJIL → TARGET = 3 JUZ (untuk semua kelas)
        // Sesuai chat WA: MTS kelas 1,2,3 dan MA kelas 1,2,3 = 3 juz
        return 3;
    }

    /**
     * Helper: Format nilai kesantrian dari database ke format PDF
     * 
     * @param  \App\Models\Santri  $santri
     * @return \Illuminate\Support\Collection
     */
    private function formatNilaiKesantrian($santri)
    {
        $nilaiKesantrian = $santri->nilaiKesantrian->first();

        if (!$nilaiKesantrian) {
            return collect();
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