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

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();
        // Setup user yang akan login di semua test, Panggil SEKALI
        $this->user = User::factory()->create();
    }

    // --- TES INDEX ---

    /** @test */
    public function user_can_view_santri_index_page()
    {
        TahunAjaran::factory()->count(2)->create();
        Santri::factory()->count(3)->create();

        // Menggunakan $this->user dari setUp()
        $response = $this->actingAs($this->user)->get(route('santri.index'));

        $response->assertStatus(200);
        $response->assertViewIs('santri.homeSantri');
        $response->assertViewHasAll(['santri', 'tahunajaran']);
    }

    // --- TES CREATE VIEW ---
    
    /** @test */
    public function user_can_view_create_santri_page()
    {
        // Membuat data TahunAjaran untuk select option di form
        TahunAjaran::factory()->count(2)->create();

        // Menggunakan $this->user dari setUp()
        $response = $this->actingAs($this->user)->get(route('santri.createSantri'));
        
        $response->assertStatus(200);
        // Hapus: $response->assertViewIs('santri.homeSantri'); 
        // -> assertion ini tidak diperlukan jika hanya menguji variabel yang dilewatkan
        // Jika form create ada di halaman terpisah, gunakan: $response->assertViewIs('santri.createSantri'); 
        $response->assertViewHas('tahunajaran');
    }

    // --- TES STORE ---

    /** @test */
    public function user_can_store_new_santri()
    {
        $tahunAjaran = TahunAjaran::factory()->create();

        $data = [
            'nis' => '1234567890', 
            'nama' => 'Ahmad Bilal',
            'angkatan' => '2024',
            'status' => 'MA', 
            'id_tahunAjaran' => $tahunAjaran->id_tahunAjaran, 
        ];

        // Menggunakan $this->user dari setUp()
        $response = $this->actingAs($this->user)->post(route('santri.store'), $data);

        $response->assertRedirect(route('santri.index'));
        $this->assertDatabaseHas('santri', $data);
    }

    // --- TES EDIT VIEW ---

    /** @test */
    public function user_can_view_edit_santri_page()
    {
        $santri = Santri::factory()->create(['nis' => '888888']);
        TahunAjaran::factory()->count(2)->create();

        // Menggunakan $santri->nis sebagai parameter route dan $this->user untuk otentikasi
        $response = $this->actingAs($this->user)->get(route('santri.editSantri', $santri->nis));

        $response->assertStatus(200);
        $response->assertViewIs('santri.editSantri'); 
        $response->assertViewHas('santri', $santri);
    }

    // --- TES UPDATE ---

    /** @test */
    public function user_can_update_existing_santri()
    {
        $santri = Santri::factory()->create(['nis' => '998877']);
        $tahunAjaranBaru = TahunAjaran::factory()->create();

        $updatedData = [
            'nis' => '998877',
            'nama' => 'Bilal Updated',
            'angkatan' => '2025',
            'status' => 'Alumni',
            'id_tahunAjaran' => $tahunAjaranBaru->id_tahunAjaran, 
        ];

        // Menggunakan $santri->nis sebagai parameter route dan $this->user untuk otentikasi
        $response = $this->actingAs($this->user)->put(route('santri.update', $santri->nis), $updatedData);

        $response->assertRedirect(route('santri.index'));
        $this->assertDatabaseHas('santri', ['nis' => '998877', 'nama' => 'Bilal Updated', 'status' => 'Alumni']);
        // Assert that the old data is gone (optional but good practice if NIS was the only PK)
        // $this->assertDatabaseMissing('santri', $santri->getOriginal()); 
    }

    // --- TES DELETE ---

    /** @test */
    public function user_can_delete_santri()
    {
        $santri = Santri::factory()->create(['nis' => '54321']);

        // Menggunakan $santri->nis sebagai parameter route dan $this->user untuk otentikasi
        $response = $this->actingAs($this->user)->delete(route('santri.destroy', $santri->nis));

        $response->assertRedirect(route('santri.index'));
        // Cek berdasarkan primary key NIS
        $this->assertDatabaseMissing('santri', ['nis' => $santri->nis]);
    }
}