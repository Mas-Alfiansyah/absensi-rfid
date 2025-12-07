<?php

namespace App\Services;

use App\Models\Scan;
use App\Models\Siswa;
use App\Models\Kelas;
use Carbon\Carbon;

class AbsensiService
{
    public function getAbsensiList(array $filters, int $perPage = 10)
    {
        $query = Scan::with(['siswa.kelas']);
        $today = Carbon::today('Asia/Jakarta');

        // Filter kelas
        if (isset($filters['kelas_id']) && $filters['kelas_id']) {
            $query->whereHas('siswa', function ($q) use ($filters) {
                $q->where('kelas_id', $filters['kelas_id']);
            });
        }

        // Filter waktu
        if (isset($filters['periode']) && $filters['periode']) {
            switch ($filters['periode']) {
                case 'hari_ini':
                    $query->whereDate('tanggal', $today);
                    break;
                case 'minggu_ini':
                    $query->whereBetween('tanggal', [
                        $today->copy()->startOfWeek(),
                        $today->copy()->endOfWeek()
                    ]);
                    break;
                case 'bulan_ini':
                    $query->whereBetween('tanggal', [
                        $today->copy()->startOfMonth(),
                        $today->copy()->endOfMonth()
                    ]);
                    break;
                case 'tahun_ini':
                    $query->whereBetween('tanggal', [
                        $today->copy()->startOfYear(),
                        $today->copy()->endOfYear()
                    ]);
                    break;
            }
        } else {
            // Default behavior if not specified? Or handle in controller? 
            // Controller had default to today if not filtered, let's keep it flexible or default here.
            // Looking at controller: } else { $query->whereDate('tanggal', $today); }
            // But ScanController::absensiData uses same logic but different defaults?
            // Let's stick to strict filter application. If 'periode' is passed, use it.
            // If caller wants default, they pass 'hari_ini' or we make it default.
        }

        // Manual default handling based on AbsensiController logic
        if (empty($filters['periode']) && empty($filters['ignore_default_date'])) {
            $query->whereDate('tanggal', $today);
        }

        // Filter nama siswa
        if (isset($filters['search']) && $filters['search']) {
            $query->whereHas('siswa', function ($q) use ($filters) {
                $q->where('nama_lengkap', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate($perPage);
    }

    public function getRekapAbsensi(array $filters, bool $paginate = false, int $perPage = 10)
    {
        $start_date = $filters['start_date'] ?? Carbon::today()->format('Y-m-d');
        $end_date = $filters['end_date'] ?? Carbon::today()->format('Y-m-d');

        // Validasi: end_date tidak boleh sebelum start_date
        if ($end_date < $start_date) {
            $end_date = $start_date;
        }

        // Batasi rentang maksimal 31 hari
        $diff_days = Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date));
        if ($diff_days > 31) {
            $end_date = Carbon::parse($start_date)->addDays(31)->format('Y-m-d');
        }

        $query = Siswa::with(['kelas', 'scans' => function ($query) use ($start_date, $end_date) {
            $query->whereBetween('tanggal', [$start_date, $end_date]);
        }]);

        if (isset($filters['kelas_id']) && $filters['kelas_id']) {
            $query->where('kelas_id', $filters['kelas_id']);
        }

        $query->orderBy('nama_lengkap');

        if ($paginate) {
            $siswas = $query->paginate($perPage)->withQueryString();
        } else {
            $siswas = $query->get();
        }

        // Generate date range
        $tanggal_range = [];
        $current = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);

        while ($current <= $end) {
            $tanggal_range[] = $current->format('Y-m-d');
            $current->addDay();
        }

        return [
            'siswas' => $siswas,
            'range' => $tanggal_range, // 'range' key matches original Service usage in Controller?? 
            // Original code: return compact('siswas', 'tanggal_range'...)
            // Wait, previous file view showed: return ['siswas'=>..., 'range'=>...] at line 111.
            // Check AbsensiController::review usage.
            // Controller: $data = $service->getRekapAbsensi(); return view(..., array_merge($data...));
            // View uses $tanggal_range.
            // Line 113 in view_file above says 'range'.
            // Controller expects 'tanggal_range'.
            // I should use 'tanggal_range' key to be safe or check Controller.
            // Controller: return view('absensi.review', compact('siswas', 'kelas', 'tanggal_range', ...)); 
            // My previous refactor to Service MIGHT have used 'range' but View needs 'tanggal_range'.
            // View `review.blade.php`: @foreach ($tanggal_range as $tanggal)
            // So key MUST be 'tanggal_range'. 
            // My previous View File output of Service (step 205) showed 'range'.
            // This suggests I might have broken the view in step 41/old refactor if I used 'range'.
            // I will correct it to 'tanggal_range'.
            'tanggal_range' => $tanggal_range,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
    }
}
