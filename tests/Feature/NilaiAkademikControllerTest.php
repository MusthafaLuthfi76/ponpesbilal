<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\NilaiAkademik;
use App\Models\Santri;
use App\Models\Matapelajaran;
use App\Models\TahunAjaran;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NilaiAkademikControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // 🔥 FIX: login user supaya tidak redirect ke /login
        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function halaman_index_bisa_diakses()
    {
        $response = $this->get('/nilaiakademik');
        $response->assertStatus(200);
    }

    /** @test */
    public function bisa_menambahkan_nilai()
    {
        $santri = Santri::factory()->create(['nis' => '12345']);
        $mapel = Matapelajaran::factory()->create();
        $tahun = TahunAjaran::factory()->create();

        $response = $this->post('/nilaiakademik', [
            'nis' => $santri->nis,
            'id_matapelajaran' => $mapel->id_matapelajaran,
            'id_tahunAjaran' => $tahun->id_tahunAjaran,
            'nilai_UTS' => 80,
            'nilai_UAS' => 90,
            'nilai_praktik' => 85,
        ]);

        $response->assertRedirect('/nilaiakademik');

        $this->assertDatabaseHas('nilaiakademik', [
            'nis' => $santri->nis,
            'id_matapelajaran' => $mapel->id_matapelajaran,
        ]);
    }

    /** @test */
    public function bisa_update_nilai()
    {
        $nilai = NilaiAkademik::factory()->create();

        $response = $this->put('/nilaiakademik/'.$nilai->id_nilai_akademik, [
            'nis' => $nilai->nis,
            'id_matapelajaran' => $nilai->id_matapelajaran,
            'id_tahunAjaran' => $nilai->id_tahunAjaran,
            'nilai_UTS' => 100,
            'nilai_UAS' => 100,
            'nilai_praktik' => 100,
        ]);

        $response->assertRedirect('/nilaiakademik');

        $this->assertDatabaseHas('nilaiakademik', [
            'id_nilai_akademik' => $nilai->id_nilai_akademik,
            'nilai_UTS' => 100,
            'nilai_UAS' => 100,
            'nilai_praktik' => 100,
        ]);
    }

    /** @test */
    public function bisa_menghapus_nilai()
    {
        $nilai = NilaiAkademik::factory()->create();

        $response = $this->delete('/nilaiakademik/'.$nilai->id_nilai_akademik);

        $response->assertRedirect('/nilaiakademik');

        $this->assertDatabaseMissing('nilaiakademik', [
            'id_nilai_akademik' => $nilai->id_nilai_akademik
        ]);
    }
}
