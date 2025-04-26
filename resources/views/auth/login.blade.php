@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h4>Silahkan Masuk</h4>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">Email</label>
            <input type="email" name="email" required autofocus>

            <label for="password">Kata Sandi</label>
            <input type="password" name="password" required>

            <button type="submit">Masuk</button>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}">Belum punya akun?</a>
            </div>
        </form>
    </div>
</div>
@endsection

