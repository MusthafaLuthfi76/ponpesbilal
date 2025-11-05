<?php

namespace Database\Factories;

use App\Models\KelompokHalaqah;
use App\Models\Pendidik;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelompokHalaqahFactory extends Factory
{
    protected $model = KelompokHalaqah::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kelompok' => $this->faker->words(3, true),
            'id_pendidik' => Pendidik::factory(), // ⬅️ membuat Pendidik terkait otomatis
        ];
    }
}