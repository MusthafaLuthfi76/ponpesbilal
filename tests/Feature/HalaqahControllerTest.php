<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Santri;
use App\Models\Pendidik;
use App\Models\KelompokHalaqah;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HalaqahControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create()); // login auth
    }

    /** @test */
    public function halaman_index_bisa_diakses()
    {
        $response = $this->get('/halaqah');
        $response->assertStatus(200);
        $response->assertViewIs('halaqah.index');
    }

    /** @test */
    public function bisa_menambahkan_kelompok_halaqah()
    {
        $pendidik = Pendidik::factory()->create();

        $response = $this->post('/halaqah', [
            'nama_kelompok' => 'Kelompok 1',
            'id_pendidik' => $pendidik->id_pendidik
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('kelompok_halaqah', [
            'nama_kelompok' => 'Kelompok 1'
        ]);
    }

    /** @test */
    public function bisa_update_kelompok_halaqah()
    {
        $pendidik = Pendidik::factory()->create();
        $kelompok = KelompokHalaqah::factory()->create();

        $response = $this->put('/halaqah/' . $kelompok->id_halaqah, [
            'nama_kelompok' => 'Kelompok Updated',
            'id_pendidik' => $pendidik->id_pendidik,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('kelompok_halaqah', [
            'id_halaqah' => $kelompok->id_halaqah,
            'nama_kelompok' => 'Kelompok Updated'
        ]);
    }

    /** @test */
    public function bisa_menghapus_kelompok_halaqah()
    {
        $kelompok = KelompokHalaqah::factory()->create();

        $response = $this->delete('/halaqah/' . $kelompok->id_halaqah);

        $response->assertRedirect();
        $this->assertDatabaseMissing('kelompok_halaqah', [
            'id_halaqah' => $kelompok->id_halaqah
        ]);
    }

    /** @test */
    public function halaman_show_kelompok_bisa_diakses()
    {
        $kelompok = KelompokHalaqah::factory()->create();

        $response = $this->get('/halaqah/' . $kelompok->id_halaqah);

        $response->assertStatus(200);
        $response->assertViewIs('halaqah.show');
    }

    /** @test */
    public function bisa_menambahkan_santri_ke_kelompok()
    {
        $kelompok = KelompokHalaqah::factory()->create();

        $santri1 = Santri::factory()->create(['id_halaqah' => null]);
        $santri2 = Santri::factory()->create(['id_halaqah' => null]);

        $response = $this->post('/halaqah/' . $kelompok->id_halaqah . '/add-santri', [
            'santri' => [$santri1->nis, $santri2->nis]
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('santri', [
            'nis' => $santri1->nis,
            'id_halaqah' => $kelompok->id_halaqah
        ]);

        $this->assertDatabaseHas('santri', [
            'nis' => $santri2->nis,
            'id_halaqah' => $kelompok->id_halaqah
        ]);
    }

    /** @test */
    public function bisa_menghapus_santri_dari_kelompok()
    {
        $kelompok = KelompokHalaqah::factory()->create();

        $santri = Santri::factory()->create([
            'id_halaqah' => $kelompok->id_halaqah
        ]);

        $response = $this->delete("/halaqah/{$kelompok->id_halaqah}/remove-santri/{$santri->nis}");

        $response->assertRedirect();

        $this->assertDatabaseHas('santri', [
            'nis' => $santri->nis,
            'id_halaqah' => null
        ]);
    }
}
