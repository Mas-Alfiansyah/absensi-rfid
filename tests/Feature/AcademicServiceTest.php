<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Services\AcademicService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;

class AcademicServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_transisi_tahun_ajaran_handles_graduation_and_promotion()
    {
        // 1. Setup Data
        $kelas10 = Kelas::create(['nama_kelas' => '10 Test A', 'deskripsi' => 'Test Class 10']);
        $kelas11 = Kelas::create(['nama_kelas' => '11 Test A', 'deskripsi' => 'Test Class 11']);
        $kelas12 = Kelas::create(['nama_kelas' => '12 Test A', 'deskripsi' => 'Test Class 12']);

        $siswa10 = Siswa::create([
            'uid' => Str::random(10),
            'nisn' => Str::random(10),
            'nama_lengkap' => 'Siswa 10',
            'kelas_id' => $kelas10->id,
            'alamat' => 'Test',
            'tempat_lahir' => 'Test',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => 'L',
            'no_wa' => '080000000000'
        ]);

        $siswa11 = Siswa::create([
            'uid' => Str::random(10),
            'nisn' => Str::random(10),
            'nama_lengkap' => 'Siswa 11',
            'kelas_id' => $kelas11->id,
            'alamat' => 'Test',
            'tempat_lahir' => 'Test',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => 'L',
            'no_wa' => '080000000000'
        ]);

        $siswa12 = Siswa::create([
            'uid' => Str::random(10),
            'nisn' => Str::random(10),
            'nama_lengkap' => 'Siswa 12',
            'kelas_id' => $kelas12->id,
            'alamat' => 'Test',
            'tempat_lahir' => 'Test',
            'tanggal_lahir' => now(),
            'jenis_kelamin' => 'L',
            'no_wa' => '080000000000'
        ]);

        // 2. Define Logic
        // 12 Test A -> Graduate (kelas_id = null)
        // 11 Test A -> 12 Test A
        // 10 Test A -> 11 Test A

        $promotionMapping = [
            '10 Test A' => '11 Test A',
            '11 Test A' => '12 Test A',
        ];

        $graduatingClasses = [
            '12 Test A'
        ];

        // 3. Execute Service
        $service = new AcademicService();
        $result = $service->transisiTahunAjaran($promotionMapping, $graduatingClasses);

        // 4. Assertions
        $this->assertEquals('success', $result['status']);

        // Refresh models
        $siswa10->refresh();
        $siswa11->refresh();
        $siswa12->refresh();

        // Check Siswa 10 moved to 11
        $this->assertEquals($kelas11->id, $siswa10->kelas_id, "Siswa 10 should be promoted to 11");

        // Check Siswa 11 moved to 12
        $this->assertEquals($kelas12->id, $siswa11->kelas_id, "Siswa 11 should be promoted to 12");

        // Check Siswa 12 is graduated
        $this->assertNull($siswa12->kelas_id, "Siswa 12 should be graduated (null class)");
    }
}
