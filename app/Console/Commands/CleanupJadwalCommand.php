<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use Carbon\Carbon;

class CleanupJadwalCommand extends Command
{
    protected $signature = 'jadwal:cleanup';
    protected $description = 'Hapus jadwal yang sudah lewat dari tanggal hari ini';

    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        $deleted = Jadwal::where('tanggal', '<', $today)->delete();
        
        $this->info("Berhasil menghapus $deleted jadwal yang sudah lewat.");
        
        // Generate jadwal untuk 7 hari ke depan
        Jadwal::generateJadwalMingguan();
        $this->info('Jadwal 7 hari ke depan telah diperbarui.');
    }
}