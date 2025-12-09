<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getLaporanData($request);
        return view('laporan.index', $data);
    }

    public function data(Request $request)
    {
        $data = $this->getLaporanData($request);
        return view('laporan.index', $data);
    }

    private function getLaporanData(Request $request)
    {
        $kelas = Kelas::all();

        // Query Siswa directly with Filters
        $query = Siswa::query()->where('status', '!=', 'alumni')->with('kelas');

        // Filter Kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter Nama
        if ($request->filled('nama')) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama . '%');
        }

        // Paginate Students first
        $perPage = $request->input('per_page', 10);
        $siswas = $query->orderBy('nama_lengkap')->paginate($perPage)->withQueryString();

        // Prepare stats for visible students only
        $rekap = $siswas->map(function ($siswa) use ($request) {
            $scanQuery = $siswa->scans();

            // Filter Bulan & Tahun on Scans
            if ($request->filled('bulan')) {
                $scanQuery->whereMonth('tanggal', $request->bulan);
            }
            if ($request->filled('tahun')) {
                $scanQuery->whereYear('tanggal', $request->tahun);
            }

            // Execute query to get stats
            // Optimasi: Use aggregates instead of get() if possible, but status is string column.
            // Using get() for limited range (1 student, 1 month/year) is fast enough.
            $scans = $scanQuery->get();

            return [
                'siswa'        => $siswa,
                'total_hadir'  => $scans->where('status', 'hadir')->count(),
                'total_sakit'  => $scans->where('status', 'sakit')->count(),
                'total_izin'   => $scans->where('status', 'izin')->count(),
                'total_alpha'  => $scans->where('status', 'alpha')->count(),
                'total_lambat' => $scans->where('status', 'lambat')->count(),
            ];
        });

        // We pass 'rekap' as the collection but we need pagination links from '$siswas'
        // So we should pass 'siswas' to view for links, and 'rekap' for data loop.

        return compact('kelas', 'rekap', 'siswas');
    }
}
