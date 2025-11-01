<?php

namespace Tests\Feature;

use App\Models\MataPelajaran;
use App\Models\Pendidik;
use App\Models\TahunAjaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MataPelajaranControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function halaman_index_bisa_diakses()
    {
        $response = $this->get(route('matapelajaran.index'));
        $response->assertStatus(200);
        $response->assertViewIs('matapelajaran.index');
    }

    /** @test */
    public function bisa_menambahkan_mata_pelajaran()
    {
        $tahun = TahunAjaran::factory()->create();
        $pendidik = Pendidik::factory()->create();
 
        $data = [
            'id_matapelajaran' => 100,
            'nama_matapelajaran' => 'Matematika',
            'kkm' => 75,
            'bobot_UTS' => 30,
            'bobot_UAS' => 40,
            'bobot_praktik' => 30,
            'id_pendidik' => $pendidik->id_pendidik,
            'id_tahunAjaran' => $tahun->id_tahunAjaran,
        ];

        $response = $this->post(route('matapelajaran.store'), $data);

        $response->assertRedirect(route('matapelajaran.index'));
        $this->assertDatabaseHas('matapelajaran', $data);
    }

    /** @test */
    public function bisa_update_mata_pelajaran()
    {
        $tahun = TahunAjaran::factory()->create();
        $pendidik = Pendidik::factory()->create();

        $mapel = MataPelajaran::factory()->create([
            'nama_matapelajaran' => 'IPA'
        ]);

        $data = [
            'nama_matapelajaran' => 'IPA Terpadu',
            'kkm' => 78,
            'bobot_UTS' => 30,
            'bobot_UAS' => 40,
            'bobot_praktik' => 30,
            'id_pendidik' => $pendidik->id_pendidik,
            'id_tahunAjaran' => $tahun->id_tahunAjaran,
        ];

        $response = $this->put(route('matapelajaran.update', $mapel->id_matapelajaran), $data);

        $response->assertRedirect(route('matapelajaran.index'));
        $this->assertDatabaseHas('matapelajaran', $data);
    }

    /** @test */
    public function bisa_menghapus_mata_pelajaran()
    {
        $mapel = MataPelajaran::factory()->create();

        $response = $this->delete(route('matapelajaran.destroy', $mapel->id_matapelajaran));

        $response->assertRedirect(route('matapelajaran.index'));
        $this->assertDatabaseMissing('matapelajaran', [
            'id_matapelajaran' => $mapel->id_matapelajaran
        ]);
    }
}
