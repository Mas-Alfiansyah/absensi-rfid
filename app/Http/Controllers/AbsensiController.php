<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Scan::with(['siswa.kelas']);

        // Filter kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter waktu dengan timezone yang konsisten
        $today = Carbon::today('Asia/Jakarta');

        if ($request->filled('periode')) {
            switch ($request->periode) {
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
            // Default hari ini
            $query->whereDate('tanggal', $today);
        }

        // Filter nama siswa
        if ($request->filled('search')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $absensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate(20);

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('absensi.index', compact('absensi', 'kelas'));
    }

    public function review(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        // Validasi tanggal
        $start_date = $request->filled('start_date') ? $request->start_date : Carbon::today()->format('Y-m-d');
        $end_date = $request->filled('end_date') ? $request->end_date : Carbon::today()->format('Y-m-d');

        // Validasi: end_date tidak boleh sebelum start_date
        if ($end_date < $start_date) {
            $end_date = $start_date;
        }

        // Batasi rentang maksimal 31 hari untuk performa
        $diff_days = Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date));
        if ($diff_days > 31) {
            $end_date = Carbon::parse($start_date)->addDays(31)->format('Y-m-d');
        }

        $siswas = Siswa::with(['kelas', 'scans' => function ($query) use ($start_date, $end_date) {
            $query->whereBetween('tanggal', [$start_date, $end_date]);
        }]);

        if ($request->filled('kelas_id')) {
            $siswas->where('kelas_id', $request->kelas_id);
        }

        $siswas = $siswas->orderBy('nama_lengkap')->get();

        // Generate array tanggal untuk header
        $tanggal_range = [];
        $current = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);

        while ($current <= $end) {
            $tanggal_range[] = $current->format('Y-m-d');
            $current->addDay();
        }

        return view('absensi.review', compact('siswas', 'kelas', 'tanggal_range', 'start_date', 'end_date'));
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $kelas_id = $request->kelas_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        // Batasi rentang maksimal 31 hari untuk Excel
        $diff_days = Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date));
        if ($diff_days > 31) {
            return back()->with('error', 'Rentang tanggal maksimal 31 hari untuk ekspor Excel.');
        }

        $filename = 'absensi_' . $start_date . '_to_' . $end_date;
        if ($kelas_id) {
            $kelas = Kelas::find($kelas_id);
            $filename .= '_' . ($kelas->nama_kelas ?? 'all');
        }
        $filename .= '.xlsx';

        return Excel::download(new AbsensiExport($kelas_id, $start_date, $end_date), $filename);
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $kelas_id = $request->kelas_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $siswas = Siswa::with(['kelas', 'scans' => function ($query) use ($start_date, $end_date) {
            $query->whereBetween('tanggal', [$start_date, $end_date]);
        }]);

        if ($kelas_id) {
            $siswas->where('kelas_id', $kelas_id);
        }

        $siswas = $siswas->orderBy('nama_lengkap')->get();

        // Generate array hari (tanpa kolom kelas)
        $hari_range = [];
        $current = Carbon::parse($start_date);
        $end = Carbon::parse($end_date);

        while ($current <= $end) {
            $hari_range[] = [
                'tanggal' => $current->format('Y-m-d'),
                'hari' => $current->translatedFormat('l')
            ];
            $current->addDay();
        }

        $kelas = $kelas_id ? Kelas::find($kelas_id) : null;

        // Gunakan view inline tanpa file blade
        $html = $this->generatePdfHtml($siswas, $hari_range, $start_date, $end_date, $kelas);

        $pdf = PDF::loadHTML($html)
            ->setPaper('landscape')
            ->setOption('margin-top', 10)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5);

        $filename = 'absensi_' . $start_date . '_to_' . $end_date;
        if ($kelas_id) {
            $filename .= '_' . ($kelas->nama_kelas ?? 'all');
        }
        $filename .= '.pdf';

        return $pdf->download($filename);
    }

    private function generatePdfHtml($siswas, $hari_range, $start_date, $end_date, $kelas)
{
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Laporan Absensi</title>
        <style>
            body { 
                font-family: DejaVu Sans, Arial, sans-serif; /* TAMBAH FONT FALLBACK */
                font-size: 10px; 
                margin: 0;
                padding: 5px;
            }
            .header { 
                text-align: center; 
                margin-bottom: 10px;
                padding-bottom: 5px;
            }
            .header h2 { 
                margin: 0; 
                font-size: 14px;
                color: #2E86C1;
                font-family: DejaVu Sans, Arial, sans-serif; /* PASTIKAN FONT SAMA */
            }
            .header h3 {
                margin: 2px 0;
                font-size: 12px;
                color: #5DADE2;
                font-family: DejaVu Sans, Arial, sans-serif;
            }
            .periode { 
                text-align: center; 
                margin-bottom: 10px;
                font-size: 10px;
                background-color: #F8F9F9;
                padding: 5px;
                font-family: DejaVu Sans, Arial, sans-serif;
            }
            table { 
                width: 100%; 
                border-collapse: collapse; 
                font-size: 9px; /* SESUAIKAN UKURAN FONT */
                font-family: DejaVu Sans, Arial, sans-serif; /* FONT UNTUK TABEL */
            }
            th, td { 
                border: 1px solid #000000; 
                padding: 4px; 
                text-align: center; 
                font-family: DejaVu Sans, Arial, sans-serif; /* FONT UNTUK SEL */
            }
            th { 
                background-color: #2E86C1; 
                color: white;
                font-weight: bold;
                font-size: 9px;
                font-family: DejaVu Sans, Arial, sans-serif;
            }
            .text-left { 
                text-align: left; 
                font-family: DejaVu Sans, Arial, sans-serif; /* FONT KHUSUS UNTUK RATA KIRI */
            }
            .nama-siswa { 
                font-size: 9px; 
                font-weight: 500;
                font-family: DejaVu Sans, Arial, sans-serif; /* FONT EXPLICIT UNTUK NAMA SISWA */
            }
            .footer {
                margin-top: 10px;
                text-align: right;
                font-size: 8px;
                color: #7F8C8D;
                font-family: DejaVu Sans, Arial, sans-serif;
            }
            .table-header {
                background-color: #5DADE2;
                color: white;
                font-family: DejaVu Sans, Arial, sans-serif;
            }
            .hadir { color: #27AE60; font-weight: bold; font-family: DejaVu Sans, Arial, sans-serif; }
            .sakit { color: #3498DB; font-weight: bold; font-family: DejaVu Sans, Arial, sans-serif; }
            .izin { color: #9B59B6; font-weight: bold; font-family: DejaVu Sans, Arial, sans-serif; }
            .alpha { color: #E74C3C; font-weight: bold; font-family: DejaVu Sans, Arial, sans-serif; }
            
            /* STYLE KHUSUS UNTUK DATA NAMA SISWA */
            .data-nama {
                font-family: DejaVu Sans, Arial, sans-serif;
                font-size: 9px;
                font-weight: normal;
                text-align: left;
                padding-left: 8px;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <h2>LAPORAN ABSENSI SISWA</h2>';
            
    if ($kelas) {
        $html .= '<h3>KELAS: ' . strtoupper($kelas->nama_kelas) . '</h3>';
    } else {
        $html .= '<h3>SEMUA KELAS</h3>';
    }
    
    $html .= '
        </div>
        
        <div class="periode">
            <strong>PERIODE: ' . Carbon::parse($start_date)->translatedFormat('d F Y') . ' - ' . Carbon::parse($end_date)->translatedFormat('d F Y') . '</strong>
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="2" width="15">NO</th>
                    <th rowspan="2" width="130" class="text-left">NAMA SISWA</th>';
    
    // Header hari
    foreach ($hari_range as $hari) {
        $html .= '<th colspan="2" width="60" class="table-header">' . $hari['hari'] . '</th>';
    }
    
    $html .= '
                </tr>
                <tr>';
    
    // Sub header M/P
    foreach ($hari_range as $hari) {
        $html .= '<th width="15">M</th>
                  <th width="15">P</th>';
    }
    
    $html .= '
                </tr>
            </thead>
            <tbody>';
    
    // Data siswa - GUNAKAN CLASS data-nama UNTUK NAMA SISWA
    foreach ($siswas as $index => $siswa) {
        $html .= '
                <tr>
                    <td>' . ($index + 1) . '</td>
                    <td class="data-nama">' . $siswa->nama_lengkap . '</td>'; // CLASS data-nama
        
        foreach ($hari_range as $hari) {
            $scan = $siswa->scans->where('tanggal', $hari['tanggal'])->first();
            
            // Kolom Masuk
            $html .= '<td>';
            if ($scan) {
                if ($scan->status === 'sakit') $html .= '<span class="sakit">S</span>';
                elseif ($scan->status === 'izin') $html .= '<span class="izin">I</span>';
                elseif ($scan->status === 'alpha') $html .= '<span class="alpha">A</span>';
                elseif ($scan->jam_masuk) $html .= '<span class="hadir">✓</span>';
                else $html .= '-';
            } else {
                $html .= '-';
            }
            $html .= '</td>';
            
            // Kolom Pulang
            $html .= '<td>';
            if ($scan && $scan->jam_keluar) {
                $html .= '<span class="hadir">✓</span>';
            } else {
                $html .= '-';
            }
            $html .= '</td>';
        }
        
        $html .= '</tr>';
    }
    
    $html .= '
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak pada: ' . Carbon::now()->translatedFormat('d F Y H:i') . ' | Total Siswa: ' . $siswas->count() . '</p>
        </div>
    </body>
    </html>';
    
    return $html;
}
}
