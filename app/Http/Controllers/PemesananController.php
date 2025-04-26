<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;
use App\Models\User;
use App\Enums\StatusPemesanan;
use App\Notifications\PemesananStatusChanged;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class PemesananController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input filter
        $status = $request->query('status');
        $sort = $request->query('sort', 'desc'); // default: terbaru

        // Query awal berdasarkan role
        if (auth()->user()->role == 'admin') {
            $query = Pemesanan::with('kamar');
        } else {
            $query = Pemesanan::with('kamar')->where('user_id', auth()->id());
        }

        // Filter berdasarkan status jika ada
        if ($status) {
            $query->where('status', $status);
        }

        // Urutkan berdasarkan waktu dibuat
        $query->orderBy('created_at', $sort);

        // Ambil hasil
        $pemesanans = $query->get();

        return view('user.pemesanan.index', compact('pemesanans'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'checkin' => 'required|date|after:today',
            'checkout' => 'required|date|after:checkin',
            'jumlah' => 'required|integer|min:1',
            'kamar_id' => 'required|exists:kamars,id',
        ]);

        Pemesanan::create([
            'user_id' => auth()->id(),
            'kamar_id' => $request->kamar_id,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'jumlah_kamar' => $request->jumlah,
            'status' => StatusPemesanan::PENDING, // Status awal pemesanan
        ]);

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dilakukan!');
    }

    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled,paid,expired',
        ]);

        $status = StatusPemesanan::from($request->status);

        $pemesanan->status = $status;

        $pemesanan->save();

        $pemesanan->user->notify(new PemesananStatusChanged($pemesanan));

        return back()->with('success', 'Status berhasil diperbarui');
    }


    public function detail($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Mendapatkan status dalam Bahasa Indonesia
        $statusIndo = $pemesanan->status->toIndonesian();

        return view('resepsionis.pemesanan.detail', compact('pemesanan', 'statusIndo'));
    }

    public function confirmPayment($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $now = Carbon::now();
        $paymentDeadline = $pemesanan->created_at->addMinutes(3);

        if ($now->lt($paymentDeadline) && $pemesanan->status == StatusPemesanan::PENDING) {
            $pemesanan->status = StatusPemesanan::PAID;
            $message = 'Pembayaran berhasil dikonfirmasi';
        } elseif ($now->gt($paymentDeadline) && $pemesanan->status == StatusPemesanan::PENDING) {
            $pemesanan->status = StatusPemesanan::EXPIRED;
            $message = 'Waktu pembayaran telah lewat, pemesanan telah kedaluwarsa';
        } else {
            $message = 'Status pemesanan sudah terkonfirmasi atau dibayar sebelumnya';
        }

        $pemesanan->save();

        return redirect()->route('pemesanan.bayar', $id)->with('status', $message);
    }

    public function showPemesanan($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        $statusIndonesia = $pemesanan->status->toIndonesian();

        return view('pemesanan.show', compact('pemesanan', 'statusIndonesia'));
    }


    public function showPembayaran($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        // Menghasilkan QR Code untuk pembayaran
        $qrCode = QrCode::size(200)->generate(route('pembayaran.confirm', $pemesanan->id));

        return view('user.pemesanan.bayar', compact('pemesanan', 'qrCode'));
    }

    public function cancelPemesanan($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status = StatusPemesanan::CANCELLED;
        $pemesanan->save();

        return redirect()->route('pemesanan.index')->with('status', 'Pemesanan berhasil dibatalkan.');
    }

    public function uploadBuktiPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        // Menyimpan gambar ke storage
        $buktiPath = $request->file('bukti_pembayaran')->store('public/bukti_pembayaran');

        // Menyimpan informasi bukti pembayaran ke database
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->bukti_pembayaran = $buktiPath;
        $pemesanan->status = StatusPemesanan::MENUNGGU_KONFIRMASI;
        $pemesanan->save();

        return redirect()->route('pemesanan.index')->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    
}
