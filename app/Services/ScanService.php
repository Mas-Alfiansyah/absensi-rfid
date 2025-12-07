<?php

namespace App\Services;

use App\Models\Scan;
use App\Models\Siswa;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ScanService
{
    /**
     * Handle the scanning process.
     *
     * @param string $uid
     * @return array
     * @throws \Exception
     */
    public function processScan(string $uid)
    {
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        // Find Siswa (Optimize: Cache siswa lookup by UID?) 
        // Siswa list might be large, but caching individual user by UID is effective.
        // Let's cache this for short duration or use local mem if frequent?
        // Actually, just indexing 'uid' is enough. Caching might be overkill if not millions of users.
        // But Jadwal IS constant for everyone for the day.

        $siswa = Siswa::where('uid', $uid)->first();
        if (!$siswa) {
            throw new \Exception('UID tidak ditemukan', 404);
        }

        // Get Schedule - CACHED
        $jadwal = Cache::remember('jadwal_' . $today, 60 * 60, function () use ($today) {
            return Jadwal::where('tanggal', $today)->first();
        });

        if (!$jadwal) {
            throw new \Exception('Jadwal hari ini tidak ditemukan', 404);
        }

        if ($jadwal->status === 'libur') {
            throw new \Exception('Hari ini libur, absensi dilarang!', 403);
        }

        // Check existing scan
        $absen = Scan::where('siswa_id', $siswa->id)->where('tanggal', $today)->first();

        // Check if status is invalid for scanning
        if ($absen && in_array($absen->status, ['sakit', 'izin', 'alpha'])) {
            throw new \Exception('Siswa sudah tercatat ' . $absen->status . ' hari ini!', 403);
        }

        // Create if not exists
        if (!$absen) {
            $absen = Scan::create([
                'siswa_id' => $siswa->id,
                'tanggal' => $today,
            ]);
        }

        // Logic for Scan Masuk
        if (is_null($absen->jam_masuk)) {
            $status = 'hadir';
            if ($now->lte(Carbon::parse($jadwal->jam_masuk))) {
                $status = 'hadir';
            } else {
                $status = 'lambat';
            }

            $absen->update([
                'jam_masuk' => $now->format('H:i:s'),
                'status' => $status,
            ]);

            return [
                'type' => 'masuk',
                'message' => 'Scan masuk berhasil',
                'data' => $absen->load('siswa.kelas')
            ];
        }

        // Logic for Scan Keluar
        if (is_null($absen->jam_keluar)) {
            if ($now->lt(Carbon::parse($jadwal->jam_keluar))) {
                throw new \Exception('Belum waktunya pulang!', 403);
            } else {
                $absen->update([
                    'jam_keluar' => $now->format('H:i:s'),
                ]);

                return [
                    'type' => 'keluar',
                    'message' => 'Scan pulang berhasil',
                    'data' => $absen->load('siswa.kelas')
                ];
            }
        }

        throw new \Exception('Siswa sudah pulang hari ini!', 403);
    }

    public function processManualScan(int $siswaId, string $status)
    {
        $today = now('Asia/Jakarta')->toDateString();

        $jadwal = Cache::remember('jadwal_' . $today, 60 * 60, function () use ($today) {
            return Jadwal::where('tanggal', $today)->first();
        });

        if (!$jadwal) {
            throw new \Exception('Tidak ada jadwal hari ini', 403);
        }
        if ($jadwal->status === 'libur') {
            throw new \Exception('Hari ini libur, absensi manual tidak diperbolehkan', 403);
        }

        $absen = Scan::updateOrCreate(
            ['siswa_id' => $siswaId, 'tanggal' => $today],
            ['status' => $status, 'jam_masuk' => null, 'jam_keluar' => null]
        );

        return $absen;
    }

    public function getSiswaBelumAbsen()
    {
        $today = now('Asia/Jakarta')->toDateString();
        // Optimizing: pluck returns array. whereNotIn is OK. 
        // Can we cache 'sudahAbsen' list? No, it changes real time.

        $sudahAbsen = Scan::where('tanggal', $today)->pluck('siswa_id');

        return Siswa::with('kelas')
            ->whereNotIn('id', $sudahAbsen)
            ->orderBy('nama_lengkap')
            ->get();
    }

    public function getTodayScans()
    {
        $today = now('Asia/Jakarta')->toDateString();
        return Scan::with(['siswa.kelas'])
            ->where('tanggal', $today)
            ->orderBy('jam_masuk', 'asc')
            ->get();
    }
}
