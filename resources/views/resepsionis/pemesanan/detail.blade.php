@extends('layouts.resepsionis')

@section('content')
    <div class="container">
        <h2>Detail Pemesanan</h2>
        <p>Berikut adalah detail pemesanan:</p>

        <table class="table detail-table">
            <tr>
                <th>ID Pemesanan</th>
                <td>{{ $pemesanan->id }}</td>
            </tr>
            <tr>
                <th>Waktu Pemesanan</th>
                <td>{{ $pemesanan->created_at->translatedFormat('d F Y, H:i') }}</td>
            </tr>
            <tr>
                <th>Nama Tamu</th>
                <td>{{ $pemesanan->user->name }}</td>
            </tr>
            <tr>
                <th>Kamar</th>
                <td>{{ $pemesanan->kamar->tipe }}</td>
            </tr>
            <tr>
                <th>Check In</th>
                <td>{{ \Carbon\Carbon::parse($pemesanan->checkin)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>Check Out</th>
                <td>{{ \Carbon\Carbon::parse($pemesanan->checkout)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>Total Hari</th>
                <td>
                    @php
                        $checkin = \Carbon\Carbon::parse($pemesanan->checkin);
                        $checkout = \Carbon\Carbon::parse($pemesanan->checkout);
                        $totalHari = $checkin->diffInDays($checkout);
                    @endphp
                    {{ $totalHari }} hari
                </td>
            </tr>

            <tr>
                <th>Total Harga</th>
                <td>
                    @php
                        $checkin = \Carbon\Carbon::parse($pemesanan->checkin);
                        $checkout = \Carbon\Carbon::parse($pemesanan->checkout);
                        $totalHari = $checkin->diffInDays($checkout);
                        $totalHarga = $totalHari * $pemesanan->kamar->harga;
                    @endphp
                    Rp {{ number_format($totalHarga, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="status-badge status-{{ strtolower($pemesanan->status->value) }}">
                        {{ $pemesanan->status->toIndonesian() }}
                    </span>
                </td>
            </tr>
            <tr>
                <th>Waktu Sisa Pembayaran</th>
                <td>
                    @php
                        $now = \Carbon\Carbon::now();
                        $timeRemaining = $pemesanan->created_at->addMinutes(3);
                        $remainingTime = $timeRemaining->diffForHumans($now, ['parts' => 3]);
                    @endphp
                    @if ($pemesanan->status == \App\Enums\StatusPemesanan::PENDING)
                        <span class="badge badge-warning">{{ $remainingTime }}</span>
                    @else
                        <span class="badge badge-success">Selesai</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Bukti Transfer</th>
                <td>
                    @if ($pemesanan->bukti_transfer)
                        <img src="{{ asset('storage/' . $pemesanan->bukti_transfer) }}" alt="Bukti Transfer"
                            style="max-width: 300px; border-radius: 8px;">
                    @else
                        <em>Belum ada bukti transfer</em>
                    @endif
                </td>
            </tr>
        </table>

        <!-- Form untuk Update Status -->
        <form action="{{ route('resepsionis.updateStatus', $pemesanan->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Tambahkan ini agar route PUT bisa dipakai --}}

            <label for="status">Ubah Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $pemesanan->status->value === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $pemesanan->status->value === 'confirmed' ? 'selected' : '' }}>Confirmed
                </option>
                <option value="checked_in" {{ $pemesanan->status->value === 'checked_in' ? 'selected' : '' }}>Checked In
                </option>
                <option value="checked_out" {{ $pemesanan->status->value === 'checked_out' ? 'selected' : '' }}>Checked Out
                </option>
                <option value="cancelled" {{ $pemesanan->status->value === 'cancelled' ? 'selected' : '' }}>Cancelled
                </option>
                <option value="paid" {{ $pemesanan->status->value === 'paid' ? 'selected' : '' }}>Paid</option>
            </select>

            <button type="submit" class="btn btn-primary mt-2">Update Status</button>
        </form>


        <!-- Tombol Aksi -->
        <div class="actions mt-3">
            @if ($pemesanan->status == \App\Enums\StatusPemesanan::CONFIRMED)
                <form method="POST" action="{{ route('resepsionis.checkin', $pemesanan->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Check-In</button>
                </form>
            @elseif($pemesanan->status == \App\Enums\StatusPemesanan::CHECKED_IN)
                <form method="POST" action="{{ route('resepsionis.checkout', $pemesanan->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning">Check-Out</button>
                </form>
            @endif

            <a href="{{ url()->previous() }}" class="btn btn-primary back-button mt-2">Kembali</a>
        </div>
    </div>
@endsection
