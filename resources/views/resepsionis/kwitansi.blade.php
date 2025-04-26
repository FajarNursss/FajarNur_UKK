@extends('layouts.resepsionis')

@section('content')
<div class="container mt-4" id="kwitansi-area">
    <div style="border: 1px solid #ccc; padding: 20px; border-radius: 10px; background: #fff;">
        <h2 style="text-align: center;">Kwitansi Pemesanan</h2>
        <hr>

        <p><strong>Nama Tamu:</strong> {{ $pemesanan->user->name }}</p>
        <p><strong>Tipe Kamar:</strong> {{ $pemesanan->kamar->tipe }}</p>
        <p><strong>Check-In:</strong> {{ \Carbon\Carbon::parse($pemesanan->checkin)->translatedFormat('d F Y') }}</p>
        <p><strong>Check-Out:</strong> {{ \Carbon\Carbon::parse($pemesanan->checkout)->translatedFormat('d F Y') }}</p>

        @php
            $checkin = \Carbon\Carbon::parse($pemesanan->checkin);
            $checkout = \Carbon\Carbon::parse($pemesanan->checkout);
            $totalHari = $checkin->diffInDays($checkout);
            $totalHarga = $totalHari * $pemesanan->kamar->harga;
        @endphp

        <p><strong>Total Hari:</strong> {{ $totalHari }} malam</p>
        <p><strong>Harga per Malam:</strong> Rp {{ number_format($pemesanan->kamar->harga, 0, ',', '.') }}</p>
        <h4><strong>Total Bayar:</strong> Rp {{ number_format($totalHarga, 0, ',', '.') }}</h4>

        <p class="mt-4" style="font-size: 12px;">Tanggal Cetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>

        <div style="margin-top: 40px;">
            <p style="text-align: right;">Hormat Kami,</p>
            <br><br>
            <p style="text-align: right;">(Petugas Resepsionis)</p>
        </div>
    </div>

    <div class="mt-4 text-center">
        <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak Kwitansi</button>
    </div>
</div>
@endsection
