@extends('layouts.user')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/dashboardUser.css') }}">
@endsection

@section('content')
    <section class="hero-slider">
        <div class="slider">
            <div class="hero-slider">
                <div class="fade-slider">
                  <img src="{{ asset('images/pexels-boonkong-boonpeng-442952-1134176.jpg') }}" class="fade-slide active">
                  <img src="{{ asset('images/pexels-erik-karits-2093459-27594951.jpg') }}" class="fade-slide">
                  <img src="{{ asset('images/pexels-pixabay-258154.jpg') }}" class="fade-slide">
                </div>
              </div>
              
        </div>
    </section>

    <section class="reservation-button">
        <div class="form-box">
            <h2>Pesan Kamar Anda Sekarang</h2>
            <a href="{{ route('user.kamar') }}">
                <button>Pesan Sekarang</button>
            </a>
        </div>
    </section>

    <section class="about">
        <h2>Tentang Kami</h2>
        <p>
            Lepaskan diri Anda ke Hotel Hebat, dikelilingi oleh keindahan pegunungan yang indah, danau, dan sawah menghijau.
            Nikmati sore yang hangat dengan berenang di kolam renang dengan pemandangan matahari terbenam yang memukau.
            Kids Club yang luas - menawarkan beragam fasilitas dan kegiatan anak-anak yang akan melengkapi kenyamanan keluarga.
            Convention Center kami mampu menampung hingga 3.000 delegasi dengan layanan lengkap dan modern.
            Manfaatkan ruang M.I.C.E ataupun ciptakan acara pernikahan adat yang mewah bersama kami.
        </p>
    </section>
@endsection
