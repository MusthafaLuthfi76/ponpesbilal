<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TahunAjaran;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TahunAjaranControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_tahun_ajaran_index_page()
    {
        $user = User::factory()->create();
        TahunAjaran::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('tahunajaran.index'));

        $response->assertStatus(200);
        $response->assertViewIs('tahunajaran.indexthnajar');
        $response->assertViewHas('tahunajaran');
    }

    /** @test */
    public function user_can_store_new_tahun_ajaran()
    {
        $user = User::factory()->create();

        $data = [
            'tahun' => '2025/2026',
            'semester' => 'Ganjil',
        ];

        $response = $this->actingAs($user)->post(route('tahunajaran.store'), $data);

        $response->assertRedirect(route('tahunajaran.index'));
        $this->assertDatabaseHas('tahunajaran', $data);
    }

    /** @test */
    public function user_can_update_existing_tahun_ajaran()
    {
        $user = User::factory()->create();
        $tahunAjaran = TahunAjaran::factory()->create();

        $data = [
            'tahun' => '2026/2027',
            'semester' => 'Genap',
        ];

        $response = $this->actingAs($user)->put(
            route('tahunajaran.update', $tahunAjaran->id_tahunAjaran),
            $data
        );

        $response->assertRedirect(route('tahunajaran.index'));
        $this->assertDatabaseHas('tahunajaran', $data);
    }

    /** @test */
    public function user_can_delete_tahun_ajaran()
    {
        $user = User::factory()->create();
        $tahunAjaran = TahunAjaran::factory()->create();

        $response = $this->actingAs($user)->delete(
            route('tahunajaran.destroy', $tahunAjaran->id_tahunAjaran)
        );

        $response->assertRedirect(route('tahunajaran.index'));
        $this->assertDatabaseMissing('tahunajaran', [
            'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran,
        ]);
    }
}
