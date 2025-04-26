@extends('layouts.user')

@section('content')
<section class="hero-fasilitas">
    <div class="container">
        <h1 class="title">Fasilitas Kami</h1>
        <div class="fasilitas-wrapper">
            @foreach($fasilitas as $item)
            <div class="fasilitas-item">
                <td>
                    @if ($item->gambar)
                        <img src="{{ asset('storage/' . $item->gambar) }}" width="100">
                    @else
                        -
                    @endif
                </td>
                <h3>{{ $item->nama }}</h3>
                <p>{{ $item->deskripsi }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
