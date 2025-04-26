<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Fasilitas;

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard'); // Pastikan view ini ada
    }


    public function fasilitas()
    {
        $fasilitas = Fasilitas::all();
        return view('user.fasilitas', compact('fasilitas'));
    }

    // app/Http/Controllers/UserController.php
    public function kamar()
    {
        // Menampilkan kamar yang tersedia
        $kamars = Kamar::all();
        return view('user.kamar', compact('kamars'));
    }
}
