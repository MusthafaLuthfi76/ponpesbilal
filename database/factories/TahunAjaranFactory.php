<?php

namespace Database\Factories;

use App\Models\TahunAjaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class TahunAjaranFactory extends Factory
{
    protected $model = TahunAjaran::class;

    public function definition(): array
    {
        // Membuat data TahunAjaran dummy
        $startYear = $this->faker->unique()->numberBetween(2000, 2024);
        $endYear = $startYear + 1;
        
        return [
            'tahun' => "{$startYear}/{$endYear}",
            'semester' => $this->faker->randomElement(['Ganjil', 'Genap']),
        ];
    }
}