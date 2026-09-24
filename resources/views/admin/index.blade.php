@extends('layouts.admin')

@section('title', 'Admin Panel - Ruang Tulis | Ruang Sunyi')

@section('content')
<main class="flex-grow-1 py-4">
    <div class="container-fluid px-3 px-md-4">
        {{-- Breadcrumb & Page Title Banner --}}
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-md-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 font-mono small text-secondary">
                        <li class="breadcrumb-item"><a class="text-secondary text-decoration-none" href="{{ route('admin.index') }}">Nocturne Notes</a></li>
                        <li class="breadcrumb-item"><a class="text-secondary text-decoration-none" href="{{ route('admin.index') }}">Admin Panel</a></li>
                        <li aria-current="page" class="breadcrumb-item active text-light">Ruang Tulis</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-light mb-1">Ruang Tulis &amp; Buat Catatan Baru</h1>
                <p class="text-secondary mb-0 small">Selamat malam, <strong>{{ auth()->user()->name }}</strong> (@@StepMe). Luapkan hening malam dan dokumentasikan perenunganmu.</p>
            </div>
            <div class="col-12 col-md-4 mt-3 mt-md-0 text-md-end">
                <span class="badge bg-dark border border-secondary text-secondary px-3 py-2 font-mono small">
                    <i class="bi bi-cloud-check text-success me-1"></i> Sinkronisasi Lokal Aktif
                </span>
            </div>
        </div>

        <div class="row g-4">
            {{-- ================= PRIMARY COLUMN: COMPOSER & CONTENT LIST ================= --}}
            <div class="col-lg-8">
                {{-- COMPOSER CARD --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-primary bg-primary bg-opacity-10 p-1.5 rounded">
                                <i class="bi bi-pen-fill"></i>
                            </div>
                            <span class="fw-semibold text-light small text-uppercase font-mono">Editor Catatan &amp; Status</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary bg-opacity-25 text-secondary font-mono small">
                                <span id="wordCounter">0</span> kata
                            </span>
                            <span class="badge badge-subtle-info font-mono small">Markdown Siap</span>
                        </div>
                    </div>
                    <div class="card-body p-3 p-md-4">
                        {{-- Formatting Toolbar --}}
                        <div class="d-flex flex-wrap align-items-center gap-1 mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                            <button class="editor-toolbar-btn" title="Tebal (Ctrl+B)" type="button"><i class="bi bi-type-bold"></i></button>
                            <button class="editor-toolbar-btn" title="Miring (Ctrl+I)" type="button"><i class="bi bi-type-italic"></i></button>
                            <button class="editor-toolbar-btn" title="Blok Kode" type="button"><i class="bi bi-code-slash"></i></button>
                            <button class="editor-toolbar-btn" data-toggle-box="#quoteAttachmentBox" title="Blok Kutipan" type="button"><i class="bi bi-quote"></i></button>
                            <button class="editor-toolbar-btn" data-toggle-box="#imageAttachmentBox" title="Sisipkan Gambar" type="button"><i class="bi bi-image"></i></button>
                            <button class="editor-toolbar-btn" title="Tautan Web" type="button"><i class="bi bi-link-45deg"></i></button>
                            <div class="vr mx-1 opacity-25"></div>
                            <button class="editor-toolbar-btn" title="Tag Suasana Hati" type="button"><i class="bi bi-emoji-smile"></i> Mood Tag</button>
                            <button class="editor-toolbar-btn ms-auto text-info" title="Pratinjau Langsung" type="button"><i class="bi bi-eye-fill me-1"></i> Preview</button>
                        </div>

                        {{-- Main Textarea Control --}}
                        <div class="card-nested p-3 mb-3">
                            <textarea class="form-control composer-textarea p-0" id="mainComposerText" placeholder="Tulis apa yang sedang kamu rasakan, alami, atau renungkan malam ini..." rows="5"></textarea>

                            {{-- Attached Quote Preview Box --}}
                            <div class="mt-3 p-3 rounded-2 bg-dark bg-opacity-75 border-start border-primary border-3 d-flex align-items-start justify-content-between gap-2" id="quoteAttachmentBox">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="bi bi-quote fs-4 text-primary lh-1 mt-1"></i>
                                    <p class="font-editorial fst-italic text-secondary mb-0 small">
                                        "Malam tak pernah benar-benar sunyi bagi mereka yang masih gemar berteman dengan riak memorinya sendiri."
                                    </p>
                                </div>
                                <button class="btn btn-sm btn-link text-secondary p-0 text-decoration-none" data-toggle-box="#quoteAttachmentBox" title="Hapus kutipan" type="button">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            {{-- Attachment Preview Option --}}
                            <div class="mt-3 p-2 rounded-2 bg-dark border border-secondary border-opacity-25 d-none" id="imageAttachmentBox">
                                <div class="d-flex align-items-center justify-content-between mb-2 px-1">
                                    <span class="small font-mono text-secondary"><i class="bi bi-paperclip me-1"></i>Lampiran Gambar</span>
                                    <button class="btn-action-icon" data-toggle-box="#imageAttachmentBox" title="Tutup lampiran" type="button"><i class="bi bi-x"></i></button>
                                </div>
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <img alt="Desk setup preview" class="rounded object-fit-cover" height="54" width="80"
                                             src="https://lh3.googleusercontent.com/aida-public/AB6AXuDq6-8TJW5gHZSwzqIGPMYch1w0MnBp7EU5KFk71aaz-UCJFuoyt7jEspjQaTuFqWxYTpNMzNM63Q5EIrR3pVtHGAcPSZE9Sa6toN91Z_VZ2ektovsKGvymvEin7w9K2ShJp1jAfDKWbkrDvVUNDH2iv6_Fdf2k06IB_4zshD3wCOvGtWzaUc4gzZtqSXLNe3eXyUorq77FyZOFPLTEbOXMKazhnU1lT8anhneAoEKjZR07B-UQqNPDeA">
                                    </div>
                                    <div class="col">
                                        <div class="small fw-semibold text-light text-truncate">obsidian-midnight-desk.jpg</div>
                                        <div class="font-mono text-secondary" style="font-size: 0.75rem;">1920x1080 • 420 KB • Tersemat</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Category & Mood Picker + Privacy Selector --}}
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-md-5">
                                <label class="form-label font-mono small text-secondary mb-1" for="categoryPicker">Kategori / Mood Catatan</label>
                                <select class="form-select form-select-sm bg-dark border-secondary border-opacity-50 text-light" id="categoryPicker">
                                    <option selected value="renungan">🌙 Renungan Malam</option>
                                    <option value="keseharian">☕ Keseharian &amp; Kopi</option>
                                    <option value="catatan-lepas">🍃 Catatan Lepas</option>
                                    <option value="buku-ide">📚 Buku &amp; Ide</option>
                                    <option value="teknis">⚡ Catatan Teknis</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label font-mono small text-secondary mb-1">Aksesibilitas</label>
                                <div aria-label="Privacy Toggle" class="btn-group btn-group-sm w-100" role="group">
                                    <input autocomplete="off" checked class="btn-check" id="privPublic" name="privacyOpt" type="radio">
                                    <label class="btn btn-outline-secondary" for="privPublic"><i class="bi bi-globe2 me-1"></i>Publik</label>
                                    <input autocomplete="off" class="btn-check" id="privPrivate" name="privacyOpt" type="radio">
                                    <label class="btn btn-outline-secondary" for="privPrivate"><i class="bi bi-lock-fill me-1"></i>Pribadi</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 d-flex justify-content-md-end gap-2 align-items-end mt-md-4">
                                <button class="btn btn-outline-secondary btn-sm px-3" type="button">
                                    <i class="bi bi-file-earmark-text me-1"></i>Simpan Draft
                                </button>
                                <button class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1.5 shadow" type="button">
                                    <span>Terbitkan Catatan</span>
                                    <i class="bi bi-send-fill"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- POSTS MANAGEMENT --}}
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h2 class="h5 fw-bold text-light mb-0">Kelola Catatan Jurnal</h2>
                        <span class="text-secondary small">Daftar arsip status, draf tersimpan, dan catatan terpublikasi</span>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="max-width: 220px;">
                            <span class="input-group-text bg-dark border-secondary border-opacity-50 text-secondary"><i class="bi bi-search"></i></span>
                            <input class="form-control bg-dark border-secondary border-opacity-50 text-light" placeholder="Cari tulisan..." type="text">
                        </div>
                    </div>
                </div>

                {{-- Tabs Filter --}}
                <ul class="nav nav-pills mb-3 gap-1 font-mono small">
                    <li class="nav-item">
                        <button class="nav-link active py-1.5 px-3 rounded-pill" data-bs-toggle="pill">Semua (152)</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1.5 px-3 rounded-pill" data-bs-toggle="pill">Terpublikasi (148)</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1.5 px-3 rounded-pill" data-bs-toggle="pill">Draf Terkunci (4)</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-secondary py-1.5 px-3 rounded-pill" data-bs-toggle="pill">Disematkan (2)</button>
                    </li>
                </ul>

                {{-- List of Posts --}}
                <div class="d-flex flex-column gap-3 mb-4">
                    {{-- Card Item 1: Pinned Public --}}
                    <div class="card card-custom p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge badge-subtle-info font-mono"><i class="bi bi-globe2 me-1"></i>Publik</span>
                                <span class="badge badge-subtle-primary font-mono"><i class="bi bi-pin-angle-fill me-1"></i>Disematkan</span>
                                <span class="font-mono text-secondary small">Hari ini, 20:15 WIB</span>
                                <span class="text-secondary">•</span>
                                <span class="small text-light">🌙 Renungan Malam</span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button class="btn-action-icon" title="Edit Catatan" type="button"><i class="bi bi-pencil"></i></button>
                                <button class="btn-action-icon" title="Sembunyikan / Ubah ke Pribadi" type="button"><i class="bi bi-eye-slash"></i></button>
                                <button class="btn-action-icon btn-action-danger" title="Hapus" type="button"><i class="bi bi-trash3"></i></button>
                            </div>
                        </div>
                        <p class="font-editorial fs-5 text-light leading-relaxed mb-3">
                            Terkadang yang kita butuhkan di penghujung hari bukanlah jawaban atas semua kecemasan karir, melainkan segelas seduhan chamomile hangat dan keheningan yang tak menuntut pembuktian apa pun kepada dunia luar.
                        </p>
                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 border-top border-secondary border-opacity-25 gap-2">
                            <div class="d-flex gap-2 font-mono text-secondary" style="font-size: 0.8rem;">
                                <span>#MalamHari</span>
                                <span>#CatatanKecil</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="reaction-pill font-mono">❤️ 428</span>
                                <span class="reaction-pill font-mono">☕ 119</span>
                                <span class="reaction-pill font-mono">💬 34 respons</span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Item 2: Draft Post --}}
                    <div class="card card-custom p-3 p-md-4 border-warning border-opacity-25">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge badge-subtle-secondary font-mono"><i class="bi bi-lock-fill me-1"></i>Draf Terkunci</span>
                                <span class="font-mono text-secondary small">Kemarin, 23:40 WIB</span>
                                <span class="text-secondary">•</span>
                                <span class="small text-warning-emphasis">🌧️ Catatan Lepas</span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button class="btn btn-outline-primary btn-sm py-0 px-2 font-mono" style="font-size: 0.75rem;" type="button"><i class="bi bi-pencil-square me-1"></i>Lanjut Tulis</button>
                                <button class="btn-action-icon" title="Publikasikan Sekarang" type="button"><i class="bi bi-upload"></i></button>
                                <button class="btn-action-icon btn-action-danger" title="Hapus Draf" type="button"><i class="bi bi-trash3"></i></button>
                            </div>
                        </div>
                        <p class="font-editorial fs-5 text-secondary leading-relaxed mb-2">
                            Babak baru perpindahan studio ke Yogyakarta: Mengapa melepaskan kepemilikan material terasa jauh lebih melegakan dibanding mengumpulkannya secara rakus selama 5 tahun terakhir di ibu kota...
                        </p>
                        <div class="font-mono text-info small mb-3 fst-italic">[Belum selesai • 310 kata tersimpan di draf privat]</div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-2 border-top border-secondary border-opacity-25 gap-2">
                            <div class="d-flex gap-2 font-mono text-secondary" style="font-size: 0.8rem;">
                                <span>#EsaiPanjang</span>
                                <span>#Perjalanan</span>
                            </div>
                            <span class="font-mono text-secondary small"><i class="bi bi-shield-lock me-1"></i>Visibilitas: Hanya Penulis</span>
                        </div>
                    </div>

                    {{-- Card Item 3: Public Casual with Image --}}
                    <div class="card card-custom p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge badge-subtle-info font-mono"><i class="bi bi-globe2 me-1"></i>Publik</span>
                                <span class="font-mono text-secondary small">18 Okt, 14:10 WIB</span>
                                <span class="text-secondary">•</span>
                                <span class="small text-light">⚡ Catatan Teknis</span>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button class="btn-action-icon" title="Edit" type="button"><i class="bi bi-pencil"></i></button>
                                <button class="btn-action-icon" title="Sematkan" type="button"><i class="bi bi-pin-angle"></i></button>
                                <button class="btn-action-icon" title="Sembunyikan" type="button"><i class="bi bi-eye-slash"></i></button>
                                <button class="btn-action-icon btn-action-danger" title="Hapus" type="button"><i class="bi bi-trash3"></i></button>
                            </div>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-9">
                                <p class="font-editorial fs-5 text-light leading-relaxed mb-0">
                                    Eksperimen menyusun micro-service menggunakan Rust kemarin sore menghasilkan latensi di bawah 2 milidetik. Menyenangkan sekali saat kode sederhana bekerja begitu anggun tanpa kompromi performa.
                                </p>
                            </div>
                            <div class="col-md-3">
                                <img alt="Terminal Obsidian Setup" class="img-fluid rounded border border-secondary border-opacity-25"
                                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuDq6-8TJW5gHZSwzqIGPMYch1w0MnBp7EU5KFk71aaz-UCJFuoyt7jEspjQaTuFqWxYTpNMzNM63Q5EIrR3pVtHGAcPSZE9Sa6toN91Z_VZ2ektovsKGvymvEin7w9K2ShJp1jAfDKWbkrDvVUNDH2iv6_Fdf2k06IB_4zshD3wCOvGtWzaUc4gzZtqSXLNe3eXyUorq77FyZOFPLTEbOXMKazhnU1lT8anhneAoEKjZR07B-UQqNPDeA">
                            </div>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 border-top border-secondary border-opacity-25 mt-3 gap-2">
                            <div class="d-flex gap-2 font-mono text-secondary" style="font-size: 0.8rem;">
                                <span>#Teknologi</span>
                                <span>#Craftsmanship</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="reaction-pill font-mono">⚡ 289</span>
                                <span class="reaction-pill font-mono">❤️ 143</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pagination --}}
                <nav class="d-flex justify-content-between align-items-center mb-4">
                    <span class="small font-mono text-secondary">Menampilkan 3 dari 152 postingan</span>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link bg-dark border-secondary text-secondary" href="#">Sebelumnya</a></li>
                        <li class="page-item active"><a class="page-link bg-primary border-primary text-dark" href="#">1</a></li>
                        <li class="page-item"><a class="page-link bg-dark border-secondary text-light" href="#">2</a></li>
                        <li class="page-item"><a class="page-link bg-dark border-secondary text-light" href="#">3</a></li>
                        <li class="page-item"><a class="page-link bg-dark border-secondary text-light" href="#">Selanjutnya</a></li>
                    </ul>
                </nav>
            </div>

            {{-- ================= SIDEBAR COLUMN ================= --}}
            <div class="col-lg-4">
                {{-- 1. QUICK STATS PANEL --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex align-items-center justify-content-between">
                        <span class="fw-semibold text-light small text-uppercase font-mono">
                            <i class="bi bi-graph-up-arrow me-1.5 text-primary"></i>Statistik Singkat
                        </span>
                        <span class="badge bg-dark border border-secondary text-secondary font-mono" style="font-size: 0.7rem;">Realtime</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="row g-2 text-center">
                            <div class="col-4">
                                <div class="card-nested p-2.5">
                                    <div class="text-secondary small font-mono">Total Catatan</div>
                                    <div class="fs-4 fw-bold text-light mt-1">152</div>
                                    <div class="text-success font-mono" style="font-size: 0.7rem;">+3 mgg ini</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card-nested p-2.5">
                                    <div class="text-secondary small font-mono">Pembaca</div>
                                    <div class="fs-4 fw-bold text-info mt-1">4.8k</div>
                                    <div class="text-secondary font-mono" style="font-size: 0.7rem;">Bulan Ini</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card-nested p-2.5">
                                    <div class="text-secondary small font-mono">Waktu Aktif</div>
                                    <div class="fs-4 fw-bold text-light mt-1">22:00</div>
                                    <div class="text-primary font-mono" style="font-size: 0.7rem;">Night Owl</div>
                                </div>
                            </div>
                        </div>
                        {{-- Writing Streak --}}
                        <div class="mt-3 p-2 rounded bg-dark border border-secondary border-opacity-25">
                            <div class="d-flex justify-content-between small font-mono mb-1">
                                <span class="text-secondary">Konsistensi Menulis</span>
                                <span class="text-primary">12 Hari Beruntun 🔥</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" class="progress-bar bg-primary" role="progressbar" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. PENGATURAN SIARAN --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3">
                        <span class="fw-semibold text-light small text-uppercase font-mono">
                            <i class="bi bi-sliders2 me-1.5 text-warning"></i>Pengaturan Siaran &amp; Interaksi
                        </span>
                    </div>
                    <div class="card-body p-3">
                        <div class="list-group list-group-flush bg-transparent">
                            <div class="list-group-item bg-transparent border-secondary border-opacity-25 px-0 py-2.5 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="small fw-semibold text-light">Terima Surat Anonim</div>
                                    <div class="text-secondary small" style="font-size: 0.78rem;">Izinkan pembaca mengirim pesan rahasia</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input checked class="form-check-input" id="toggleAnonymousMsg" role="switch" type="checkbox">
                                </div>
                            </div>
                            <div class="list-group-item bg-transparent border-secondary border-opacity-25 px-0 py-2.5 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="small fw-semibold text-light">Tampilkan Metrik Reaksi</div>
                                    <div class="text-secondary small" style="font-size: 0.78rem;">Tampilkan angka suka, kopi, dan tanggapan</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input checked class="form-check-input" id="toggleReactions" role="switch" type="checkbox">
                                </div>
                            </div>
                            <div class="list-group-item bg-transparent border-0 px-0 py-2.5 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="small fw-semibold text-light">Mode Malam Otomatis</div>
                                    <div class="text-secondary small" style="font-size: 0.78rem;">Redupkan kontras selepas pukul 21:00 WIB</div>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input checked class="form-check-input" id="toggleNightMode" role="switch" type="checkbox">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. KOTAK SURAT MASUK --}}
                <div class="card card-custom mb-4 shadow-sm">
                    <div class="card-header bg-transparent border-bottom border-secondary border-opacity-25 py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-heart-fill text-danger"></i>
                            <span class="fw-semibold text-light small text-uppercase font-mono">Surat Digital Pembaca</span>
                        </div>
                        <span class="badge bg-danger rounded-pill font-mono" style="font-size: 0.7rem;">2 Baru</span>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column gap-2.5">
                            <div class="card-nested p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-secondary bg-opacity-25 text-light font-mono small">Pengelana Malam #92</span>
                                    <span class="text-secondary font-mono" style="font-size: 0.72rem;">1 jam lalu</span>
                                </div>
                                <p class="font-editorial fst-italic text-light small mb-2">
                                    "Tulisanmu tentang keikhlasan meninggalkan ibu kota sangat menampar sekaligus memelukku yang sedang resah di kantor lembur ini. Terima kasih, Kak Resa."
                                </p>
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2 font-mono" style="font-size: 0.72rem;"><i class="bi bi-check2"></i> Tandai Dibaca</button>
                                    <button class="btn btn-outline-primary btn-sm py-0 px-2 font-mono" style="font-size: 0.72rem;"><i class="bi bi-reply-fill"></i> Balas</button>
                                </div>
                            </div>
                            <div class="card-nested p-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="badge bg-secondary bg-opacity-25 text-light font-mono small">Penikmat Senja &amp; Kopi</span>
                                    <span class="text-secondary font-mono" style="font-size: 0.72rem;">Kemarin, 21:04</span>
                                </div>
                                <p class="font-editorial fst-italic text-light small mb-2">
                                    "Rekomendasi racikan chamomile di status malam kemarin manjur sekali untuk insomnia saya. Ditunggu arsip tulisan berikutnya!"
                                </p>
                                <div class="d-flex justify-content-end gap-1">
                                    <button class="btn btn-outline-secondary btn-sm py-0 px-2 font-mono" style="font-size: 0.72rem;"><i class="bi bi-check2"></i> Tandai Dibaca</button>
                                    <button class="btn btn-outline-primary btn-sm py-0 px-2 font-mono" style="font-size: 0.72rem;"><i class="bi bi-reply-fill"></i> Balas</button>
                                </div>
                            </div>
                            <div class="text-center mt-3 pt-2 border-top border-secondary border-opacity-25">
                                <a class="small text-decoration-none text-secondary hover-text-light font-mono" href="#">
                                    Buka Arsip Semua Surat (48) <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. SYSTEM BACKUP WIDGET --}}
                <div class="card card-custom shadow-sm">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small font-mono text-secondary"><i class="bi bi-database-check me-1 text-success"></i>Cadangan Terakhir</span>
                            <span class="font-mono text-light small">10 mnt lalu</span>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-secondary btn-sm font-mono py-1.5" type="button">
                                <i class="bi bi-download me-1"></i>Ekspor Jurnal (.Markdown)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
