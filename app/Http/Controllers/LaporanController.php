<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();

        // ambil semua scan (default: semua data)
        $scans = Scan::with(['siswa.kelas'])->get();

        // rekap langsung
        $rekap = $scans->groupBy('siswa_id')->map(function ($items) {
            return [
                'siswa'        => $items->first()->siswa,
                'total_hadir'  => $items->where('status', 'hadir')->count(),
                'total_sakit'  => $items->where('status', 'sakit')->count(),
                'total_izin'   => $items->where('status', 'izin')->count(),
                'total_alpha'  => $items->where('status', 'alpha')->count(),
                'total_lambat' => $items->where('status', 'lambat')->count(),
            ];
        })->values();

        return view('laporan.index', compact('kelas', 'rekap'));
    }


    public function data(Request $request)
    {
        $query = Scan::with(['siswa.kelas']);

        // filter kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // filter nama
        if ($request->filled('nama')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->nama . '%');
            });
        }

        // filter bulan & tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $scans = $query->get();

        $rekap = $scans->groupBy('siswa_id')->map(function ($items) {
            return [
                'siswa'        => $items->first()->siswa,
                'total_hadir'  => $items->where('status', 'hadir')->count(),
                'total_sakit'  => $items->where('status', 'sakit')->count(),
                'total_izin'   => $items->where('status', 'izin')->count(),
                'total_alpha'  => $items->where('status', 'alpha')->count(),
                'total_lambat' => $items->where('status', 'lambat')->count(),
            ];
        })->values();

        $kelas = Kelas::all();

        return view('laporan.index', compact('rekap', 'kelas'));
    }
}
