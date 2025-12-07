<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        // Faker otomatis menggunakan id_ID jika sudah diatur di config/app.php
        $jenisKelamin = $this->faker->randomElement(['L', 'P']);

        // Memberikan hint gender ke faker agar nama sesuai (Laki-laki/Perempuan)
        $genderHint = ($jenisKelamin == 'L') ? 'male' : 'female';

        return [
            'uid' => 'S' . $this->faker->unique()->randomNumber(5, true) . date('Y'),
            'nisn' => $this->faker->unique()->numerify('##########'),

            // Nama khas Indonesia sesuai gender
            'nama_lengkap' => $this->faker->name($genderHint),

            // Alamat khas Indonesia (Jl. XXX No. XX)
            'alamat' => $this->faker->address,

            // Kota-kota di Indonesia (Jakarta, Bandung, Surabaya, dll)
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2005-01-01'),

            'kelas_id' => Kelas::inRandomOrder()->first()->id ?? Kelas::factory(),
            'jenis_kelamin' => $jenisKelamin,

            // Nomor HP format Indonesia
            'no_wa' => $this->faker->phoneNumber,

            'foto' => 'default.png',
        ];
    }
}
