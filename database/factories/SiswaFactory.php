<?php

namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SiswaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Siswa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil ID kelas secara acak. Asumsi tabel 'kelas' sudah ada datanya.
        // Jika tabel 'kelas' kosong, ganti dengan 'null' atau ID statis.
        $kelasId = DB::table('kelas')->inRandomOrder()->value('id');

        // Gunakan Faker untuk menghasilkan data
        $jenisKelamin = $this->faker->randomElement(['L', 'P']);

        return [
            // Generate UID unik (misalnya, kombinasi tahun dan 5 angka acak)
            'uid' => 'S' . $this->faker->unique()->randomNumber(5, true) . date('Y'),
            
            // Generate NISN (10 angka unik)
            'nisn' => $this->faker->unique()->numerify('##########'),
            
            // Nama lengkap
            'nama_lengkap' => $this->faker->name($jenisKelamin == 'L' ? 'male' : 'female'),
            
            // Alamat
            'alamat' => $this->faker->address,
            
            // Tempat dan Tanggal Lahir
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2005-01-01'),
            
            // ID Kelas (gunakan ID kelas acak yang sudah ada)
            'kelas_id' => $kelasId ?? null, 
            
            // Jenis Kelamin
            'jenis_kelamin' => $jenisKelamin,
            
            // Nomor WA
            'no_wa' => $this->faker->numerify('08##########'),
            
            // Foto
            'foto' => 'default.png',
        ];
    }
}