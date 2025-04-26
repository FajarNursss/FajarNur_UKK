@extends('layouts.user')

@section('content')
    <div class="container">
        <h2>Daftar Pemesanan Saya</h2>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('pemesanan.index') }}" class="mb-4 d-flex align-items-center gap-2">
            <div>
                <label for="status">Filter Status:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="form-control">
                    <option value="">Semua</option>
                    @foreach (\App\Enums\StatusPemesanan::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->toIndonesian() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sort">Urutkan:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="form-control">
                    <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Terbaru</option>
                    <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
        </form>

        <!-- Tabel Pemesanan -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tipe Kamar</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemesanans as $pemesanan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pemesanan->kamar->tipe }}</td>
                        <td>{{ $pemesanan->checkin }}</td>
                        <td>{{ $pemesanan->checkout }}</td>
                        <td>{{ $pemesanan->status->toIndonesian() }}</td>
                        <td>
                            {{-- Tombol Batalkan --}}
                            @if($pemesanan->status === \App\Enums\StatusPemesanan::PENDING)
                                <form action="{{ route('pemesanan.cancel', $pemesanan->id) }}" method="POST" style="display:inline-block; margin-bottom: 5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="batalkan_pemesanan">Batalkan</button>
                                </form>
                        
                                {{-- Tombol Bayar --}}
                                <a href="{{ route('pemesanan.bayar', $pemesanan->id) }}" class="btn btn-success btn-bayar">Bayar</a>
                            @endif
                        </td>
                        
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pemesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('.btn-bayar').forEach(function(button) {
            button.addEventListener('click', function() {
                button.innerHTML = "Mengalihkan ke Pembayaran...";
                button.style.backgroundColor = "#ccc";
                button.disabled = true;
            });
        });
    </script>
@endsection


@section('scripts')
<script>
    document.querySelectorAll('.btn-bayar').forEach(function(button) {
        button.addEventListener('click', function() {
            button.innerHTML = "Mengalihkan ke Pembayaran...";
            button.style.backgroundColor = "#ccc";
            button.disabled = true;
        });
    });

    document.querySelectorAll('.batalkan_pemesanan').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if (!confirm("Apakah Anda yakin ingin membatalkan pemesanan ini?")) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
