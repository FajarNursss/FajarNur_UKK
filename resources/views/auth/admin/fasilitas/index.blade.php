{{-- @extends('layouts.admin')

@section('content')
    <div class="fasilitas-page">
        <h2>Daftar Fasilitas</h2>
        <a href="{{ route('admin.fasilitas.create') }}" class="btn-add">+ Tambah Fasilitas</a>

        <table class="table-fasilitas">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fasilitas as $fas)
                    <tr>
                        <td>{{ $fas->id }}</td>
                        <td>{{ $fas->nama }}</td>
                        <td>{{ $fas->deskripsi }}</td>
                        <td>
                            @if($fas->gambar)
                        <img src="{{ asset('storage/kamar/' . $fas->gambar) }}" width="100">
                    @else
                    @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.fasilitas.edit', $fas->id) }}" class="btn-action">Edit</a>
                            <form action="{{ route('admin.fasilitas.destroy', $fas->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn-delete" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection --}}
