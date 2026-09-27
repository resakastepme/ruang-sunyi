@extends('layouts.admin')

@section('title', 'Profil Pengarang - Admin Panel | Ruang Sunyi')

@php
    $user = auth()->user();

    // Placeholder foto profil (SVG inline) — tanpa berkas eksternal.
    $placeholderAvatar = 'data:image/svg+xml;base64,' . base64_encode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="120" height="120">'
        . '<rect width="24" height="24" rx="12" fill="#232733"/>'
        . '<circle cx="12" cy="9.4" r="3.4" fill="#5a5f70"/>'
        . '<path d="M5.4 19.4c0-3.7 2.95-5.7 6.6-5.7s6.6 2 6.6 5.7z" fill="#5a5f70"/>'
        . '</svg>'
    );

    $avatarUrl = $user->avatar ? asset('storage/' . $user->avatar) : $placeholderAvatar;
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
<style>
    @media (min-width: 992px) {
        .profile-preview-sticky { position: sticky; top: 5.5rem; }
    }

    /* Croppie — selaraskan dengan tema gelap */
    #cropModal .modal-content { background-color: #181c24; }
    #cropArea { width: 100%; }
    #cropArea .cr-boundary { border-radius: 10px; }
    #cropArea .cr-slider-wrap { margin-top: 1rem; }
    #cropArea .cr-slider { accent-color: #8083ff; }
</style>
@endpush

@section('content')
<main class="flex-grow-1 py-4">
    <div class="container-fluid px-3 px-md-4">

        {{-- ===================== Breadcrumb & Page Title ===================== --}}
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 font-mono small text-secondary">
                        <li class="breadcrumb-item"><a class="text-secondary text-decoration-none" href="{{ route('admin.index') }}">Admin Panel</a></li>
                        <li aria-current="page" class="breadcrumb-item active text-light">Profil Pengarang</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-light mb-1">Profil Pengarang</h1>
                <p class="text-secondary mb-0 small">Kelola identitas publikmu dan jaga keamanan akun tetap terkunci rapat.</p>
            </div>
            <div class="col-12 col-md-4 mt-3 mt-md-0 text-md-end">
                {{-- <span class="badge bg-dark border border-secondary text-secondary px-3 py-2 font-mono small">
                    <i class="bi bi-shield-lock text-success me-1"></i> Sesi Terverifikasi
                </span> --}}
            </div>
        </div>

        <div class="row g-4">
            {{-- ===================== KOLOM UTAMA: FORMULIR ===================== --}}
            <div class="col-lg-8">

                {{-- =============== KARTU 1 · DATA PROFIL =============== --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex align-items-center gap-2">
                        <div class="text-primary bg-primary bg-opacity-10 p-1.5 rounded">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <span class="fw-semibold text-light small text-uppercase font-mono">Identitas &amp; Profil Publik</span>
                    </div>

                    <div class="card-body p-3 p-md-4">
                        @if (session('status_profile'))
                            <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 small" role="alert">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ session('status_profile') }}</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.update-profile') }}" enctype="multipart/form-data" novalidate>
                            @csrf

                            {{-- Foto Profil --}}
                            <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start gap-3 gap-sm-4 mb-4 pb-4 border-bottom border-secondary border-opacity-25">
                                <img id="avatarPreview" src="{{ $avatarUrl }}" alt="Foto profil"
                                     class="rounded-circle object-fit-cover border border-secondary border-opacity-50 flex-shrink-0"
                                     width="96" height="96" style="width: 96px; height: 96px;">
                                <div class="flex-grow-1 text-center text-sm-start">
                                    <label for="avatar" class="form-label font-mono small text-secondary mb-1">Foto Profil</label>
                                    <input type="file" name="avatar" id="avatar" accept="image/png,image/jpeg,image/webp"
                                           class="form-control form-control-sm bg-dark border-secondary border-opacity-50 text-light @error('avatar') is-invalid @enderror">
                                    <div class="form-text text-secondary font-mono" style="font-size: 0.72rem;">
                                        <i class="bi bi-info-circle me-1"></i>JPG, PNG, atau WEBP. Maksimal 2&nbsp;MB.
                                    </div>
                                    @error('avatar')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="mb-3">
                                <label for="name" class="form-label font-mono small text-secondary">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                           class="form-control bg-dark border-secondary border-opacity-50 text-light @error('name') is-invalid @enderror"
                                           placeholder="Nama pena atau nama aslimu" maxlength="100" required>
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Username / Handle --}}
                            <div class="mb-3">
                                <label for="username" class="form-label font-mono small text-secondary">Nama Pengguna</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary">{{ '@' }}</span>
                                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                                           class="form-control bg-dark border-secondary border-opacity-50 text-light @error('username') is-invalid @enderror"
                                           placeholder="nama_pengguna" maxlength="30" autocomplete="off">
                                </div>
                                <div class="form-text text-secondary font-mono" style="font-size: 0.72rem;">
                                    <i class="bi bi-at me-1"></i>Huruf, angka, tanda hubung, dan garis bawah saja.
                                </div>
                                @error('username')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi / Bio --}}
                            <div class="mb-4">
                                <label for="bio" class="form-label font-mono small text-secondary d-flex justify-content-between">
                                    <span>Deskripsi</span>
                                    <span class="text-secondary"><span id="bioCount">{{ strlen(old('bio', $user->bio) ?? '') }}</span>/500</span>
                                </label>
                                <textarea name="bio" id="bio" rows="4" maxlength="500"
                                          class="form-control bg-dark border-secondary border-opacity-50 text-light @error('bio') is-invalid @enderror"
                                          placeholder="Ceritakan sedikit tentang dirimu — sepatah dua kata yang menemani nama di ruang hening ini.">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1.5 fw-semibold px-3">
                                    <i class="bi bi-check2-circle"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- =============== KARTU 2 · UBAH KATA SANDI =============== --}}
                <div class="card card-custom shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex align-items-center gap-2">
                        <div class="text-primary bg-primary bg-opacity-10 p-1.5 rounded">
                            <i class="bi bi-key-fill"></i>
                        </div>
                        <span class="fw-semibold text-light small text-uppercase font-mono">Ubah Kata Sandi</span>
                    </div>

                    <div class="card-body p-3 p-md-4">
                        @if (session('status_password'))
                            <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 small" role="alert">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ session('status_password') }}</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.update-password') }}" novalidate>
                            @csrf

                            {{-- Kata Sandi Saat Ini --}}
                            <div class="mb-3">
                                <label for="current_password" class="form-label font-mono small text-secondary">Kata Sandi Saat Ini</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="current_password" id="current_password"
                                           class="form-control bg-dark border-secondary border-opacity-50 text-light @error('current_password', 'updatePassword') is-invalid @enderror"
                                           placeholder="••••••••" autocomplete="current-password">
                                    <button class="btn btn-outline-secondary" type="button" data-toggle-pw="#current_password" tabindex="-1" title="Tampilkan / sembunyikan">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kata Sandi Baru --}}
                            <div class="mb-3">
                                <label for="password" class="form-label font-mono small text-secondary">Kata Sandi Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="password" id="password"
                                           class="form-control bg-dark border-secondary border-opacity-50 text-light @error('password', 'updatePassword') is-invalid @enderror"
                                           placeholder="Minimal 8 karakter" autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" data-toggle-pw="#password" tabindex="-1" title="Tampilkan / sembunyikan">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Konfirmasi Kata Sandi --}}
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label font-mono small text-secondary">Konfirmasi Kata Sandi Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control bg-dark border-secondary border-opacity-50 text-light"
                                           placeholder="Ulangi kata sandi baru" autocomplete="new-password">
                                    <button class="btn btn-outline-secondary" type="button" data-toggle-pw="#password_confirmation" tabindex="-1" title="Tampilkan / sembunyikan">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1.5 fw-semibold px-3">
                                    <i class="bi bi-arrow-repeat"></i> Perbarui Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ===================== SIDEBAR: PRATINJAU ===================== --}}
            <div class="col-lg-4">
                {{-- <div class="card card-custom shadow-sm mb-4 profile-preview-sticky">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex align-items-center gap-2">
                        <div class="text-primary bg-primary bg-opacity-10 p-1.5 rounded">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <span class="fw-semibold text-light small text-uppercase font-mono">Pratinjau Kartu</span>
                    </div>
                    <div class="card-body p-4 text-center">
                        <img id="pvAvatar" src="{{ $avatarUrl }}" alt="Pratinjau foto profil"
                             class="rounded-circle object-fit-cover border border-secondary border-opacity-50 mb-3"
                             width="88" height="88" style="width: 88px; height: 88px;">
                        <h2 id="pvName" class="h5 fw-bold text-light mb-1">{{ $user->name }}</h2>
                        <p id="pvUsername" class="font-mono small text-primary mb-3">{{ '@' . ($user->username ?: 'username') }}</p>
                        <p id="pvBio" class="text-secondary small mb-0 font-editorial fst-italic">{{ $user->bio ?: 'Belum ada deskripsi.' }}</p>
                    </div>
                </div>

                <div class="card card-nested">
                    <div class="card-body p-3 d-flex gap-2.5">
                        <i class="bi bi-shield-lock-fill text-primary fs-5 lh-1 mt-1"></i>
                        <div>
                            <div class="small fw-semibold text-light mb-1">Jaga privasimu</div>
                            <p class="text-secondary mb-0" style="font-size: 0.78rem; line-height: 1.6;">
                                Gunakan kata sandi yang unik dan tak terduga. Ruang Sunyi tidak akan pernah memintanya lewat email.
                            </p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</main>

{{-- ===================== MODAL POTONG FOTO (Croppie) ===================== --}}
<div class="modal fade" id="cropModal" tabindex="-1" aria-hidden="true" aria-labelledby="cropModalLabel"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content card-custom border-secondary border-opacity-25">
            <div class="modal-header border-bottom border-secondary border-opacity-25 py-3">
                <h5 class="modal-title h6 fw-semibold text-light font-mono text-uppercase small d-flex align-items-center gap-2 mb-0" id="cropModalLabel">
                    <i class="bi bi-crop text-primary"></i> Sesuaikan Foto Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <div id="cropArea" class="mx-auto"></div>
                <div class="d-flex align-items-center justify-content-center gap-2 mt-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" id="cropRotateL" title="Putar kiri">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" id="cropRotateR" title="Putar kanan">
                        <i class="bi bi-arrow-clockwise"></i>
                    </button>
                </div>
                <p class="text-secondary text-center font-mono mt-2 mb-0" style="font-size: 0.72rem;">
                    <i class="bi bi-arrows-move me-1"></i>Seret untuk menggeser &bull; gulir atau slider untuk memperbesar
                </p>
            </div>
            <div class="modal-footer border-top border-secondary border-opacity-25 py-3">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-1.5 fw-semibold" id="cropApply">
                    <i class="bi bi-check2"></i> Gunakan Foto
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
$(function () {
    'use strict';

    // ============ Upload + potong foto profil (Croppie) ============
    var croppie = null, rawImage = null, cropApplied = false;
    var cropModalEl = document.getElementById('cropModal');
    var cropModal = cropModalEl ? new bootstrap.Modal(cropModalEl) : null;

    // Buka cropper begitu berkas dipilih
    $('#avatar').on('change', function () {
        var file = this.files && this.files[0];
        if (!file || !cropModal) return;
        if (!/^image\/(png|jpe?g|webp)$/i.test(file.type)) return; // biar validasi server yang menolak
        var reader = new FileReader();
        reader.onload = function (e) {
            rawImage = e.target.result;
            cropApplied = false;
            cropModal.show();
        };
        reader.readAsDataURL(file);
    });

    if (cropModalEl) {
        // Inisialisasi Croppie setelah modal tampil (agar dimensinya terukur benar)
        cropModalEl.addEventListener('shown.bs.modal', function () {
            if (croppie) { croppie.destroy(); croppie = null; }
            croppie = new Croppie(document.getElementById('cropArea'), {
                viewport: { width: 220, height: 220, type: 'circle' },
                boundary: { width: 280, height: 280 },
                showZoomer: true,
                enableOrientation: true
            });
            croppie.bind({ url: rawImage });
        });

        // Bersihkan saat ditutup; buang pilihan bila batal memotong
        cropModalEl.addEventListener('hidden.bs.modal', function () {
            if (croppie) { croppie.destroy(); croppie = null; }
            if (!cropApplied) { $('#avatar').val(''); }
        });
    }

    // Putar gambar
    $('#cropRotateL').on('click', function () { if (croppie) croppie.rotate(90); });
    $('#cropRotateR').on('click', function () { if (croppie) croppie.rotate(-90); });

    // Terapkan hasil potongan → tulis balik ke input file + perbarui pratinjau
    $('#cropApply').on('click', function () {
        if (!croppie) return;
        var $btn = $(this).prop('disabled', true);
        croppie.result({ type: 'blob', size: { width: 512, height: 512 }, format: 'jpeg', quality: 0.9 })
            .then(function (blob) {
                var cropped = new File([blob], 'avatar.jpg', { type: 'image/jpeg' });
                try {
                    var dt = new DataTransfer();
                    dt.items.add(cropped);
                    document.getElementById('avatar').files = dt.files;
                } catch (err) {
                    console.warn('DataTransfer tidak didukung browser ini:', err);
                }
                $('#avatarPreview, #pvAvatar').attr('src', URL.createObjectURL(blob));
                cropApplied = true;
                cropModal.hide();
            })
            .finally(function () { $btn.prop('disabled', false); });
    });

    // Sinkronisasi teks pratinjau langsung --------------------------------
    $('#name').on('input', function () {
        $('#pvName').text($(this).val().trim() || 'Tanpa Nama');
    });
    $('#username').on('input', function () {
        var v = $(this).val().trim();
        $('#pvUsername').text('@' + (v || 'username'));
    });
    $('#bio').on('input', function () {
        var v = $(this).val();
        $('#bioCount').text(v.length);
        $('#pvBio').text(v.trim() || 'Belum ada deskripsi.');
    });

    // Show / hide kata sandi (generik via data-attribute) -----------------
    $('[data-toggle-pw]').on('click', function () {
        var $input = $($(this).attr('data-toggle-pw'));
        var toText = $input.attr('type') === 'password';
        $input.attr('type', toText ? 'text' : 'password');
        $(this).find('i').toggleClass('bi-eye bi-eye-slash');
    });
});
</script>
@endpush
