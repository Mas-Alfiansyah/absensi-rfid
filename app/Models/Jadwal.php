<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'hari',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
        'jam_keluar' => 'datetime:H:i',
    ];

    // Method untuk menghasilkan dan memperbarui jadwal 7 hari ke depan
    public static function generateJadwalMingguan()
    {
        // Set timezone explicitly to Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        $today = Carbon::today('Asia/Jakarta');
        $jadwalMingguan = [];
        
        // Hapus jadwal yang sudah lewat dari tanggal hari ini
        self::where('tanggal', '<', $today->format('Y-m-d'))->delete();
        
        // Ambil jadwal yang ada untuk 7 hari ke depan
        $existingJadwal = self::where('tanggal', '>=', $today->format('Y-m-d'))
                            ->orderBy('tanggal')
                            ->get()
                            ->keyBy('tanggal');
        
        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            $dateString = $date->format('Y-m-d');
            $dayName = self::getHariIndonesia($date->dayOfWeek);
            
            if (isset($existingJadwal[$dateString])) {
                // Gunakan jadwal yang sudah ada
                $jadwalMingguan[] = $existingJadwal[$dateString];
            } else {
                // Buat jadwal default
                $isWeekend = $date->dayOfWeek === 5 ; // 0 = Minggu, 6 = Sabtu
                
                // Gunakan firstOrCreate untuk menghindari duplicate entry
                $jadwal = self::firstOrCreate(
                    ['tanggal' => $dateString],
                    [
                        'hari' => $dayName,
                        'jam_masuk' => $isWeekend ? null : '07:15:00',
                        'jam_keluar' => $isWeekend ? null : '11:15:00',
                        'status' => $isWeekend ? 'libur' : 'masuk',
                        'keterangan' => $isWeekend ? 'Hari Libur' : null,
                    ]
                );
                
                $jadwalMingguan[] = $jadwal;
            }
        }
        
        // Hapus jadwal yang lebih dari 7 hari ke depan
        $sevenDaysLater = $today->copy()->addDays(7)->format('Y-m-d');
        self::where('tanggal', '>', $sevenDaysLater)->delete();
        
        return $jadwalMingguan;
    }

    // Method untuk mengonversi dayOfWeek ke nama hari Indonesia
    public static function getHariIndonesia($dayOfWeek)
    {
        $days = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];
        
        return $days[$dayOfWeek] ?? 'Minggu';
    }
}