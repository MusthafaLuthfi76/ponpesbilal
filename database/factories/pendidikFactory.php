<?php

namespace Database\Factories;

use App\Models\Pendidik;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendidikFactory extends Factory
{
    protected $model = Pendidik::class;

    public function definition(): array
    {
        return [
            'id_pendidik' => $this->faker->unique()->randomNumber(5, true),
            'nama' => $this->faker->name(),
            'jabatan' => $this->faker->randomElement(['Guru', 'Kepala Sekolah', 'Wakil', 'Admin']),
            'id_user' => User::factory(), // otomatis buat user baru untuk FK
        ];
    }
}
