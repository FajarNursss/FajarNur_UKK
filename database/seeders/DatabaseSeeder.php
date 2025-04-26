<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pemesanan;
use App\Models\Fasilitas;
use App\Enums\StatusPemesanan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's databas   e.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name'  => 'amoy',
            'email' => 'amoy@gmail.com',
            'password' => Hash::make('amoy'),
            'role' => 'resepsionis',
        ]);
        User::create([
            'name'  => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
        User::create([
            'name'  => 'pengguna',
            'email' => 'pengguna@gmail.com',
            'password' => Hash::make('pengguna'),
            'role' => 'user',
        ]);

        Fasilitas::create([
            'nama' => 'Kolam Renang', 
            'deskripsi' => 'Kolam renang luas dengan view pegunungan dan sunset.', 
            'gambar' => 'public/images/pexels-boonkong-boonpeng-442952-1134176.jpg', 
        ]);

        // Pemesanan::create([
        //     'status' => StatusPemesanan::CONFIRMED, // Set status ke CONFIRMED
        //     // atribut lain seperti nama, harga, dsb
        // ]);


    }

    
}
    