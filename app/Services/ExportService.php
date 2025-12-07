<?php

namespace App\Services;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kelas;

class ExportService
{
    public function generatePdfHtml($siswas, $hari_range, $start_date, $end_date, $kelas)
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
