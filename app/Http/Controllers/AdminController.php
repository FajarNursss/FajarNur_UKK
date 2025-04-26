<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pemesanan;
use App\Models\Kamar;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalPemesanan = Pemesanan::count();
        $kamarTersedia = Kamar::where('status', 'tersedia')->count();

        return view('admin.dashboard', compact('totalUsers', 'totalPemesanan', 'kamarTersedia'));
    }

    public function index()
    {
        return redirect()->route('admin.dashboard');
    }
}
