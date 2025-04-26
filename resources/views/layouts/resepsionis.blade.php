<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Resepsionis | Hotel Hebat</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardResepsionis.css') }}">
</head>

<body>
    <header class="navbar">
        <div class="logo">HOTEL HEBAT</div>
        <nav class="nav-links">
            <a href="{{ route('resepsionis.dashboard') }}">Dashboard</a>
            {{-- <a href="{{ route('resepsionis.pemesanan') }}">Pemesanan</a>e --}}
            <a href="{{ route('resepsionis.fasilitas') }}">Fasilitas</a>
            <a href="{{ route('resepsionis.history') }}">History</a>
            <a href="{{ route('resepsionis.history') }}">Laporan</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">Keluar</button>
            </form>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <script>
        // Menambahkan efek scroll halus saat kembali ke atas
        document.querySelector('.back-button, btn-logout').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah aksi default
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });

            // Kemudian redirect setelah scroll selesai
            setTimeout(() => {
                window.location.href = this.href;
            }, 500); // Tunggu 0.5 detik untuk efek scroll
        });
    </script>
</body>

</html>
