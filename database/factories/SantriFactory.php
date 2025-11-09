<?php

namespace Database\Factories;

use App\Models\Santri;
use App\Models\KelompokHalaqah; // Pastikan model ini ada
use Illuminate\Database\Eloquent\Factories\Factory;

class SantriFactory extends Factory
{
    protected $model = Santri::class;

    public function definition(): array
    {
        return [
            'nis' => $this->faker->unique()->numerify('######'),
            'nama' => $this->faker->name(),
            'angkatan' => $this->faker->year(),
            'status' => $this->faker->randomElement(['MA', 'MTS', 'Alumni', 'Keluar']),
            'id_tahunAjaran' => null,
            'id_halaqah' => KelompokHalaqah::factory(), // ⬅️ WAJIB!
        ];
    }
}