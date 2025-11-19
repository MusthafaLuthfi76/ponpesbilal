<?php

namespace Database\Factories;

use App\Models\Santri;
use App\Models\TahunAjaran;
use App\Models\UjianTahfidz;
use Illuminate\Database\Eloquent\Factories\Factory;

class UjianTahfidzFactory extends Factory
{
    protected $model = UjianTahfidz::class;

    public function definition(): array
    {
        return [
            'nis' => Santri::factory(), // auto create santri
            'juz' => $this->faker->numberBetween(1, 30),
            'tajwid' => $this->faker->numberBetween(0, 10),
            'itqan' => $this->faker->numberBetween(0, 10),
            'jenis_ujian' => $this->faker->randomElement(['UTS', 'UAS']),
            'tahun_ajaran_id' => TahunAjaran::factory(),
            'sekali_duduk' => $this->faker->randomElement(['ya', 'tidak']),
        ];
    }
}
