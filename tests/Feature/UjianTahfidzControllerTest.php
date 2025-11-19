<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Santri;
use App\Models\UjianTahfidz;
use App\Models\TahunAjaran;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UjianTahfidzControllerTest extends TestCase
{
    use RefreshDatabase;

    // Helper: membuat user dan login agar tidak 302 redirect
    protected function actingAsUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /** @test */
    public function halaman_index_bisa_diakses()
    {
        $this->actingAsUser();

        $response = $this->get('/nilaiTahfidz');

        $response->assertStatus(200);
    }

    /** @test */
    public function bisa_menambahkan_data_ujian()
    {
        $this->actingAsUser();

        $santri = Santri::factory()->create();
        $tahun = TahunAjaran::factory()->create();

        $data = [
            'nis' => $santri->nis,
            'jenis_ujian' => 'UTS',
            'juz' => 5,
            'tajwid' => 3,
            'itqan' => 2,
            'tahun_ajaran_id' => $tahun->id_tahunAjaran,
            'sekali_duduk' => 'ya',
        ];

        $response = $this->post('/nilaiTahfidz', $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('ujian_tahfidz', [
            'nis' => $santri->nis,
            'total_kesalahan' => 5,
        ]);
    }

    /** @test */
    public function bisa_update_data_ujian()
    {
        $this->actingAsUser();

        $ujian = UjianTahfidz::factory()->create([
            'tajwid' => 2,
            'itqan' => 1
        ]);

        $data = [
            'jenis_ujian' => 'UAS',
            'juz' => 10,
            'tajwid' => 4,
            'itqan' => 3,
            'tahun_ajaran_id' => $ujian->tahun_ajaran_id,
            'sekali_duduk' => 'tidak',
        ];

        $response = $this->put('/nilaiTahfidz/' . $ujian->id, $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('ujian_tahfidz', [
            'id' => $ujian->id,
            'total_kesalahan' => 7,
        ]);
    }

    /** @test */
    public function bisa_menghapus_data_ujian()
    {
        $this->actingAsUser();

        $ujian = UjianTahfidz::factory()->create();

        $response = $this->delete('/nilaiTahfidz/' . $ujian->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('ujian_tahfidz', [
            'id' => $ujian->id,
        ]);
    }

    /** @test */
    public function total_kesalahan_dihitung_otomatis()
    {
        $this->actingAsUser();

        $ujian = UjianTahfidz::factory()->create([
            'tajwid' => 3,
            'itqan' => 4
        ]);

        $this->assertEquals(7, $ujian->total_kesalahan);
    }
}
