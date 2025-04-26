@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2>Daftar Fasilitas</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('admin.fasilitas.create') }}" class="btn-add">+ Tambah Fasilitas</a>

        <table class="table-fasilitas">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fasilitas as $fas)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $fas->nama }}</td>
                        <td>{{ $fas->deskripsi }}</td>
                        <td>
                            @if ($fas->gambar)
                                <img src="{{ asset('storage/' . $fas->gambar) }}" width="100">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.fasilitas.edit', $fas->id) }}" class="btn-action">Edit</a>
                            <form action="{{ route('admin.fasilitas.destroy', $fas->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn-action btn-delete" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada fasilitas ditambahkan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
