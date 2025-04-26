<?php

// app/Http/Controllers/ResepsionisController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Enums\StatusPemesanan;
use Carbon\Carbon;
// use Barryvdh\DomPDF\Facade\Pdf as PDF;
    
class ResepsionisController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::with('user', 'kamar')->get();
        return view('resepsionis.dashboard', compact('pemesanan'));
    }

    // Pastikan fungsi-fungsi lainnya ada
    public function pemesanan(Request $request)
    {
        $query = Pemesanan::with(['user', 'kamar']);

        // Filter berdasarkan status (optional)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan nama tamu
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan tanggal check-in
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('checkin', [$request->from_date, $request->to_date]);
        }

        $pemesanan = $query->latest()->get();

        return view('resepsionis.pemesanan', compact('pemesanan'));
    }


    public function konfirmasi($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Update status menggunakan nilai enum yang valid
        $pemesanan->update(['status' => \App\Enums\StatusPemesanan::CONFIRMED]);

        return redirect()->route('resepsionis.pemesanan')->with('status', 'Pemesanan telah dikonfirmasi!');
    }


    public function fasilitas()
    {
        // Logika fasilitas
    }

    public function history()
    {
        $pemesanan = Pemesanan::with('user', 'kamar')->where('status', '!=', 'menunggu')->get();
        return view('resepsionis.history', compact('pemesanan'));
    }

    public function checkin($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Mengubah status menjadi 'checked_in'
        $pemesanan->update(['status' => StatusPemesanan::CHECKED_IN]);

        return redirect()->route('resepsionis.pemesanan')->with('status', 'Pemesanan berhasil di-check-in!');
    }

    public function checkout($id)
    {
        $pemesanan = \App\Models\Pemesanan::findOrFail($id);

        // Update status menjadi CHECKED_OUT
        $pemesanan->update([
            'status' => \App\Enums\StatusPemesanan::CHECKED_OUT,
        ]);

        return redirect()->route('resepsionis.pemesanan')->with('status', 'Tamu berhasil check-out!');
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::find($id);

        // Hitung sisa waktu pemesanan (dalam menit) dari waktu pemesanan dibuat
        $createdAt = Carbon::parse($pemesanan->created_at);
        $now = Carbon::now();
        $timeRemaining = $createdAt->addMinutes(3)->diffInMinutes($now, false);  // Waktu sisa pemesanan dalam menit

        // Jika waktu pemesanan sudah lewat 3 menit, kita bisa menandai statusnya
        if ($timeRemaining <= 0) {
            $pemesanan->status = 'expired';  // Misalnya, ubah status jadi expired
            $pemesanan->save();
        }

        return view('resepsionis.detail', compact('pemesanan', 'timeRemaining'));
    }

    public function dashboard(Request $request)
    {
        $query = Pemesanan::with('user', 'kamar');

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $pemesanan = $query->latest()->get();

        return view('resepsionis.dashboard', compact('pemesanan'));
    }

    public function kwitansi($id)
    {
        $pemesanan = Pemesanan::with(['user', 'kamar'])->findOrFail($id);
        if ($pemesanan->status !== StatusPemesanan::CHECKED_OUT) {
            abort(403, 'Kwitansi hanya tersedia setelah check-out.');
        }

        return view('resepsionis.kwitansi', compact('pemesanan'));
    }

    // public function cetakKwitansi($id)
    // {
    //     $pemesanan = Pemesanan::with('user', 'kamar')->findOrFail($id);

    //     $pdf = PDF::loadView('resepsionis.kwitansi', compact('pemesanan'));
    //     return $pdf->download('kwitansi_pemesanan_' . $pemesanan->id . '.pdf');
    // }
}
