@extends('layouts.app_dashboard')

@section('content')
<div class="container">
    <h2>Keranjang</h2>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    @if(empty($keranjang))
        <p>Keranjang kosong.</p>
    @else
        <form action="{{ route('keranjang.checkout') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($keranjang as $item)
                        @php $subtotal = $item['harga'] * $item['qty']; $total += $subtotal; @endphp
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>Rp{{ number_format($item['harga']) }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>Rp{{ number_format($subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <label>Metode Pengiriman:</label>
                <select name="metode_pengiriman" class="form-control" required>
                    <option value="ambil_sendiri">Ambil Sendiri</option>
                    <option value="kurir">Kurir</option>
                </select>
            </div>
            <div class="mt-2">
                <strong>Total: Rp{{ number_format($total) }}</strong>
            </div>
            @if(empty($expired))
                <button type="submit" class="btn btn-success mt-2">Checkout</button>
            @endif
        </form>
        @if(!empty($expired))
            <div class="mt-3">
                <div id="countdown"></div>
                <form action="{{ route('keranjang.bayar') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Bayar</button>
                </form>
            </div>
            <script>
                // Countdown timer
                let expiredAt = new Date("{{ \Carbon\Carbon::parse($expired)->toIso8601String() }}").getTime();
                let x = setInterval(function() {
                    let now = new Date().getTime();
                    let distance = Math.floor((expiredAt - now) / 1000); // dalam detik
                    let seconds = distance > 0 ? distance : 0;
                    document.getElementById("countdown").innerHTML = "Sisa waktu pembayaran: " + seconds + " detik";
                    if (distance <= 0) {
                        clearInterval(x);
                        document.getElementById("countdown").innerHTML = "Waktu pembayaran habis!";
                        window.location.href = '/';
                    }
                }, 1000);
            </script>
        @endif
    @endif
</div>
@endsection 