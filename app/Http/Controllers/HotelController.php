<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        return view('welcome'); // Pastikan view ini juga tersedia
    }
}
