<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Scan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Total siswa
        $totalSiswa = Siswa::count();

        // Data absensi hari ini
        $scansToday = Scan::with('siswa.kelas')
            ->whereDate('tanggal', $today)
            ->get();

        // Sudah absen
        $totalAbsen = $scansToday->count();

        // Belum absen
        $belumAbsen = $totalSiswa - $totalAbsen;

        return view('dashboard', compact(
            'totalSiswa',
            'totalAbsen',
            'belumAbsen',
            'scansToday'
        ));
    }
}
