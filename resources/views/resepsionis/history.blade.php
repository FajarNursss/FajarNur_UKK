@extends('layouts.resepsionis')

@section('content')
<h2>History Pemesanan</h2>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Tamu</th>
            <th>Kamar</th>
            <th>Tgl Pemesanan</th>
            <th>Tgl Check In</th>
            <th>Tgl Check Out</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pemesanan as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->kamar->tipe }}</td>
            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($item->checkin)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($item->checkout)->format('d M Y') }}</td>
            <td>
                <span class="status-badge status-{{ strtolower($item->status->value) }}" style="font-size: 12px; padding: 4px 8px;">
                    {{ $item->status->toIndonesian() }}
                </span>
            </td>
            <td>
                <a href="{{ route('resepsionis.pemesanan.detail', $item->id) }}" class="btn-detail">Detail</a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
