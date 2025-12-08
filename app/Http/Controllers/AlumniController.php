<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Display a listing of the alumni resource.
     */
    public function index(Request $request)
    {
        // Query only alumni
        $query = Siswa::where('status', 'alumni');

        // Filter by Tahun Lulus
        if ($request->has('tahun_lulus') && $request->tahun_lulus != '') {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        // Filter by Kelas Terakhir (Since we store string/snapshot, we query string)
        if ($request->has('kelas_terakhir') && $request->kelas_terakhir != '') {
            $query->where('kelas_terakhir', 'like', '%' . $request->kelas_terakhir . '%');
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        $siswas = $query->paginate(10);

        // Get distinct graduation years for filter
        $tahunLulusOptions = Siswa::where('status', 'alumni')->distinct()->pluck('tahun_lulus')->sort()->reverse();

        return view('alumni.index', compact('siswas', 'tahunLulusOptions'));
    }
}
