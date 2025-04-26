<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hotel Hebat Admin</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardAdmin.css') }}">
</head>

<body>
    <header class="navbar">
        <div class="logo">HOTEL HEBAT - Admin</div>
        <nav class="nav-links">
            <a href="{{ route('admin.dashboard') }}">Beranda</a>
            <a href="{{ route('admin.fasilitas.index') }}">Kelola Fasilitas</a>
            <a href="{{ route('admin.kamar.index') }}">Kelola Kamar</a>
            <a href="{{ route('admin.users.index') }}">Kelola User</a>

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
        document.addEventListener("DOMContentLoaded", function () {
            const links = document.querySelectorAll('a[href^="#"]');
            for (let link of links) {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute("href"));
                    if (target) {
                        target.scrollIntoView({
                            behavior: "smooth"
                        });
                    }
                });
            }
        });
    </script>

</body>

</html>
