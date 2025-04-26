@extends('layouts.user')

@section('content')
    <section class="kamar-section py-5">
        <div class="container">
            <h2 class="section-title">Pilih Kamar</h2>
            <div class="room-grid">
                @foreach ($kamars as $kamar)
                    <div class="room-card">
                        <img src="{{ asset('storage/kamar/' . $kamar->gambar) }}" alt="Kamar {{ $kamar->tipe }}"
                            class="room-img">
                        <div class="room-body">
                            <h5 class="room-title">Tipe: {{ $kamar->tipe }}</h5>
                            <p class="room-facility">Harga per malam: Rp.{{ number_format($kamar->harga, 0, ',', '.') }}</p>
                            <p class="room-facility">Fasilitas: {{ $kamar->fasilitas }}</p>
                            <form action="{{ route('pesan.kamar') }}" method="POST" class="room-form"
                                onsubmit="return validateTanggal(this)">
                                @csrf
                                <input type="hidden" name="kamar_id" value="{{ $kamar->id }}">

                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="checkin_{{ $kamar->id }}">Check-in</label>
                                        <input type="date" id="checkin" name="checkin"
                                            min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" class="form-control"
                                            required>
                                        {{-- minimal pesan di hari besok --}}
                                    </div>
                                    <div class="form-group">
                                        <label for="checkout_{{ $kamar->id }}">Check-out</label>
                                        <input type="date" name="checkout" id="checkout_{{ $kamar->id }}"
                                            min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah_{{ $kamar->id }}">Jumlah</label>
                                        <input type="number" name="jumlah" id="jumlah_{{ $kamar->id }}"
                                            class="form-control" min="1" value="1" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn-pesan">Pesan Kamar</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection


@section('script')
    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('form.room-form').forEach(function (form) {
            const checkinInput = form.querySelector('input[name="checkin"]');
            const checkoutInput = form.querySelector('input[name="checkout"]');

            checkinInput.addEventListener('change', function () {
                const checkinDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (checkinDate <= today) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal Tidak Valid',
                        text: 'Kamar hanya bisa dipesan mulai besok. Silakan pilih tanggal check-in minimal besok.',
                        confirmButtonColor: '#3085d6',
                    });
                    checkinInput.value = '';
                    return;
                }

                const minCheckoutDate = new Date(checkinDate);
                minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
                const formattedDate = minCheckoutDate.toISOString().split('T')[0];

                checkoutInput.min = formattedDate;
                checkoutInput.value = '';
            });

            checkoutInput.addEventListener('change', function () {
                if (!checkinInput.value) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Oops!',
                        text: 'Silakan pilih tanggal check-in terlebih dahulu.',
                        confirmButtonColor: '#3085d6',
                    });
                    checkoutInput.value = '';
                    return;
                }

                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(this.value);
                const minCheckout = new Date(checkinDate);
                minCheckout.setDate(minCheckout.getDate() + 1);

                if (checkoutDate < minCheckout) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal Check-out Tidak Valid',
                        text: 'Tanggal check-out harus minimal satu hari setelah check-in.',
                        confirmButtonColor: '#3085d6',
                    });
                    this.value = '';
                }
            });
        });
    </script>
@endsection
