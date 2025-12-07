<?php

namespace App\Services;

use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;

class SiswaService
{
    public function createSiswa(array $data)
    {
        // Format No WA
        if (isset($data['no_wa'])) {
            $noWa = preg_replace('/\D/', '', $data['no_wa']);
            $data['no_wa'] = substr($noWa, 0, 4) . '-' . substr($noWa, 4, 4) . '-' . substr($noWa, 8);
        }

        // Handle Photo
        if (isset($data['foto']) && $data['foto'] instanceof \Illuminate\Http\UploadedFile) {
            $data['foto'] = $data['foto']->store('fotos', 'public');
        } else {
            $data['foto'] = 'fotos/default.png';
        }

        return Siswa::create($data);
    }

    public function updateSiswa(Siswa $siswa, array $data)
    {
        // Format No WA (if present)
        if (isset($data['no_wa'])) {
            // Re-format logic (assuming it comes raw or needs validation? validation done in controller/request)
            // But controller logic was explicit:
            // $noWa = preg_replace('/\D/', '', $request->no_wa);
            // $data['no_wa'] = ...
            // Wait, updateSiswa in controller defines 'no_wa' validation rule regex.
            // But doesn't reformat it in the `update` method logic seen?
            // Let's check SiswaController::update again.

            // Checking SiswaController::update content...
            // It just does $siswa->update($data). It DOES NOT reformat no_wa in update method!
            // Wait, create method DOES reformat.
            // Update method validates "regex:/^[0-9]{4}-[0-9]{4}-[0-9]{4}$/", so it expects it to be ALREADY formatted/inputted correctly by user?
            // Or maybe the input mask handles it?
            // In Store:
            // $noWa = preg_replace('/\D/', '', $request->no_wa);
            // $data['no_wa'] = ...
            // In Update:
            // validation requires formatted string.
            // If I look closely at the regex: /^[0-9]{4}-[0-9]{4}-[0-9]{4}$/
            // So in update, user must supply formatted string.
            // In create, code manually formats it.
            // This suggests inconsistent behavior or I missed something.
            // Let's replicate Controller logic: Logic is mostly validation in Controller. 
            // In update, it checks file upload.
        }

        if (isset($data['foto']) && $data['foto'] instanceof \Illuminate\Http\UploadedFile) {
            if ($siswa->foto && $siswa->foto !== 'fotos/default.png' && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $data['foto']->store('fotos', 'public');
        }

        $siswa->update($data);
        return $siswa;
    }

    public function deleteSiswa(Siswa $siswa)
    {
        if ($siswa->foto && $siswa->foto !== 'fotos/default.png' && Storage::disk('public')->exists($siswa->foto)) {
            Storage::disk('public')->delete($siswa->foto);
        }
        $siswa->delete();
    }
}
