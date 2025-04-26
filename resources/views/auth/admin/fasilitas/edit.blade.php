{{-- @extends('layouts.admin')

@section('content')
    <h2>Edit Fasilitas</h2>

    <form action="{{ route('fasilitas.update', $fasilita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <label>Nama:</label><br>
        <input type="text" name="nama" value="{{ $fasilita->nama }}"><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi">{{ $fasilita->deskripsi }}</textarea><br><br>

        <label>Gambar Lama:</label><br>
        @if ($fasilita->gambar)
            <img src="{{ asset('storage/' . $fasilita->gambar) }}" width="100"><br>
        @endif

        <label>Ganti Gambar:</label><br>
        <input type="file" name="gambar"><br><br>

        <button type="submit">Update</button>
    </form>
@endsection --}}
