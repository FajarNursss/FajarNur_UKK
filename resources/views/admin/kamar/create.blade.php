{{-- resources/views/admin/kamar/create.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="form-container">
    <h2>Tambah Kamar</h2>

    @if ($errors->any())
        <div class="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kamar.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="tipe" class="form-label">Tipe</label>
        <input type="text" name="tipe" value="{{ old('tipe') }}" required>

        <label for="harga" class="form-label">Harga per malam</label>
        <input type="text" name="harga" value="{{ old('harga') }}" required>

        <label for="fasilitas" class="form-label">Fasilitas</label>
        <textarea name="fasilitas" rows="4" required>{{ old('fasilitas') }}</textarea>

        <label for="gambar" class="form-label">Gambar</label>
        <input type="file" name="gambar">

        <button type="submit" class="simpan_edit_fasilitas">Simpan</button>
        <a href="{{ route('admin.kamar.index') }}" class="btn_kembali">Kembali</a>
    </form>
</div>
@endsection
