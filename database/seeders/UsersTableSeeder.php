<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Media',
            'username' => 'admin_media',
            'password' => Hash::make('smkhebat'), // ubah di env
            'role' => 'admin',
        ]);
    }
}
