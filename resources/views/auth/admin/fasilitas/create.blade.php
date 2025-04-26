{{-- @extends('layouts.admin')

@section('content')
    <div class="form-container">
        <h2>Tambah Fasilitas</h2>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Nama:</label>
            <input type="text" name="nama" required>

            <label>Deskripsi:</label>
            <textarea name="deskripsi" required></textarea>

            <label>Gambar:</label>
            <input type="file" name="gambar">

            <button type="submit">Simpan</button>
        </form>
    </div>
@endsection --}}
