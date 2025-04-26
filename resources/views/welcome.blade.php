<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Hotel Online</title>
    <link rel="stylesheet" href="{{ asset('css/landingPage.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="hero">
        <div class="overlay"></div>
        <div class="content">
            <h1>Selamat Datang di Hotel Hebat</h1>
            <p>Pesan kamar hotel terbaik dengan mudah dan cepat.</p>
            <div class="buttons">
                <a href="{{ route('login') }}" class="btn">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline">Daftar</a>
            </div>
        </div>
    </header>

    <section class="features">
        <h2 class="section-title">Kenapa Memilih Kami?</h2>
        <div class="feature-list">
            <div class="feature-card">
                <img src="{{ asset('images/fast-delivery.png') }}" alt="Mudah">
                <h3>Mudah & Cepat</h3>
                <p>Proses pemesanan hanya dalam hitungan menit.</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/Ikon Transaksi.png') }}" alt="Aman">
                <h3>Transaksi Aman</h3>
                <p>Pembayaran terjamin aman dan transparan.</p>
            </div>
            <div class="feature-card">
                <img src="{{ asset('images/24-hours-support.png') }}" alt="Support">
                <h3>Customer Service</h3>
                <p>Siap membantu 24/7 kapanpun Anda butuh bantuan.</p>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Hotel Hebat. Semua hak dilindungi undang-undang.</p>
    </footer>
</body>
</html>
