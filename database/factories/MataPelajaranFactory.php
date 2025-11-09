<?php

namespace Database\Factories;

use App\Models\MataPelajaran;
use App\Models\Pendidik;
use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class MataPelajaranFactory extends Factory
{
    protected $model = MataPelajaran::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_matapelajaran' => 1,
            'nama_matapelajaran' => $this->faker->unique()->word(),
            'kkm' => $this->faker->randomFloat(2, 70, 100), // contoh: 75.50
            'bobot_UTS' => 30.00,
            'bobot_UAS' => 40.00,
            'bobot_praktik' => 30.00,
            'id_pendidik' => Pendidik::factory(),
            'id_tahunAjaran' => TahunAjaran::factory(),
        ];
    }
}