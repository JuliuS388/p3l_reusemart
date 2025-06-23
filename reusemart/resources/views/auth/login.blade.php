@extends('layouts.app_auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow-sm border-0 p-4" style="width: 100%; max-width: 400px;">
        <h4 class="mb-3 text-center">Masuk ke ReuseMart</h4>
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Masuk</button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
            </div>
        </form>

        <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register.form') }}">Daftar di sini</a></p>
    </div>
</div>
@endsection
