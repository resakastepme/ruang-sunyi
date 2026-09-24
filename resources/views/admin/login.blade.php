@extends('layouts.admin_auth')

@section('title', 'Masuk - Admin Ruang Sunyi')

@section('content')
<div class="w-100" style="max-width: 420px;">
    {{-- Brand --}}
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-25 text-primary mb-3" style="width: 54px; height: 54px;">
            <i class="bi bi-moon-stars-fill fs-3"></i>
        </div>
        <h1 class="h4 fw-bold text-light mb-1">Ruang Sunyi</h1>
        <span class="badge badge-subtle-primary font-mono text-uppercase" style="font-size: 0.68rem;">Admin Panel</span>
    </div>

    {{-- Login Card --}}
    <div class="card card-custom shadow-lg">
        <div class="card-body p-4 p-md-5">
            <h2 class="h5 fw-semibold text-light mb-1">Selamat datang kembali</h2>
            <p class="text-secondary small mb-4">Masuk untuk mengelola catatan nocturne.</p>

            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 small" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label font-mono small text-secondary">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               class="form-control bg-dark border-secondary border-opacity-50 text-light @error('email') is-invalid @enderror"
                               placeholder="nama@email.com" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label font-mono small text-secondary">Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password"
                               class="form-control bg-dark border-secondary border-opacity-50 text-light"
                               placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1" title="Tampilkan / sembunyikan kata sandi">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-secondary" for="remember">Ingat saya</label>
                    </div>
                    <span class="small text-secondary font-mono"><i class="bi bi-shield-lock me-1"></i>Mode Hening</span>
                </div>

                <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2 fw-semibold">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>
        </div>
    </div>

    <p class="text-center mt-4 mb-0">
        <a href="{{ route('linimasa.index') }}" class="text-secondary text-decoration-none small font-mono hover-light">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Linimasa Publik
        </a>
    </p>
</div>
@endsection
