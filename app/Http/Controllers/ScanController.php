<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Scan;
use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
        ]);

        $uid = $request->uid;
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        // Cari siswa berdasarkan UID
        $siswa = Siswa::where('uid', $uid)->first();
        if (!$siswa) {
            return response()->json(['error' => 'UID tidak ditemukan'], 404);
        }

        // Ambil jadwal hari ini
        $jadwal = Jadwal::where('tanggal', $today)->first();
        if (!$jadwal) {
            return response()->json(['error' => 'Jadwal hari ini tidak ditemukan'], 404);
        }

        // Jika status jadwal = libur
        if ($jadwal->status === 'libur') {
            return response()->json(['error' => 'Hari ini libur, absensi dilarang!'], 403);
        }

        // Cek apakah siswa sudah punya absensi hari ini
        // $absen = Absensi::where('siswa_id', $siswa->id)->where('tanggal', $today)->first();
        $absen = Scan::where('siswa_id', $siswa->id)->where('tanggal', $today)->first();

        // Kalau sudah dicatat sakit/izin/alpha → larang scan
        if ($absen && in_array($absen->status, ['sakit', 'izin', 'alpha'])) {
            return response()->json(['error' => 'Siswa sudah tercatat ' . $absen->status . ' hari ini!'], 403);
        }

        // Jika belum ada, buat baru
        $absen = Scan::where('siswa_id', $siswa->id)->where('tanggal', $today)->first();

        if (!$absen) {
            $absen = Scan::create([
                'siswa_id' => $siswa->id,
                'tanggal' => $today,
            ]);
        }


        // Jika belum scan masuk
        if (is_null($absen->jam_masuk)) {
            if ($now->lte(Carbon::parse($jadwal->jam_masuk))) {
                $absen->update([
                    'jam_masuk' => $now->format('H:i:s'),
                    'status' => 'hadir',
                ]);
            } else {
                $absen->update([
                    'jam_masuk' => $now->format('H:i:s'),
                    'status' => 'lambat',
                ]);
            }
            return response()->json(['success' => 'Scan masuk berhasil', 'data' => $absen]);
        }

        // Jika sudah scan masuk, tapi belum scan keluar
        if (is_null($absen->jam_keluar)) {
            if ($now->lt(Carbon::parse($jadwal->jam_keluar))) {
                return response()->json(['error' => 'Belum waktunya pulang!'], 403);
            } else {
                $absen->update([
                    'jam_keluar' => $now->format('H:i:s'),
                ]);
                return response()->json(['success' => 'Scan pulang berhasil', 'data' => $absen]);
            }
        }

        // Jika sudah scan pulang
        return response()->json(['error' => 'Siswa sudah pulang hari ini!'], 403);
    }

    // API untuk siswa belum absen hari ini
    public function siswaBelumAbsen()
    {
        $today = now('Asia/Jakarta')->toDateString();
        $sudahAbsen = Scan::where('tanggal', $today)->pluck('siswa_id');

        $siswas = Siswa::with('kelas')
            ->whereNotIn('id', $sudahAbsen)
            ->orderBy('nama_lengkap')
            ->get();

        return response()->json($siswas);
    }


    public function list()
    {
        $today = now('Asia/Jakarta')->toDateString();
        $data = Scan::with(['siswa.kelas'])
            ->where('tanggal', $today)
            ->orderBy('jam_masuk', 'asc')
            ->get();


        return response()->json($data);
    }

    public function inputManual()
    {
        $today = now('Asia/Jakarta')->toDateString();

        $siswas = \App\Models\Siswa::whereDoesntHave('scans', function ($q) use ($today) {
            $q->where('tanggal', $today);
        })
            ->with('kelas')
            ->orderBy('nama_lengkap')
            ->get();


        return view('scan.input-manual', compact('siswas'));
    }

    public function inputManualSimpan(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'status'   => 'required|in:sakit,izin,alpha',
        ]);

        $today = now('Asia/Jakarta')->toDateString();

        $jadwal = \App\Models\Jadwal::where('tanggal', $today)->first();
        if (!$jadwal) {
            return response()->json(['error' => 'Tidak ada jadwal hari ini'], 403);
        }
        if ($jadwal->status === 'libur') {
            return response()->json(['error' => 'Hari ini libur, absensi manual tidak diperbolehkan'], 403);
        }

        $absen = \App\Models\Scan::updateOrCreate(
            ['siswa_id' => $request->siswa_id, 'tanggal' => $today],
            ['status' => $request->status, 'jam_masuk' => null, 'jam_keluar' => null]
        );


        return response()->json(['success' => 'Absensi manual berhasil disimpan', 'data' => $absen]);
    }

    // Tambahkan method ini di ScanController.php Anda yang sudah ada

    public function submitWithNotification(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
        ]);

        $uid = $request->uid;
        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        // Cari siswa berdasarkan UID
        $siswa = Siswa::where('uid', $uid)->first();
        if (!$siswa) {
            return response()->json(['error' => 'UID tidak ditemukan'], 404);
        }

        // Ambil jadwal hari ini
        $jadwal = Jadwal::where('tanggal', $today)->first();
        if (!$jadwal) {
            return response()->json(['error' => 'Jadwal hari ini tidak ditemukan'], 404);
        }

        // Jika status jadwal = libur
        if ($jadwal->status === 'libur') {
            return response()->json(['error' => 'Hari ini libur, absensi dilarang!'], 403);
        }

        // Cek apakah siswa sudah punya absensi hari ini
        $absen = Scan::where('siswa_id', $siswa->id)->where('tanggal', $today)->first();

        // Kalau sudah dicatat sakit/izin/alpha → larang scan
        if ($absen && in_array($absen->status, ['sakit', 'izin', 'alpha'])) {
            return response()->json(['error' => 'Siswa sudah tercatat ' . $absen->status . ' hari ini!'], 403);
        }

        // Jika belum ada, buat baru
        if (!$absen) {
            $absen = Scan::create([
                'siswa_id' => $siswa->id,
                'tanggal' => $today,
            ]);
        }

        // Jika belum scan masuk
        if (is_null($absen->jam_masuk)) {
            if ($now->lte(Carbon::parse($jadwal->jam_masuk))) {
                $absen->update([
                    'jam_masuk' => $now->format('H:i:s'),
                    'status' => 'hadir',
                ]);
            } else {
                $absen->update([
                    'jam_masuk' => $now->format('H:i:s'),
                    'status' => 'lambat',
                ]);
            }

            // Event untuk real-time update (optional dengan broadcasting)
            // broadcast(new AbsensiUpdated($absen))->toOthers();

            return response()->json([
                'success' => 'Scan masuk berhasil',
                'data' => $absen->load('siswa.kelas'),
                'type' => 'masuk'
            ]);
        }

        // Jika sudah scan masuk, tapi belum scan keluar
        if (is_null($absen->jam_keluar)) {
            if ($now->lt(Carbon::parse($jadwal->jam_keluar))) {
                return response()->json(['error' => 'Belum waktunya pulang!'], 403);
            } else {
                $absen->update([
                    'jam_keluar' => $now->format('H:i:s'),
                ]);

                // Event untuk real-time update (optional)
                // broadcast(new AbsensiUpdated($absen))->toOthers();

                return response()->json([
                    'success' => 'Scan pulang berhasil',
                    'data' => $absen->load('siswa.kelas'),
                    'type' => 'keluar'
                ]);
            }
        }

        // Jika sudah scan pulang
        return response()->json(['error' => 'Siswa sudah pulang hari ini!'], 403);
    }

    public function absensiIndex()
    {
        $kelas = Kelas::all();
        return view('absensi.index', compact('kelas'));
    }

    public function absensiData(Request $request)
    {
        $query = Scan::with(['siswa.kelas']);

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter berdasarkan waktu
        if ($request->filled('periode')) {
            $now = Carbon::now('Asia/Jakarta');

            switch ($request->periode) {
                case 'hari_ini':
                    $query->whereDate('tanggal', $now->toDateString());
                    break;
                case 'minggu_ini':
                    $query->whereBetween('tanggal', [
                        $now->startOfWeek()->toDateString(),
                        $now->endOfWeek()->toDateString()
                    ]);
                    break;
                case 'bulan_ini':
                    $query->whereBetween('tanggal', [
                        $now->startOfMonth()->toDateString(),
                        $now->endOfMonth()->toDateString()
                    ]);
                    break;
                case 'tahun_ini':
                    $query->whereBetween('tanggal', [
                        $now->startOfYear()->toDateString(),
                        $now->endOfYear()->toDateString()
                    ]);
                    break;
            }
        }

        // Filter berdasarkan nama siswa
        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $absensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate(10);

        return view('absensi.partials.data', compact('absensi'));
    }
}
