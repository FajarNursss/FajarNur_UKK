@extends('layouts.user')

@section('content')
    <div class="container">
        <h2>Proses Pembayaran</h2>
        <p>Silakan lakukan pembayaran dengan memindai QR Code di bawah ini:</p>

        <!-- QR Code Section -->
        <div class="qr-code">
            {!! $qrCode !!} <!-- Menampilkan QR Code -->
        </div>

        <!-- Waktu Sisa Pembayaran Section -->
        @php
            $now = \Carbon\Carbon::now();
            $timeRemaining = $pemesanan->created_at->addMinutes(3); // Waktu batas pembayaran 3 menit
            $remainingTime = $now->lessThan($timeRemaining)
                ? $timeRemaining->diffForHumans($now, ['parts' => 3])
                : 'Waktu telah habis';
        @endphp

        <div class="payment-time-remaining">
            @if ($pemesanan->status == \App\Enums\StatusPemesanan::PENDING)
                <p>Waktu sisa pembayaran: <span class="badge badge-warning">{{ $remainingTime }}</span></p>
            @elseif ($pemesanan->status == \App\Enums\StatusPemesanan::EXPIRED)
                <p><span class="badge badge-danger">Waktu pembayaran telah habis</span></p>
            @elseif ($pemesanan->status == \App\Enums\StatusPemesanan::PAID)
                <p><span class="badge badge-success">Pembayaran telah selesai</span></p>
            @endif
        </div>
    </div>

    <!-- Form Upload Bukti Pembayaran -->
    <div class="container mt-4">
        <h3>Unggah Bukti Pembayaran</h3>
        <form action="{{ route('pemesanan.uploadBuktiPembayaran', $pemesanan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="bukti_pembayaran">Pilih Gambar Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" class="form-control" required>
                @if ($errors->has('bukti_pembayaran'))
                    <span class="text-danger">{{ $errors->first('bukti_pembayaran') }}</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Kirim Bukti Pembayaran</button>
        </form>
    </div>

    <!-- Konfirmasi Pembayaran Button Section -->
    @if ($pemesanan->bukti_pembayaran) <!-- Jika bukti pembayaran sudah ada -->
        <div class="container mt-4">
            <form action="{{ route('pembayaran.confirm', $pemesanan->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
            </form>
        </div>
    @else
        <div class="container mt-4">
            <p><span class="badge badge-warning">Unggah bukti pembayaran untuk melanjutkan konfirmasi.</span></p>
        </div>
    @endif

    <!-- Status Pemesanan Section -->
    <div class="container mt-4">
        <h4>Status Pemesanan: {{ $pemesanan->status }}</h4>
    </div>
@endsection
