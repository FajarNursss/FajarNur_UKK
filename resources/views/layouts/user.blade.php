<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hotel Hebat</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <header class="navbar">
        <div class="logo">HOTEL HEBAT</div>
        <nav class="nav-links">
            <a href="{{ route('user.dashboard') }}">Beranda</a>
            <a href="{{ route('user.kamar') }}">Kamar</a>
            @auth
                @if (Auth::user()->role == 'user')
                    <a href="{{ route('user.fasilitas') }}">Fasilitas</a>
                @endif
            @endauth

            <a href="{{ route('pemesanan.index') }}">Pemesanan Saya</a>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">Keluar</button>
            </form>
        </nav>
    </header>

    <!-- Loader -->
    <div id="loader-wrapper"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(255,255,255,0.8); z-index:9999; align-items:center; justify-content:center;">
        <div class="loader"></div>
    </div>

    <main>
        @yield('content')
    </main>

    @yield('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll('a[href^="#"]');
            for (let link of links) {
                link.addEventListener("click", function(e) {
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

    <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.fade-slide');

        function showNextSlide() {
            slides[currentSlide].classList.remove('active');
            currentSlide = (currentSlide + 1) % slides.length;
            slides[currentSlide].classList.add('active');
        }

        setInterval(showNextSlide, 4000);
    </script>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Handle Pesan Kamar -->
    <script>
        async function handlePesanKamar(event, kamarId) {
            event.preventDefault();

            const form = event.target;
            const loader = document.getElementById("loader-wrapper");
            loader.style.display = "flex";
            loader.style.opacity = "1";

            const formData = new FormData(form);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await fetch("{{ route('pesan.kamar') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message || 'Pemesanan berhasil dilakukan!',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        window.location.href = "{{ route('pemesanan.index') }}";
                    });
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan saat memesan kamar');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.message || 'Terjadi kesalahan tidak dikenal.',
                });
            } finally {
                loader.style.display = "none";
            }
        }
    </script>

    <style>
        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</body>

</html>
