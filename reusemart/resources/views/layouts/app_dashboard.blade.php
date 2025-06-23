<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReuseMart</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('styles') 
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">ReuseMart</a>
            <div class="d-flex gap-2">
                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            @auth
                @if(Auth::user()->role === 'admin')
                    <div class="col-md-3 col-lg-2 bg-white border-end vh-100 py-4">
                        <h5 class="text-center mb-4">Admin Menu</h5>
                        <ul class="nav flex-column px-3">
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="{{ route('pegawai.index') }}">
                                    <i class="bi bi-people"></i> Kelola Pegawai
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="{{ route('admin.top-seller') }}">
                                    <i class="bi bi-trophy"></i> Manajemen TOP SELLER
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link" href="{{ route('admin.expired-items') }}">
                                    <i class="bi bi-clock-history"></i> Barang Lewat Batas
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif
            @endauth

            @auth
                @if(Auth::user()->role === 'owner')
                    <div class="col-md-3 col-lg-2 bg-white border-end vh-100 py-4">
                        <h5 class="text-center mb-4">Owner Menu</h5>
                            <ul class="nav flex-column px-3">
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('request-donasi.index') }}">
                                        <i class="bi bi-box-arrow-in-down-right"></i> Request Donasi
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('laporan.penjualan') }}">
                                        <i class="bi bi-graph-up-arrow"></i> Laporan Penjualan
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('laporan.komisi.index') }}">
                                        <i class="bi bi-cash-coin"></i> Laporan Komisi
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('laporan.stokgudang') }}">
                                        <i class="bi bi-archive"></i> Laporan Stok Gudang
                                    </a>
                                </li>
                            </ul>
                    </div>
                @endif
            @endauth

            <div class="@auth {{ (Auth::user()->role === 'owner' || Auth::user()->role === 'admin') ? 'col-md-9 col-lg-10' : 'col-12' }} @else col-12 @endauth py-4">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
