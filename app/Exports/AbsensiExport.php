<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Carbon\Carbon;

class AbsensiExport implements FromCollection, WithMapping, WithStyles, WithEvents
{
    protected $kelas_id; // Still kept for title generation, pass it or derive? Title uses $this->kelas_id.
    protected $start_date;
    protected $end_date;
    protected $hari_range;
    protected $siswas;

    public function __construct($siswas, $start_date, $end_date, $kelas_id = null)
    {
        $this->siswas = $siswas;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->kelas_id = $kelas_id;

        $this->hari_range = [];
        $current = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        while ($current <= $end) {
            $this->hari_range[] = $current->translatedFormat('l');
            $current->addDay();
        }
    }

    public function collection()
    {
        return $this->siswas;
    }

    // getSiswas method removed as data is injected.

    public function map($siswa): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->fromArray([], null, 'A1');

                $totalHari = count($this->hari_range);
                $totalColumns = 2 + ($totalHari * 2); // DIKURANGI 1 KOLOM (KELAS DIHAPUS)
                $lastDataRow = 5 + $this->siswas->count();

                $this->setupPage($sheet, $totalColumns, $lastDataRow);
                $this->setTitles($sheet, $totalColumns);
                $this->createHeader($sheet, $totalHari, $totalColumns);
                $this->fillData($sheet);
                $this->applyBorderStyling($sheet, $totalColumns, $lastDataRow);
                $this->setZoomToFit($sheet, $totalColumns, $lastDataRow);
            },
        ];
    }

    private function setupPage($sheet, $totalColumns, $lastDataRow)
    {
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

        $lastCol = Coordinate::stringFromColumnIndex($totalColumns);
        $sheet->getPageSetup()->setPrintArea('A1:' . $lastCol . $lastDataRow);
    }

    private function setTitles($sheet, $totalColumns)
    {
        $lastCol = Coordinate::stringFromColumnIndex($totalColumns);

        $sheet->setCellValue('A1', 'LAPORAN ABSENSI SISWA');
        $sheet->mergeCells('A1:' . $lastCol . '1');

        $kelasText = $this->kelas_id ?
            'KELAS: ' . strtoupper(\App\Models\Kelas::find($this->kelas_id)->nama_kelas ?? 'SEMUA KELAS') :
            'SEMUA KELAS';
        $sheet->setCellValue('A2', $kelasText);
        $sheet->mergeCells('A2:' . $lastCol . '2');

        $periodeText = 'PERIODE: ' .
            Carbon::parse($this->start_date)->translatedFormat('d F Y') . ' - ' .
            Carbon::parse($this->end_date)->translatedFormat('d F Y');
        $sheet->setCellValue('A3', $periodeText);
        $sheet->mergeCells('A3:' . $lastCol . '3');

        $titleStyle = [
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '2E86C1']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F8F9F9']]
        ];

        $sheet->getStyle('A1:' . $lastCol . '3')->applyFromArray($titleStyle);
    }

    private function createHeader($sheet, $totalHari, $totalColumns)
    {
        $lastCol = Coordinate::stringFromColumnIndex($totalColumns);

        // HANYA 2 KOLOM: NO dan NAMA SISWA (KELAS DIHAPUS)
        $sheet->setCellValue('A4', 'NO');
        $sheet->setCellValue('B4', 'NAMA SISWA');
        // KOLOM C DIHAPUS (KELAS)

        // MERGE VERTICAL (2 KOLOM SAJA)
        $sheet->mergeCells('A4:A5');
        $sheet->mergeCells('B4:B5');

        // HEADER HARI DIMULAI DARI KOLOM C (SEBELUMNYA D)
        $colIndex = 3; // MULAI DARI KOLOM C (KARENA KELAS DIHAPUS)
        foreach ($this->hari_range as $hari) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $nextCol = Coordinate::stringFromColumnIndex($colIndex + 1);

            $sheet->setCellValue($colLetter . '4', $hari);
            $sheet->mergeCells($colLetter . '4:' . $nextCol . '4');

            $colIndex += 2;
        }

        // SUB HEADER M/P
        $colIndex = 3;
        foreach ($this->hari_range as $hari) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $nextCol = Coordinate::stringFromColumnIndex($colIndex + 1);

            $sheet->setCellValue($colLetter . '5', 'M');
            $sheet->setCellValue($nextCol . '5', 'P');

            $colIndex += 2;
        }

        // STYLE HEADER TANPA BORDER (BORDER HANYA UNTUK TABEL)
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '2E86C1']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]
        ];

        $sheet->getStyle('A4:' . $lastCol . '5')->applyFromArray($headerStyle);

        // STYLE HEADER HARI (WARNA BIRU MUDA)
        $colIndex = 3;
        foreach ($this->hari_range as $hari) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex);
            $nextCol = Coordinate::stringFromColumnIndex($colIndex + 1);

            $sheet->getStyle($colLetter . '4:' . $nextCol . '4')
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB('5DADE2');

            $colIndex += 2;
        }
    }

    private function fillData($sheet)
    {
        $startRow = 6;

        foreach ($this->siswas as $index => $siswa) {
            $currentRow = $startRow + $index;

            // HANYA 2 KOLOM DATA: NO dan NAMA (KELAS DIHAPUS)
            $sheet->setCellValue('A' . $currentRow, $index + 1);
            $sheet->setCellValue('B' . $currentRow, $siswa->nama_lengkap);
            // KOLOM C DIHAPUS (KELAS)

            $currentDate = Carbon::parse($this->start_date);
            $colIndex = 3; // MULAI DARI KOLOM C (KARENA KELAS DIHAPUS)

            for ($i = 0; $i < count($this->hari_range); $i++) {
                $tanggal = $currentDate->format('Y-m-d');
                $scan = $siswa->scans->where('tanggal', $tanggal)->first();

                $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                $value = '-';
                if ($scan) {
                    if ($scan->status === 'sakit') $value = 'S';
                    elseif ($scan->status === 'izin') $value = 'I';
                    elseif ($scan->status === 'alpha') $value = 'A';
                    elseif ($scan->jam_masuk) $value = '✓';
                }
                $sheet->setCellValue($colLetter . $currentRow, $value);

                $colLetter = Coordinate::stringFromColumnIndex($colIndex + 1);
                $value = ($scan && $scan->jam_keluar) ? '✓' : '-';
                $sheet->setCellValue($colLetter . $currentRow, $value);

                $colIndex += 2;
                $currentDate->addDay();
            }
        }
    }

    private function applyBorderStyling($sheet, $totalColumns, $lastDataRow)
    {
        $lastCol = Coordinate::stringFromColumnIndex($totalColumns);

        // **BORDER HANYA UNTUK TABEL (ROW 4 KE BAWAH) - WARNA HITAM**
        $tableBorderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'] // HITAM
                ],
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'] // HITAM
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];

        // APLIKASI BORDER HANYA PADA AREA TABEL (HEADER + DATA)
        $sheet->getStyle('A4:' . $lastCol . $lastDataRow)->applyFromArray($tableBorderStyle);

        // **STYLE KHUSUS UNTUK KOLOM NAMA SISWA - FIX FONT**
        if ($lastDataRow >= 6) {
            $sheet->getStyle('B6:B' . $lastDataRow)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'font' => [ // TAMBAHKAN STYLE FONT EXPLICIT
                    'name' => 'Arial',
                    'size' => 10,
                    'color' => ['rgb' => '000000']
                ]
            ]);
        }

        // **STYLE UNTUK SELURUH DATA AGAR FONT KONSISTEN**
        $sheet->getStyle('A6:' . $lastCol . $lastDataRow)->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'size' => 10,
                'color' => ['rgb' => '000000']
            ]
        ]);

        // SET COLUMN WIDTH (TANPA KOLOM KELAS)
        $sheet->getColumnDimension('A')->setWidth(6);   // NO
        $sheet->getColumnDimension('B')->setWidth(40);  // NAMA SISWA (LEBIH LEBAR)

        // KOLOM HARI (M dan P)
        for ($col = 3; $col <= $totalColumns; $col++) {
            $sheet->getColumnDimension(Coordinate::stringFromColumnIndex($col))->setWidth(8);
        }

        // SET ROW HEIGHT
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(2)->setRowHeight(22);
        $sheet->getRowDimension(3)->setRowHeight(20);
        $sheet->getRowDimension(4)->setRowHeight(25);
        $sheet->getRowDimension(5)->setRowHeight(20);

        // **SET FONT UNTUK HEADER JUGA AGAR KONSISTEN**
        $sheet->getStyle('A4:' . $lastCol . '5')->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'size' => 10,
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ]
        ]);
    }

    private function setZoomToFit($sheet, $totalColumns, $lastDataRow)
    {
        $totalWidth = 6 + 40 + (count($this->hari_range) * 16); // TANPA KOLOM KELAS
        $totalHeight = (5 + $this->siswas->count()) * 18;

        if ($totalWidth > 150 || $totalHeight > 500) {
            $sheet->getSheetView()->setZoomScale(75);
        } else {
            $sheet->getSheetView()->setZoomScale(100);
        }

        $sheet->setSelectedCells('A1');
    }
}
