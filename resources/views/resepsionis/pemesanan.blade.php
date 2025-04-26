@extends('layouts.resepsionis')

@section('content')
<h2>Daftar Pemesanan</h2>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>Nama Tamu</th>
            <th>Kamar</th>
            <th>Tgl Check In</th>
            <th>Tgl Check Out</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pemesanan as $item)
        <tr>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->kamar->tipe }}</td>
            <td>{{ $item->checkin }}</td>
            <td>{{ $item->checkout }}</td>
            <td>{{ $item->status }}</td>
            <td>
                @if ($item->status == 'menunggu')
                    <form method="POST" action="{{ route('resepsionis.konfirmasi', $item->id) }}">
                        @csrf
                        <button type="submit" class="scrollable-btn">Konfirmasi</button>
                    </form>
                @else
                    Sudah dikonfirmasi
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@push('scripts')
<script>
    // Menambahkan efek scroll halus pada tombol konfirmasi
    document.querySelectorAll('.scrollable-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah tindakan default (misalnya, mengikuti link)

            // Mengambil ID target dari href
            const targetId = this.getAttribute('href')?.substring(1);  // Menghapus tanda "#" dari href
            const targetElement = document.getElementById(targetId); // Menemukan elemen berdasarkan ID

            // Jika target ditemukan, lakukan scroll ke elemen tersebut
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop, // Scroll ke posisi target
                    behavior: 'smooth' // Efek scroll halus
                });

                // Jika perlu, lakukan redirect setelah scroll selesai
                setTimeout(() => {
                    window.location.href = this.href;  // Arahkan ke href setelah scroll selesai
                }, 500); // Tunggu 0.5 detik agar scroll selesai
            }
        });
    });
</script>
@endpush
