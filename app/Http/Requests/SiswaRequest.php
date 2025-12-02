<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class SiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $siswaId = $this->route('siswa') ? $this->route('siswa')->id : null;


        return [
            'uid' => 'required|string|max:255|unique:siswas,uid,' . $siswaId,
            'nisn' => 'required|string|max:255|unique:siswas,nisn,' . $siswaId,
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'kelas_id' => 'nullable|exists:kelas,id',
            'jenis_kelamin' => 'nullable|in:L,P',
            'no_wa' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
