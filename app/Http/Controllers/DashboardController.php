<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Scan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Total siswa
        $totalSiswa = Siswa::count();

        // Data absensi hari ini (ALL for calculations if needed, but we can query directly)
        // Optimization: Query counts directly for better performance
        $hadirToday = Scan::whereDate('tanggal', $today)->where('status', 'hadir')->count();
        $terlambatToday = Scan::whereDate('tanggal', $today)->whereIn('status', ['lambat', 'terlambat'])->count(); // Handle 'lambat' or 'terlambat' just in case

        // Total Absen (Hadir + Terlambat + Sakit + Izin + Alpha?) 
        // Usually "Total Absen" implies "Present". Let's stick to "Hadir + Terlambat" as "Present" or just distinct counts.
        // The user request asked for "Hadir" and "Terlambat" cards.

        // Sakit, Izin, Alpha
        $sakitToday = Scan::whereDate('tanggal', $today)->where('status', 'sakit')->count();
        $izinToday = Scan::whereDate('tanggal', $today)->where('status', 'izin')->count();
        $alphaToday = Scan::whereDate('tanggal', $today)->where('status', 'alpha')->count();

        // Total Scans Today (unique siswa? Assuming one scan per day per siswa for simplicity or just count rows)
        // Correct logic for "Belum Absen": Total Siswa - (Hadir + Terlambat + Sakit + Izin + Alpha + ... basically count of distinct siswa who have a record today)
        // Or simpler: Total Siswa - Count of Scans today.
        $totalScansToday = Scan::whereDate('tanggal', $today)->count();
        $belumAbsen = $totalSiswa - $totalScansToday;
        if ($belumAbsen < 0) $belumAbsen = 0; // Safety check

        // 10 Siswa Terakhir Absen
        $recentActivities = Scan::with('siswa.kelas')
            ->whereDate('tanggal', $today)
            ->orderBy('updated_at', 'desc') // Or created_at, usually updated_at for scan out
            ->limit(10)
            ->get();

        // 7-day Trend Data
        $startDate = Carbon::today()->subDays(6);
        $trendData = Scan::select(DB::raw('DATE(tanggal) as date'), DB::raw('count(*) as count'))
            ->where('tanggal', '>=', $startDate)
            ->whereIn('status', ['hadir', 'lambat', 'terlambat']) // Filter only present
            ->groupBy(DB::raw('DATE(tanggal)')) // explicit group by expression
            ->orderBy('date', 'asc')
            ->get();

        // Prepare labels and data for the chart ensures all 7 days are present even if count is 0
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::today()->subDays($i)->isoFormat('dddd'); // Day name
            $count = $trendData->firstWhere('date', $date)->count ?? 0;
            $chartData[] = $count;
        }

        return view('dashboard', compact(
            'totalSiswa',
            'hadirToday',
            'terlambatToday',
            'sakitToday',
            'izinToday',
            'alphaToday',
            'belumAbsen',
            'recentActivities',
            'chartLabels',
            'chartData'
        ));
    }
}
