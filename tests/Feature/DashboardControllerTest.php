<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login'); // pastikan middleware auth berfungsi
    }

    /** @test */
    public function authenticated_user_can_view_dashboard_with_stats()
    {
        // Buat user dummy
        $user = User::factory()->create();

        // Login sebagai user tersebut
        $response = $this->actingAs($user)->get('/dashboard');

        // Pastikan status 200
        $response->assertStatus(200);

        // Pastikan view yang digunakan benar
        $response->assertViewIs('dashboard');

        // Pastikan variabel 'user' dikirim ke view
        $response->assertViewHas('user', function ($viewUser) use ($user) {
            return $viewUser->id_user === $user->id_user;
        });

        // Pastikan variabel 'stats' dikirim dan isinya benar
        $response->assertViewHas('stats', function ($stats) {
            return isset($stats['santri_ma'])
                && isset($stats['santri_mts'])
                && isset($stats['alumni'])
                && isset($stats['mata_pelajaran']);
        });
    }
}
