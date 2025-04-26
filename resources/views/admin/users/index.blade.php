@extends('layouts.admin') {{-- Pastikan layout admin sudah ada --}}

@section('content')
    <div class="container">
        <h1>Kelola User</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Form Pencarian dan Filter -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="form-filter">
            <div class="form-filter">
                <input type="text" placeholder="Cari nama atau email">
                <select>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="resepsionis">Resepsionis</option>
                    <option value="user">User</option>
                </select>
                <button class="btn-filter">Filter</button>
            </div>


        </form>


        <a href="{{ route('admin.users.create') }}" class="btn-tambah">+ Tambah User</a>

        <table class="table-user">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Diperbarui</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
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
                @empty
                    <tr>
                        <td colspan="7">Belum ada user yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
