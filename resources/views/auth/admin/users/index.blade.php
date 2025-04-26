{{-- @extends('layouts.admin') {{-- Pastikan layout admin sudah ada --}}

@section('content')
    <div class="container">
        <h1>Kelola User</h1>
        <a href="{{ route('admin.users.create') }}" class="btn-tambah">+ Tambah User</a>

        <table class="table-user">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Diupdate</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->updated_at)->translatedFormat('d F Y H:i') }}</td>

                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus user ini?')"
                                    class="btn-hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection --}}
