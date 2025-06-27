<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReuseMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar-brand span {
            color: #03AC0E;
            font-weight: bold;
            font-size: 24px;
        }
        .search-bar {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding-left: 10px;
        }
        .btn-login {
            border: 1px solid #03AC0E;
            color: #03AC0E;
            background-color: white;
        }
        .btn-daftar {
            background-color: #03AC0E;
            color: white;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}"><span>ReuseMart</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTokopedia">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTokopedia">
                <form class="d-flex w-50 me-auto" role="search" method="GET" action="{{ route('home') }}">
                    <input class="form-control me-2 search-bar" type="search" name="q" placeholder="Cari di ReuseMart"
                        value="{{ request('q') }}">
                </form>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('keranjang.lihat') }}" class="text-dark">
                        <i class="bi bi-cart3 fs-5"></i>
                    </a>

                    @if(session('pembeli'))
                        <div class="dropdown">
                            <a class="btn btn-outline-secondary dropdown-toggle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                                <li><h6 class="dropdown-header">{{ session('pembeli')->nama_pembeli }}</h6></li>
                                <li><a class="dropdown-item" href="{{ route('pembeli.profil') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login.form') }}" class="btn btn-login">Masuk</a>
                        <a href="{{ route('register.form') }}" class="btn btn-daftar">Daftar</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>