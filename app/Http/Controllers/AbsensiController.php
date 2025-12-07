<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AbsensiService;
use App\Services\ExportService;
use App\Models\Kelas;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class AbsensiController extends Controller
{
    protected $absensiService;
    protected $exportService;

    public function __construct(AbsensiService $absensiService, ExportService $exportService)
    {
        $this->absensiService = $absensiService;
        $this->exportService = $exportService;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $absensi = $this->absensiService->getAbsensiList($request->all(), $perPage);

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('absensi.index', compact('absensi', 'kelas'));
    }

    public function review(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        // Logic moved to Service, but Service returns array of data.
        $perPage = $request->input('per_page', 10);
        $data = $this->absensiService->getRekapAbsensi($request->all(), true, $perPage);

        return view('absensi.review', array_merge($data, compact('kelas')));
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

        // Batasi rentang maksimal 31 hari untuk Excel (Validation Logic kept in Controller)
        $diff_days = Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date));
        if ($diff_days > 31) {
            return back()->with('error', 'Rentang tanggal maksimal 31 hari untuk ekspor Excel.');
        }

        // Get data from Service
        $data = $this->absensiService->getRekapAbsensi($request->all());

        $filename = 'absensi_' . $start_date . '_to_' . $end_date;
        if ($kelas_id) {
            $kelas = Kelas::find($kelas_id);
            $filename .= '_' . ($kelas->nama_kelas ?? 'all');
        }
        $filename .= '.xlsx';

        return Excel::download(new AbsensiExport($data['siswas'], $start_date, $end_date, $kelas_id), $filename);
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

        // Get Data
        // Note: Logic in original exportPdf did NOT check 31 days limit explicitly with error, 
        // but logic for 'rekap' usually clamps or allows. 
        // Original exportPdf code: Did not have validation for 31 days.
        // But `generatePdfHtml` is heavy, so maybe it should? 
        // I'll stick to original behavior (no error check), just Service clamping if implemented there (Service clamps).

        $data = $this->absensiService->getRekapAbsensi($request->all());

        // $data contains 'siswas', 'range' (not 'hari_range' format needed for pdf?), 'start_date', 'end_date'
        // Service returns 'range' as simple array of dates ['2023-01-01', ...]
        // exportPdf generated 'hari_range' as [['tanggal'=>..., 'hari'=>...]].
        // I need to map it or update Service to return detailed range?
        // Let's generate 'hari_range' here or inside ExportService?
        // ExportService::generatePdfHtml expects $hari_range with [['tanggal', 'hari']].
        // My Service returns simple $range.

        // Let's prepare hari_range:
        $hari_range = [];
        foreach ($data['range'] as $date) {
            $hari_range[] = [
                'tanggal' => $date,
                'hari' => Carbon::parse($date)->translatedFormat('l')
            ];
        }

        $kelas = $kelas_id ? Kelas::find($kelas_id) : null;

        $html = $this->exportService->generatePdfHtml(
            $data['siswas'],
            $hari_range,
            $data['start_date'],
            $data['end_date'],
            $kelas
        );

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
}
