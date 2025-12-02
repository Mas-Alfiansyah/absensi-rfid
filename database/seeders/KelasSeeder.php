<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run()
    {
        Kelas::create(['nama_kelas' => 'X RPL A', 'deskripsi' => 'Memuat 20 Siswa di kelas ini']);
        Kelas::create(['nama_kelas' => 'XI RPL A ', 'deskripsi' => 'Memuat 14 Siswa di kelas ini']);
        Kelas::create(['nama_kelas' => 'XII RPL A ', 'deskripsi' => 'Memuat 17 Siswa di kelas ini']);
        Kelas::create(['nama_kelas' => 'X RPL B ', 'deskripsi' => 'Memuat 14 Siswa di kelas ini']);
        Kelas::create(['nama_kelas' => 'XI RPL B ', 'deskripsi' => 'Memuat 12 Siswa di kelas ini']);
        Kelas::create(['nama_kelas' => 'XII RPL B ', 'deskripsi' => 'Memuat 17 Siswa di kelas ini']);
        Kelas::create(['nama_kelas' => 'X TBS ', 'deskripsi' => 'Memuat 10 Siswa di kelas ini']);
        Kelas::create(['nama_kelas' => 'XI TBS ', 'deskripsi' => 'Memuat 16 Siswa di kelas ini']);
        Kelas::create(['nama_kelas' => 'XII TBS ', 'deskripsi' => 'Memuat 13 Siswa di kelas ini']);
    }
}
