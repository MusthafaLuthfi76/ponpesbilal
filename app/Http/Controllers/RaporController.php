<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\NilaiAkademik;
use App\Models\TahunAjaran;
use App\Models\UjianTahfidz;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RaporController extends Controller
{
    public function index(Request $request)
    {
        $angkatanList = Santri::distinct()
            ->whereNotNull('angkatan')
            ->where('angkatan', '!=', '')
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');

        // ✅ Filter hanya santri AKTIF (bukan alumni)
        $query = Santri::where('status', '!=', 'alumni')
            ->whereNotNull('status');

        if ($request->search) {
            $query->where('nama', 'LIKE', "%{$request->search}%");
        }
        if ($request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }

        $santri = $query->orderBy('nama', 'asc')
            ->paginate(10)
            ->appends($request->query());

        return view('rapor.index', compact('santri', 'angkatanList'))
            ->with('isAlumniPage', false); // default
    }

    public function indexAlumni(Request $request)
    {
        // Ambil semua angkatan (sama seperti index)
        $angkatanList = Santri::distinct()
            ->whereNotNull('angkatan')
            ->where('angkatan', '!=', '')
            ->orderBy('angkatan', 'asc')
            ->pluck('angkatan');

        // Query: hanya santri dengan status = 'alumni'
        $query = Santri::where('status', 'alumni');

        // Filter search & angkatan (sama seperti index)
        if ($request->search) {
            $query->where('nama', 'LIKE', "%{$request->search}%");
        }
        if ($request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }

        $santri = $query->orderBy('nama', 'desc')
            ->paginate(10)
            ->appends($request->query());

        return view('rapor.index', compact('santri', 'angkatanList'))
            ->with('isAlumniPage', true);
    }

    /**
     * Cetak rapor per santri, dengan dukungan multi-periode (UTS/UAS per tahun ajaran)
     *
     * @param string $nis
     * @param int|null $tahun_ajaran_id
     * @param string|null $jenis_ujian — 'uts' atau 'uas'
     * @return \Illuminate\Http\Response
     */
    public function cetak($nis, $tahun_ajaran_id = null, $jenis_ujian = null)
    {
        $santri = Santri::with([
            'nilaiAkademik.mataPelajaran',
            'nilaiAkademik.tahunAjaran',
            'ujianTahfidz.tahunAjaran',
            'setoran',
            'nilaiKesantrian',
            'tahunAjaran',
        ])->where('nis', $nis)->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | NILAI AKADEMIK (FILTER TAHUN & JENIS UJIAN)
        |--------------------------------------------------------------------------
        */
        $nilaiAkademik = $santri->nilaiAkademik->toBase();

        if ($tahun_ajaran_id) {
            $nilaiAkademik = $nilaiAkademik->filter(
                fn($n) => $n->id_tahunAjaran == $tahun_ajaran_id
            );
        }

        if ($nilaiAkademik->isEmpty()) {
            $latestTaId = $santri->nilaiAkademik->max('id_tahunAjaran');
            if ($latestTaId) {
                $nilaiAkademik = $santri->nilaiAkademik
                    ->filter(fn($n) => $n->id_tahunAjaran == $latestTaId);
                $tahun_ajaran_id = $latestTaId;
            }
        }

        $jenisUjianTampil = 'Gabungan';

        $nilaiAkademik = $nilaiAkademik->map(function ($item) use ($jenis_ujian, &$jenisUjianTampil) {
            // ... (logika map nilai tetap sama — tidak berubah) ...
            if ($jenis_ujian === 'uts') {
                $item->nilai = $item->nilai_UTS ?? 0;
                $item->nilai_display = $item->nilai_UTS ?? '-';
                $jenisUjianTampil = 'UTS';
                $nilaiAngka = $item->nilai;
                $item->predikat = match (true) {
                    $nilaiAngka >= 90 => 'A',
                    $nilaiAngka >= 80 => 'B',
                    $nilaiAngka >= 70 => 'C',
                    $nilaiAngka >= 60 => 'D',
                    default           => 'E',
                };
            } elseif ($jenis_ujian === 'uas') {
                $uts = $item->nilai_UTS ?? 0;
                $uas = $item->nilai_UAS ?? 0;
                $praktik = $item->nilai_praktik ?? 0;

                if ($item->nilai_rata_rata) {
                    $item->nilai = $item->nilai_rata_rata;
                    $item->nilai_display = number_format($item->nilai_rata_rata, 2);
                } else {
                    $nilaiAkhir = ($uts * 0.3) + ($uas * 0.4) + ($praktik * 0.3);
                    $item->nilai = round($nilaiAkhir, 2);
                    $item->nilai_display = number_format($nilaiAkhir, 2);
                }

                $jenisUjianTampil = 'UAS';

                if (!$item->predikat) {
                    $nilaiAngka = $item->nilai;
                    $item->predikat = match (true) {
                        $nilaiAngka >= 90 => 'A',
                        $nilaiAngka >= 80 => 'B',
                        $nilaiAngka >= 70 => 'C',
                        $nilaiAngka >= 60 => 'D',
                        default           => 'E',
                    };
                }
            } else {
                $uts = $item->nilai_UTS ?? 0;
                $uas = $item->nilai_UAS ?? 0;
                $praktik = $item->nilai_praktik ?? 0;

                if ($item->nilai_rata_rata) {
                    $item->nilai = $item->nilai_rata_rata;
                    $item->nilai_display = number_format($item->nilai_rata_rata, 2);
                } else {
                    $nilaiAkhir = ($uts * 0.3) + ($uas * 0.4) + ($praktik * 0.3);
                    $item->nilai = round($nilaiAkhir, 2);
                    $item->nilai_display = number_format($nilaiAkhir, 2);
                }

                if (!$item->predikat) {
                    $nilaiAngka = $item->nilai;
                    $item->predikat = match (true) {
                        $nilaiAngka >= 90 => 'A',
                        $nilaiAngka >= 80 => 'B',
                        $nilaiAngka >= 70 => 'C',
                        $nilaiAngka >= 60 => 'D',
                        default           => 'E',
                    };
                }
            }

            $item->materi_pelajaran = $item->mataPelajaran ? $item->mataPelajaran->materi_pelajaran : '';

            return $item;
        });

        /*
        |--------------------------------------------------------------------------
        | ✅ DAPATKAN TAHUN AJARAN & SEMESTER YANG AKTIF
        |--------------------------------------------------------------------------
        */
        $ta = null;
        if ($tahun_ajaran_id) {
            $ta = TahunAjaran::find($tahun_ajaran_id);
        }

        // Fallback: gunakan tahun ajaran terakhir dari nilai akademik
        if (!$ta && $nilaiAkademik->isNotEmpty()) {
            $taIdFromNilai = $nilaiAkademik->first()->id_tahunAjaran;
            $ta = TahunAjaran::find($taIdFromNilai);
        }

        // Jika tetap tidak ada, pakai relasi santri (terakhir)
        if (!$ta) {
            $ta = $santri->tahunAjaran;
        }

        // 🔥 INI YANG BARU: AMBIL SEMESTER DARI $ta YANG SUDAH DIFILTER
        $tahunAjaranLabel = $ta
            ? "{$ta->tahun} - " . ucfirst($ta->semester ?? '')
            : 'Tahun Ajaran Tidak Diketahui';
        $semesterTampil = $ta
            ? ucfirst($ta->semester ?? '-')
            : '-';

        /*
        |--------------------------------------------------------------------------
        | NILAI KESANTRIAN, SETORAN, TAHFIDZ, dll — tetap sama
        |--------------------------------------------------------------------------
        */
        $nilaiKesantrian = $this->formatNilaiKesantrian($santri, $jenis_ujian, $tahun_ajaran_id);

        $setoran = $santri->setoran;
        $totalHalaman = $setoran->sum(
            fn($s) => ($s->halaman_awal && $s->halaman_akhir)
                ? ($s->halaman_akhir - $s->halaman_awal + 1)
                : 0
        );
        $daftarHalaman = $setoran
            ->filter(fn($s) => $s->halaman_awal && $s->halaman_akhir)
            ->map(fn($s) => "{$s->halaman_awal}–{$s->halaman_akhir}")
            ->implode(', ') ?: '-';
        $daftarJuz = $setoran->pluck('juz')->unique()->filter()->implode(', ') ?: '-';

        $nilaiTahfidz = $this->hitungNilaiTahfidz($santri, $jenis_ujian, $tahun_ajaran_id);
        $daftarJuzDiuji = $this->getDaftarJuzDiuji($santri, $jenis_ujian, $tahun_ajaran_id);
        $sekaliDuduk = $this->cekSekaliDuduk($santri, $jenis_ujian, $tahun_ajaran_id);

        $totalSakit = 0;
        $totalIzin = 0;
        $totalGhaib = 0;
        if ($jenis_ujian === 'uts') {
            foreach ($nilaiAkademik as $nilai) {
                $totalSakit += $nilai->sakit_uts ?? 0;
                $totalIzin += $nilai->izin_uts ?? 0;
                $totalGhaib += $nilai->ghaib_uts ?? 0;
            }
        } else {
            foreach ($nilaiAkademik as $nilai) {
                $totalSakit += ($nilai->sakit_uts ?? 0) + ($nilai->sakit_uas ?? 0);
                $totalIzin += ($nilai->izin_uts ?? 0) + ($nilai->izin_uas ?? 0);
                $totalGhaib += ($nilai->ghaib_uts ?? 0) + ($nilai->ghaib_uas ?? 0);
            }
        }

        $kelasTampil = $this->ambilKelasDariNilai($nilaiAkademik);

        /*
        |--------------------------------------------------------------------------
        | ✅ GENERATE PDF — LEWATKAN $semesterTampil
        |--------------------------------------------------------------------------
        */
        $pdf = Pdf::loadView('rapor.pdf', [
            'santri'               => $santri,
            'nilaiAkademik'        => $nilaiAkademik,
            'nilaiKesantrian'      => $nilaiKesantrian,
            'kelasTampil'          => $kelasTampil,
            'semesterTampil'       => $semesterTampil, // ✅ BARU — INI KUNCI PERBAIKAN
            'totalHalaman'         => $totalHalaman,
            'daftarHalaman'        => $daftarHalaman,
            'daftarJuz'            => $daftarJuz,
            'nilaiTahfidz'         => $nilaiTahfidz['nilai_akhir'],
            'nilaiHurufTahfidz'    => $nilaiTahfidz['nilai_huruf'],
            'totalJuzDiuji'        => $nilaiTahfidz['total_juz'],
            'targetJuz'            => $nilaiTahfidz['target_juz'],
            'totalKesalahan'       => $nilaiTahfidz['total_kesalahan'],
            'nilaiMaksimal'        => $nilaiTahfidz['nilai_maksimal'],
            'daftarJuzDiuji'       => $daftarJuzDiuji,
            'sekaliDuduk'          => $sekaliDuduk,
            'tahunAjaranLabel'     => $tahunAjaranLabel,
            'jenisUjianTampil'     => $jenisUjianTampil,
            'totalSakit'           => $totalSakit,
            'totalIzin'            => $totalIzin,
            'totalGhaib'           => $totalGhaib,
            'jenisUjian'           => $jenis_ujian,
        ]);

        return $pdf->stream("Rapor_{$santri->nama}_{$jenisUjianTampil}.pdf");
    }

    /**
     * Cetak bulk rapor (multiple santri sekaligus)
     */
    public function cetakBulk(Request $request)
    {
        $request->validate([
            'nis' => 'required|array|min:1',
            'nis.*' => 'required|exists:santri,nis',
            'jenis_ujian' => 'nullable|in:uts,uas,null',
            'tahun_ajaran_id' => 'nullable|exists:tahunajaran,id_tahunAjaran'
        ]);

        $nisList = $request->nis;
        $jenis_ujian = $request->jenis_ujian;
        $tahun_ajaran_id_param = $request->tahun_ajaran_id;

        $santriList = Santri::with([
            'nilaiAkademik.mataPelajaran',
            'nilaiAkademik.tahunAjaran',
            'ujianTahfidz.tahunAjaran',
            'setoran',
            'nilaiKesantrian',
            'tahunAjaran'
        ])->whereIn('nis', $nisList)->orderBy('nama', 'asc')->get();

        $html = '';
        foreach ($santriList as $index => $santri) {
            $nilaiAkademik = $santri->nilaiAkademik;

            if ($tahun_ajaran_id_param) {
                $nilaiAkademik = $nilaiAkademik->filter(
                    fn($n) => $n->id_tahunAjaran == $tahun_ajaran_id_param
                );
            }

            $nilaiAkademik = $nilaiAkademik->map(function ($item) use ($jenis_ujian) {
                // ... (logika map tetap sama — tidak berubah) ...
                if ($jenis_ujian === 'uts') {
                    $item->nilai = $item->nilai_UTS ?? 0;
                    $item->nilai_display = $item->nilai_UTS ?? '-';
                    $item->predikat = match (true) {
                        ($item->nilai_UTS ?? 0) >= 90 => 'A',
                        ($item->nilai_UTS ?? 0) >= 80 => 'B',
                        ($item->nilai_UTS ?? 0) >= 70 => 'C',
                        ($item->nilai_UTS ?? 0) >= 60 => 'D',
                        default           => 'E',
                    };
                } else {
                    $uts = $item->nilai_UTS ?? 0;
                    $uas = $item->nilai_UAS ?? 0;
                    $praktik = $item->nilai_praktik ?? 0;

                    if ($item->nilai_rata_rata) {
                        $item->nilai = $item->nilai_rata_rata;
                        $item->nilai_display = number_format($item->nilai_rata_rata, 2);
                    } else {
                        $nilaiAkhir = ($uts * 0.3) + ($uas * 0.4) + ($praktik * 0.3);
                        $item->nilai = round($nilaiAkhir, 2);
                        $item->nilai_display = number_format($nilaiAkhir, 2);
                    }

                    if (!$item->predikat) {
                        $nilaiAngka = $item->nilai;
                        $item->predikat = match (true) {
                            $nilaiAngka >= 90 => 'A',
                            $nilaiAngka >= 80 => 'B',
                            $nilaiAngka >= 70 => 'C',
                            $nilaiAngka >= 60 => 'D',
                            default           => 'E',
                        };
                    }
                }

                $item->materi_pelajaran = $item->mataPelajaran ? $item->mataPelajaran->materi_pelajaran : '';
                return $item;
            });

            $setoran = $santri->setoran;
            $totalHalaman = $setoran->sum(
                fn($s) => $s->halaman_awal && $s->halaman_akhir
                    ? ($s->halaman_akhir - $s->halaman_awal + 1)
                    : 0
            );
            $daftarHalaman = $setoran
                ->filter(fn($s) => $s->halaman_awal && $s->halaman_akhir)
                ->map(fn($s) => "{$s->halaman_awal}–{$s->halaman_akhir}")
                ->implode(', ') ?: '-';
            $daftarJuz = $setoran->pluck('juz')->unique()->filter()->implode(', ') ?: '-';

            $nilaiKesantrian = $this->formatNilaiKesantrian($santri, $jenis_ujian, $tahun_ajaran_id_param);

            $nilaiTahfidz = $this->hitungNilaiTahfidz($santri, $jenis_ujian, $tahun_ajaran_id_param);
            $daftarJuzDiuji = $this->getDaftarJuzDiuji($santri, $jenis_ujian, $tahun_ajaran_id_param);
            $sekaliDuduk = $this->cekSekaliDuduk($santri, $jenis_ujian, $tahun_ajaran_id_param);

            $totalSakit = 0;
            $totalIzin = 0;
            $totalGhaib = 0;
            if ($jenis_ujian === 'uts') {
                foreach ($nilaiAkademik as $nilai) {
                    $totalSakit += $nilai->sakit_uts ?? 0;
                    $totalIzin += $nilai->izin_uts ?? 0;
                    $totalGhaib += $nilai->ghaib_uts ?? 0;
                }
            } else {
                foreach ($nilaiAkademik as $nilai) {
                    $totalSakit += ($nilai->sakit_uts ?? 0) + ($nilai->sakit_uas ?? 0);
                    $totalIzin += ($nilai->izin_uts ?? 0) + ($nilai->izin_uas ?? 0);
                    $totalGhaib += ($nilai->ghaib_uts ?? 0) + ($nilai->ghaib_uas ?? 0);
                }
            }

            $kelasTampil = $this->ambilKelasDariNilai($nilaiAkademik);

            // ✅ DAPATKAN SEMESTER YANG SESUAI — SAMA SEPERTI DI METHOD CETAK()
            $ta = $tahun_ajaran_id_param
                ? TahunAjaran::find($tahun_ajaran_id_param)
                : $santri->tahunAjaran;

            // Fallback: coba dari nilai akademik jika masih null
            if (!$ta && $nilaiAkademik->isNotEmpty()) {
                $taIdFromNilai = $nilaiAkademik->first()->id_tahunAjaran;
                $ta = TahunAjaran::find($taIdFromNilai);
            }

            $tahunAjaranLabel = $ta
                ? "{$ta->tahun} - " . ucfirst($ta->semester ?? '')
                : '-';
            $semesterTampil = $ta
                ? ucfirst($ta->semester ?? '-')
                : '-'; // ✅ BARU — digunakan di view

            $html .= view('rapor.pdf', [
                'santri'               => $santri,
                'nilaiAkademik'        => $nilaiAkademik,
                'nilaiKesantrian'      => $nilaiKesantrian,
                'kelasTampil'          => $kelasTampil,
                'semesterTampil'       => $semesterTampil, // ✅ BARU — LEWATKAN INI
                'totalHalaman'         => $totalHalaman,
                'daftarHalaman'        => $daftarHalaman,
                'daftarJuz'            => $daftarJuz,
                'nilaiTahfidz'         => $nilaiTahfidz['nilai_akhir'],
                'nilaiHurufTahfidz'    => $nilaiTahfidz['nilai_huruf'],
                'totalJuzDiuji'        => $nilaiTahfidz['total_juz'],
                'targetJuz'            => $nilaiTahfidz['target_juz'],
                'totalKesalahan'       => $nilaiTahfidz['total_kesalahan'],
                'nilaiMaksimal'        => $nilaiTahfidz['nilai_maksimal'],
                'daftarJuzDiuji'       => $daftarJuzDiuji,
                'sekaliDuduk'          => $sekaliDuduk,
                'tahunAjaranLabel'     => $tahunAjaranLabel,
                'jenisUjianTampil'     => $jenis_ujian === 'uts' ? 'UTS' : ($jenis_ujian === 'uas' ? 'UAS' : 'Gabungan'),
                'jenisUjian'           => $jenis_ujian,
                'totalIzin'            => $totalIzin,
                'totalSakit'           => $totalSakit,
                'totalGhaib'           => $totalGhaib,
            ])->render();

            if ($index < count($santriList) - 1) {
                $html .= '<div style="page-break-after: always;"></div>';
            }
        }

        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');

        $jenisLabel = $jenis_ujian === 'uts' ? 'UTS' : ($jenis_ujian === 'uas' ? 'UAS' : 'Gabungan');
        return $pdf->stream("Rapor_Bulk_{$jenisLabel}_" . now()->format('YmdHis') . ".pdf");
    }

    /**
     * METHOD: Ambil Kelas dari Nilai Akademik
     */
    private function ambilKelasDariNilai($nilaiAkademik)
    {
        return $nilaiAkademik->pluck('mataPelajaran.kelas')->unique()->first() ?? '-';
    }

    /**
     * METHOD: Hitung Nilai Tahfidz dengan filter jenis ujian
     */
    private function hitungNilaiTahfidz($santri, $jenis_ujian = null, $tahun_ajaran_id = null)
    {
        // Filter ujian tahfidz berdasarkan jenis ujian dan tahun ajaran
        $query = $santri->ujianTahfidz();

        // Filter berdasarkan tahun ajaran
        if ($tahun_ajaran_id) {
            $query->where('tahun_ajaran_id', $tahun_ajaran_id);
        }

        // Filter berdasarkan jenis ujian
        if ($jenis_ujian === 'uts') {
            $query->where('jenis_ujian', 'UTS');
        } elseif ($jenis_ujian === 'uas') {
            $query->where('jenis_ujian', 'UAS');
        }
        // Jika tidak ada filter jenis ujian, ambil semua (untuk gabungan)

        $ujianTahfidz = $query->get();

        // Jika tidak ada ujian
        if ($ujianTahfidz->isEmpty()) {
            $targetJuz = $this->getTargetJuz($santri);

            return [
                'total_juz'       => 0,
                'target_juz'      => $targetJuz,
                'total_kesalahan' => 0,
                'nilai_maksimal'  => 0,
                'nilai_akhir'     => 0,
                'nilai_huruf'     => '-',
            ];
        }

        // Hitung total juz & kesalahan
        $totalJuz = $ujianTahfidz
            ->pluck('juz')
            ->filter()
            ->unique()
            ->count();

        $totalKesalahan = $ujianTahfidz->sum('total_kesalahan');

        // Target juz
        $targetJuz = $this->getTargetJuz($santri);

        // Nilai maksimal berdasarkan pencapaian
        $selisih = max(0, $targetJuz - $totalJuz);

        $nilaiMaks = match (true) {
            $selisih === 0 => 100,
            $selisih === 1 => 90,
            $selisih <= 3  => 80,
            default        => 70,
        };

        // Hitung nilai akhir: Nilai maksimal dikurangi kesalahan
        // Setiap kesalahan mengurangi 0.5 poin (maksimal 10 poin pengurangan)
        $pengurangan = min($totalKesalahan, 20) * 0.5; // Maks 10 poin pengurangan
        $nilaiAkhir = max(0, $nilaiMaks - $pengurangan);

        // Nilai huruf
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
            'nilai_akhir'     => round($nilaiAkhir, 1),
            'nilai_huruf'     => $nilaiHuruf,
        ];
    }

    /**
     * METHOD: Tentukan Target Juz
     */
    private function getTargetJuz($santri)
    {
        if (!$santri->tahunAjaran) {
            return 3; // Default semester ganjil
        }

        $semester = strtolower($santri->tahunAjaran->semester ?? '');

        if ($semester === 'genap') {
            return 2;
        }

        return 3;
    }

    /**
     * METHOD: Cek Status Sekali Duduk dengan filter
     */
    private function cekSekaliDuduk($santri, $jenis_ujian = null, $tahun_ajaran_id = null)
    {
        // Filter ujian tahfidz berdasarkan jenis ujian dan tahun ajaran
        $query = $santri->ujianTahfidz();

        // Filter berdasarkan tahun ajaran
        if ($tahun_ajaran_id) {
            $query->where('tahun_ajaran_id', $tahun_ajaran_id);
        }

        // Filter berdasarkan jenis ujian
        if ($jenis_ujian === 'uts') {
            $query->where('jenis_ujian', 'UTS');
        } elseif ($jenis_ujian === 'uas') {
            $query->where('jenis_ujian', 'UAS');
        }

        $ujianTahfidz = $query->get();

        if ($ujianTahfidz->isEmpty()) {
            return '-';
        }

        $jumlahYa = $ujianTahfidz->filter(function ($ujian) {
            return strtolower($ujian->sekali_duduk) === 'ya';
        })->count();

        $jumlahTidak = $ujianTahfidz->filter(function ($ujian) {
            return strtolower($ujian->sekali_duduk) === 'tidak';
        })->count();

        if ($jumlahYa > $jumlahTidak) {
            return 'Ya';
        } elseif ($jumlahTidak > $jumlahYa) {
            return 'Tidak';
        } elseif ($jumlahTidak === $jumlahYa) {
            return 'Ya';
        } else {
            return '-';
        }
    }

    /**
     * METHOD: Get Daftar Juz Diuji dengan filter
     */
    private function getDaftarJuzDiuji($santri, $jenis_ujian = null, $tahun_ajaran_id = null)
    {
        // Filter ujian tahfidz berdasarkan jenis ujian dan tahun ajaran
        $query = $santri->ujianTahfidz();

        // Filter berdasarkan tahun ajaran
        if ($tahun_ajaran_id) {
            $query->where('tahun_ajaran_id', $tahun_ajaran_id);
        }

        // Filter berdasarkan jenis ujian
        if ($jenis_ujian === 'uts') {
            $query->where('jenis_ujian', 'UTS');
        } elseif ($jenis_ujian === 'uas') {
            $query->where('jenis_ujian', 'UAS');
        }

        $ujianTahfidz = $query->get();

        $daftarJuz = $ujianTahfidz
            ->pluck('juz')
            ->filter()
            ->unique()
            ->sort()
            ->implode(', ') ?: '-';

        return $daftarJuz;
    }

    /**
     * Helper: Format nilai kesantrian dari database ke format PDF
     * DIPISAH UNTUK UTS DAN UAS
     */
    private function formatNilaiKesantrian($santri, $jenis_ujian = null, $tahun_ajaran_id = null)
    {
        if ($tahun_ajaran_id) {
            $nilaiKesantrian = $santri->nilaiKesantrian()
                ->where('id_tahunAjaran', $tahun_ajaran_id)
                ->first();
        } else {
            $nilaiKesantrian = $santri->nilaiKesantrian()
                ->orderBy('id_tahunAjaran', 'desc')
                ->first();
        }

        $komponen = [
            'ibadah'          => 'Ibadah',
            'akhlak'          => 'Akhlak',
            'kerapian'        => 'Kerapian',
            'kedisiplinan'    => 'Kedisiplinan',
            'ekstrakulikuler' => 'Ekstrakulikuler',
            'buku_pegangan'   => 'Buku Pegangan'
        ];

        $result = collect();

        foreach ($komponen as $key => $label) {
            $nilai = '-';

            if ($nilaiKesantrian) {
                if ($jenis_ujian === 'uts') {
                    $nilai = $nilaiKesantrian->{$key . '_uts'} ?? '-';
                } elseif ($jenis_ujian === 'uas') {
                    $nilai = $nilaiKesantrian->{$key . '_uas'} ?? '-';
                } else {
                    $nilai = $nilaiKesantrian->{$key . '_uas'}
                        ?? $nilaiKesantrian->{$key . '_uts'}
                        ?? '-';
                }
            }

            // 🔥 KHUSUS BUKU PEGANGAN
            if ($key === 'buku_pegangan') {
                $keterangan = $this->getKeteranganBukuPegangan($nilai);
            } else {
                $keterangan = $this->getKeteranganNilai($nilai);
            }

            $result->push([
                'aspek'      => $label,
                'nilai'      => $nilai,
                'keterangan' => $keterangan
            ]);
        }

        return $result;
    }


    /**
     * Helper: Konversi nilai buku pegangan ke keterangan
     */
    private function getKeteranganBukuPegangan($nilai)
    {
        if (!$nilai || $nilai === '-') {
            return '-';
        }

        $nilai = strtolower(trim($nilai));

        $map = [
            'a'        => 'Sangat memahami dengan baik buku pegangan santri',
            'b' => 'Memahami dengan sangat baik buku pegangan santri',
            'b+' => 'Memahami dengan sangat baik buku pegangan santri',
            'b-' => 'Memahami dengan baik buku pegangan santri',
            'c'        => 'Cukup memahami buku pegangan santri',
            'c+'         => 'Cukup memahami buku pegangan santri',
            'c-'         => 'Cukup memahami buku pegangan santri',
            'd'         => 'Kurang memahami buku pegangan santri',
            'e'         => 'Tidak memahami buku pegangan santri',
        ];

        return $map[$nilai] ?? '-';
    }


    /**
     * Helper: Konversi nilai huruf ke keterangan bahasa Arab
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

    /**
     * Get list rapor yang tersedia untuk santri
     */
    public function getRaporList($nis)
    {
        $santri = Santri::where('nis', $nis)->firstOrFail();

        $tahunAjaranIds = $santri->nilaiAkademik()
            ->whereNotNull('id_tahunAjaran')
            ->pluck('id_tahunAjaran')
            ->unique();

        $raporList = [];

        foreach ($tahunAjaranIds as $taId) {
            $hasUts = $santri->nilaiAkademik()
                ->where('id_tahunAjaran', $taId)
                ->whereNotNull('nilai_UTS')
                ->exists();

            $hasUas = $santri->nilaiAkademik()
                ->where('id_tahunAjaran', $taId)
                ->where(function ($query) {
                    $query->whereNotNull('nilai_UAS')
                        ->orWhereNotNull('nilai_praktik');
                })
                ->exists();

            $ta = TahunAjaran::find($taId);
            if (!$ta) continue;

            // Ambil kelas santri untuk tahun ajaran ini
            $kelasSantri = $this->ambilKelasDariNilaiUntukTahunAjaran($santri, $taId);

            $label = "{$ta->tahun} - " . ucfirst($ta->semester);

            $raporList[] = [
                'tahun_ajaran_id' => $taId,
                'label' => $label,
                'uts_available' => $hasUts,
                'uas_available' => $hasUas,
                'kelas' => $kelasSantri,
            ];
        }

        return response()->json($raporList);
    }

    /**
     * Ambil kelas dari nilai akademik untuk tahun ajaran tertentu
     */
    private function ambilKelasDariNilaiUntukTahunAjaran($santri, $tahun_ajaran_id)
    {
        // Ambil nilai akademik untuk tahun ajaran tertentu
        $nilaiAkademik = $santri->nilaiAkademik()
            ->where('id_tahunAjaran', $tahun_ajaran_id)
            ->with('mataPelajaran')
            ->get();

        if ($nilaiAkademik->isEmpty()) {
            return $santri->kelas ?? '-';
        }

        // Ambil kelas dari mata pelajaran yang paling sering muncul
        $kelas = $nilaiAkademik
            ->pluck('mataPelajaran.kelas')
            ->filter()
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first();

        return $kelas ?? $santri->kelas ?? '-';
    }
}
