{{-- resources/views/admin/kamar/edit.blade.php
@extends('layouts.admin')

@section('content')
<div class="form-container">
    <h2>Edit Kamar</h2>

    @if ($errors->any())
        <div class="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kamar.update', $kamar->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="tipe" class="form-label">Tipe</label>
        <input type="text" name="tipe" value="{{ old('tipe', $kamar->tipe) }}" required>

        <label for="fasilitas" class="form-label">Fasilitas</label>
        <textarea name="fasilitas" rows="4" required>{{ old('fasilitas', $kamar->fasilitas) }}</textarea>

        <label for="gambar" class="form-label">Gambar</label>
        <input type="file" name="gambar">
        @if($kamar->gambar)
            <img src="{{ asset('storage/kamar/' . $kamar->gambar) }}" width="150" class="mt-2">
        @endif

        <button type="submit">Update</button>
        <a href="{{ route('admin.kamar.index') }}" class="btn">Kembali</a>
    </form>
</div>
@endsection --}}
