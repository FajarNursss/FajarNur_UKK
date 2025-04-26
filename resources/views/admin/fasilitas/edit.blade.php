@extends('layouts.admin')

@section('content')
<div class="form-container">

    <h2>Edit Fasilitas</h2>

    <form action="{{ route('admin.fasilitas.update', $fasilita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <label class="form-label">Nama:</label><br>
        <input type="text" name="nama" value="{{ $fasilita->nama }}"><br><br>

        <label class="form-label">Deskripsi:</label><br>
        <textarea name="deskripsi">{{ $fasilita->deskripsi }}</textarea><br><br>

        <label class="form-label">Gambar Lama:</label><br>
        @if ($fasilita->gambar)
            <img src="{{ asset('storage/' . $fasilita->gambar) }}" width="100"><br>
        @endif

        <label>Ganti Gambar:</label><br>
        <input type="file" name="gambar"><br><br>

        <button type="submit" class="simpan_edit_fasilitas">Perbarui</button>
        <a href="{{ route('admin.fasilitas.index') }}" class="btn_kembali">Kembali</a>
    </form>
</div>
@endsection
