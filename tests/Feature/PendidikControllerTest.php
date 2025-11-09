<?php

namespace Tests\Feature;

use App\Models\Pendidik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendidikControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_view_pendidik_index()
    {
        Pendidik::factory()->count(3)->create();

        $response = $this->actingAs($this->user)
            ->get(route('pendidik.index')); // Sesuaikan nama route

        $response->assertStatus(200);
        $response->assertViewIs('pendidik.index');
        $response->assertViewHas('pendidik');
    }

    /** @test */
    public function user_can_create_pendidik()
    {
        $userData = User::factory()->create(); // user terpisah untuk relasi

        $data = [
            'nama' => 'Ustadz Ahmad',
            'jabatan' => 'Pembina',
            'id_user' => $userData->id_user,
        ];

        $response = $this->actingAs($this->user)
            ->post(route('pendidik.store'), $data);

        $response->assertRedirect(route('pendidik.index'));
        $this->assertDatabaseHas('pendidik', $data);
    }

    /** @test */
    public function user_can_update_pendidik()
    {
        $pendidik = Pendidik::factory()->create();
        $newUser = User::factory()->create();

        $updatedData = [
            'nama' => 'Ustadzah Siti',
            'jabatan' => 'Wali Kelas',
            'id_user' => $newUser->id_user,
        ];

        $response = $this->actingAs($this->user)
            ->put(route('pendidik.update', $pendidik->id_pendidik), $updatedData);

        $response->assertRedirect(route('pendidik.index'));
        $this->assertDatabaseHas('pendidik', $updatedData);
    }

    /** @test */
    public function user_can_delete_pendidik()
    {
        $pendidik = Pendidik::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('pendidik.destroy', $pendidik->id_pendidik));

        $response->assertRedirect(route('pendidik.index'));
        $this->assertDatabaseMissing('pendidik', [
            'id_pendidik' => $pendidik->id_pendidik
        ]);
    }
}