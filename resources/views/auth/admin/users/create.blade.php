{{-- @extends('layouts.admin')

@section('content')
<div class="form-container">
    <h2>Tambah User</h2>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <label>Nama</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required>

        <label>Role</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="resepsionis">Resepsionis</option>
            <option value="user">User</option>
        </select>

        <button type="submit">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn">Kembali</a>
    </form>
</div>
@endsection --}}
