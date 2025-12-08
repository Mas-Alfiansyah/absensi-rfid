<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'nisn',
        'nama_lengkap',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'kelas_id',
        'jenis_kelamin',
        'no_wa',
        'foto',
        'status',
        'tahun_lulus',
        'kelas_terakhir',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // public function absensi()
    // {
    //     return $this->hasMany(Absensi::class);
    // }
    public function scans()
    {
        return $this->hasMany(Scan::class, 'siswa_id');
    }
}
