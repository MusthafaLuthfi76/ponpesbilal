<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Santri;
use App\Models\TahunAjaran;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SantriControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_santri_index_page()
    {
        $user = User::factory()->create();
        TahunAjaran::factory()->count(2)->create();
        Santri::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('santri.index'));

        $response->assertStatus(200);
        $response->assertViewIs('santri.homeSantri');
        $response->assertViewHasAll(['santri', 'tahunajaran']);
    }

    /** @test */
    public function user_can_view_create_santri_page()
    {
        $user = User::factory()->create();
        TahunAjaran::factory()->count(2)->create();

        $response = $this->actingAs($user)->get(route('santri.createSantri'));

        $response->assertStatus(200);
        $response->assertViewIs('santri.homeSantri');
        $response->assertViewHas('tahunajaran');
    }

    /** @test */
    public function user_can_store_new_santri()
    {
        $user = User::factory()->create();

        $data = [
            'nama' => 'Ahmad Bilal',
            'angkatan' => '2024',
            'status' => 'aktif',
        ];

        $response = $this->actingAs($user)->post(route('santri.store'), $data);

        $response->assertRedirect(route('santri.index'));
        $this->assertDatabaseHas('santri', $data);
    }

    /** @test */
    public function user_can_view_edit_santri_page()
    {
        $user = User::factory()->create();
        $santri = Santri::factory()->create();

        $response = $this->actingAs($user)->get(route('santri.editSantri', $santri->id_santri));

        $response->assertStatus(200);
        $response->assertViewIs('santri.editSantri');
        $response->assertViewHas('santri', $santri);
    }

    /** @test */
    public function user_can_update_existing_santri()
    {
        $user = User::factory()->create();
        $santri = Santri::factory()->create();

        $data = [
            'nama' => 'Bilal Updated',
            'angkatan' => '2025',
            'status' => 'alumni',
        ];

        $response = $this->actingAs($user)->put(route('santri.update', $santri->id_santri), $data);

        $response->assertRedirect(route('santri.index'));
        $this->assertDatabaseHas('santri', $data);
    }

    /** @test */
    public function user_can_delete_santri()
    {
        $user = User::factory()->create();
        $santri = Santri::factory()->create();

        $response = $this->actingAs($user)->delete(route('santri.destroy', $santri->id_santri));

        $response->assertRedirect(route('santri.index'));
        $this->assertDatabaseMissing('santri', ['id_santri' => $santri->id_santri]);
    }
}
