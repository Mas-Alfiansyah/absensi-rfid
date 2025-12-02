<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        // Generate jadwal untuk 7 hari ke depan (akan otomatis mengelola database)
        $jadwals = Jadwal::generateJadwalMingguan();
        
        return view('jadwal.index', compact('jadwals'));
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jam_masuk' => 'required_if:status,masuk|nullable|date_format:H:i',
            'jam_keluar' => 'required_if:status,masuk|nullable|date_format:H:i|after:jam_masuk',
            'status' => 'required|in:libur,masuk',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'jam_keluar.after' => 'Jam keluar harus setelah jam masuk.',
            'jam_masuk.required_if' => 'Jam masuk wajib diisi ketika status masuk.',
            'jam_keluar.required_if' => 'Jam keluar wajib diisi ketika status masuk.',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        $data = [
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        // Hanya update jam jika status adalah masuk
        if ($request->status == 'masuk') {
            $data['jam_masuk'] = $request->jam_masuk;
            $data['jam_keluar'] = $request->jam_keluar;
        } else {
            $data['jam_masuk'] = null;
            $data['jam_keluar'] = null;
            
            // Jika status libur dan keterangan kosong, set default
            if (empty($request->keterangan)) {
                $data['keterangan'] = 'Hari Libur';
            }
        }

        $jadwal->update($data);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }
}