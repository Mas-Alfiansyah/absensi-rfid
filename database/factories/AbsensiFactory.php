<?php

namespace Database\Factories;

use App\Models\Scan;
use App\Models\Siswa;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AbsensiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Scan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil siswa random
        $siswa = Siswa::inRandomOrder()->first() ?? Siswa::factory()->create();

        // Random date in last 30 days
        $date = Carbon::today()->subDays(rand(0, 30));

        // Random status
        // 80% chance hadir, 20% others
        $rand = rand(1, 100);
        if ($rand <= 80) {
            $status = 'hadir';
            // Random time between 06:45 and 07:30 for entry
            $jam_masuk = $date->copy()->setTime(6, 45, 0)->addMinutes(rand(0, 45))->format('H:i:s');
            // Random time between 14:00 and 16:00 for exit
            $jam_keluar = $date->copy()->setTime(14, 0, 0)->addMinutes(rand(0, 120))->format('H:i:s');

            // 10% chance 'lambat'
            if (rand(1, 10) == 1) {
                $status = 'lambat';
                $jam_masuk = $date->copy()->setTime(7, 31, 0)->addMinutes(rand(1, 30))->format('H:i:s');
            }
        } else {
            $status = $this->faker->randomElement(['sakit', 'izin', 'alpha']);
            $jam_masuk = null;
            $jam_keluar = null;
        }

        return [
            'siswa_id' => $siswa->id,
            'tanggal' => $date->format('Y-m-d'),
            'jam_masuk' => $jam_masuk,
            'jam_keluar' => $jam_keluar,
            'status' => $status,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
