<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{
    public function run()
    {
        Siswa::create([
            'nama_lengkap' => 'Budi Santoso',
            'nisn' => '1234567890',
            'nis' => '2024001',
            'uid' => 'RFID12345',
            'tanggal_lahir' => '2007-05-20',
            'tempat_lahir' => 'Jakarta',
            'jenis_kelamin' => 'L',
            'kelas_id' => 1,
        ]);
    }
}
