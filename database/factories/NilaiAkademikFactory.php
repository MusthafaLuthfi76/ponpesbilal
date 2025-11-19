<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\NilaiAkademik;
use App\Models\Santri;
use App\Models\Matapelajaran;
use App\Models\TahunAjaran;

class NilaiAkademikFactory extends Factory
{
    protected $model = NilaiAkademik::class;

    public function definition(): array
    {
        $nilai_UTS = $this->faker->numberBetween(0, 100);
        $nilai_UAS = $this->faker->numberBetween(0, 100);
        $nilai_praktik = $this->faker->numberBetween(0, 100);

        $avg = round(($nilai_UTS + $nilai_UAS + $nilai_praktik) / 3, 2);

        return [
            'nis' => Santri::factory(),
            'id_matapelajaran' => Matapelajaran::factory(),
            'id_tahunAjaran' => TahunAjaran::factory(),
            
            'nilai_UTS' => $nilai_UTS,
            'nilai_UAS' => $nilai_UAS,
            'nilai_praktik' => $nilai_praktik,
            'nilai_rata_rata' => $avg,

            'predikat' => $avg >= 85 ? 'A' : ($avg >= 70 ? 'B' : ($avg >= 55 ? 'C' : 'D')),
            'keterangan' => $avg >= 55 ? 'LULUS' : 'TIDAK LULUS',
        ];
    }
}
