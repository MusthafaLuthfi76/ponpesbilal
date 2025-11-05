<?php

namespace Database\Factories;

use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

class SantriFactory extends Factory
{
    protected $model = Santri::class;

    public function definition(): array
    {
        return [
            'nis' => $this->faker->unique()->numerify('##########'), // 10 digit NIS unik
            'nama' => $this->faker->name,
            'angkatan' => $this->faker->year,
            'status' => $this->faker->randomElement(['MA', 'MTS', 'Alumni', 'Keluar']),
            // id_tahunAjaran akan di-override di setup() test controller
        ];
    }
}