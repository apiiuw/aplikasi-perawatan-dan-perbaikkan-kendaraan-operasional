<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'email' => 'rafirizqallahandilla@gmail.com',
            'password' => Hash::make('rafi100704'),
            'nama_instansi' => 'Universitas Pembangunan Nasional Veteran Jakarta',
            'nama_pengabiministrasi' => 'Rafi Rizqallah Andila',
            'nrp' => '2210501029',
            'jabatan' => 'Intern',
            'nama_atasan' => 'Anifa Maharani',
            'nrp_atasan' => '820520160',
            'jabatan_atasan' => 'Kasubag HC dan Umum',
            'kabupaten_kota' => 'DKI Jakarta',
        ]);
    }
}
