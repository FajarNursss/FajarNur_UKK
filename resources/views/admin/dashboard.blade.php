@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow rounded-4 p-4">
        <h2 class="text-center mb-4">Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p class="text-center">Anda login sebagai <strong>Admin</strong></p>

        <div class="row text-center mt-4">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white rounded-4 shadow">
                    <div class="card-body">
                        <h4 class="card-title">Total User</h4>
                        <p class="card-text fs-3">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white rounded-4 shadow">
                    <div class="card-body">
                        <h4 class="card-title">Total Kamar</h4>
                        <p class="card-text fs-3">{{ \App\Models\Kamar::count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-warning text-dark rounded-4 shadow">
                    <div class="card-body">
                        <h4 class="card-title">Total Fasilitas</h4>
                        <p class="card-text fs-3">{{ \App\Models\Fasilitas::count() }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
