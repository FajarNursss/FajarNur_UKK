@extends('layouts.user')

@section('content')
<div class="container text-center mt-5">
    <h2>Bayar Pemesanan Anda</h2>
    <p>Scan QR Code di bawah ini untuk melanjutkan pembayaran.</p>

    <div class="d-flex justify-content-center my-4">
        {!! $qrCode !!}
    </div>

    <p><strong>Tipe Kamar:</strong> {{ $pemesanan->kamar->tipe }}</p>
    <p><strong>Check-in:</strong> {{ $pemesanan->checkin }}</p>
    <p><strong>Check-out:</strong> {{ $pemesanan->checkout }}</p>

    <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
