<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        // Kosongkan tabel jadwal
        Jadwal::truncate();

        // Generate jadwal untuk 7 hari ke depan
        Jadwal::generateJadwalMingguan();
        
        $this->command->info('Jadwal 7 hari berhasil dibuat!');
    }
}