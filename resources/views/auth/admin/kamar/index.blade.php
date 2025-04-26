{{-- resources/views/admin/kamar/index.blade.php
@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Kamar</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.kamar.create') }}" class="btn-add">Tambah Kamar</a>

    <table class="table-crud">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Tipe</th>
                <th>Fasilitas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kamars as $kamar)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($kamar->gambar)
                        <img src="{{ asset('storage/kamar/' . $kamar->gambar) }}" width="100">
                    @else
                        -
                    @endif
                </td>
                <td>{{ $kamar->tipe }}</td>
                <td>{{ $kamar->fasilitas }}</td>
                <td>
                    <a href="{{ route('admin.kamar.edit', $kamar->id) }}" class="action-btn">Edit</a>
                    <form action="{{ route('admin.kamar.destroy', $kamar->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection --}}
