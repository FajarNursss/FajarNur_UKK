@extends('layouts.resepsionis')

@section('content')
    <h2>Fasilitas Hotel</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Fasilitas</th>
                <th>Gambar</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fasilitas as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" width="100">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
