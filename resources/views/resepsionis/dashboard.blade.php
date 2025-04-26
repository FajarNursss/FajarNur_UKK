@extends('layouts.resepsionis')

@section('content')
    <div class="container">
        <h1>Selamat datang, {{ Auth::user()->name }}!</h1>
        <p>Berikut adalah daftar pemesanan yang perlu ditindaklanjuti:</p>

        <form method="GET" action="{{ route('resepsionis.dashboard') }}" class="filter-form">
            <input type="text" name="search" placeholder="Cari nama tamu" value="{{ request('search') }}">

            <label>Dari Tanggal:
                <input type="date" name="start_date" value="{{ request('start_date') }}">
            </label>

            <label>Sampai Tanggal:
                <input type="date" name="end_date" value="{{ request('end_date') }}">
            </label>

            <label>Status:
                <select name="status">
                    <option value="">Semua</option>
                    @foreach (\App\Enums\StatusPemesanan::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->toIndonesian() }}
                        </option>
                    @endforeach
                </select>
            </label>

            <button type="submit">Filter</button>
        </form>


        <table class="pemesanan-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tamu</th>
                    <th>Kamar</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesanan as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->kamar->tipe }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->checkin)->translatedFormat('d F Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->checkout)->translatedFormat('d F Y') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($p->status->value) }}"
                                style="font-size: 12px; padding: 4px 8px;">
                                {{ $p->status->toIndonesian() }}
                            </span>
                        </td>
                        <td>
                            @if ($p->status === \App\Enums\StatusPemesanan::PENDING)
                                <form action="{{ route('resepsionis.konfirmasi', $p->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn-konfirmasi">Konfirmasi</button>
                                </form>
                            @elseif ($p->status === \App\Enums\StatusPemesanan::CONFIRMED)
                                <form action="{{ route('resepsionis.checkin', $p->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn-checkin">Check-In</button>
                                </form>
                            @elseif ($p->status === \App\Enums\StatusPemesanan::CHECKED_IN)
                                <form action="{{ route('resepsionis.checkout', $p->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn-checkout">Check-Out</button>
                                </form>
                            @elseif ($p->status === \App\Enums\StatusPemesanan::CHECKED_OUT)
                                <a href="{{ route('resepsionis.kwitansi', $p->id) }}" class="btn-kwitansi">Kwitansi</a>
                            @endif

                            <a href="{{ route('resepsionis.pemesanan.detail', $p->id) }}" class="btn-detail">Detail</a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada pemesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
