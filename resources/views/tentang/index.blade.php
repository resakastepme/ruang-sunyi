@extends('layouts.app')

@section('title', 'Tentang Saya - Ruang Sunyi')

@section('body_class', 'accent-glow')

@section('content')
<div class="container">
    {{-- Hero Profile Section --}}
    <section class="py-3 py-md-4 mb-4">
        <div class="row align-items-center g-4">
            <div class="col-auto">
                <div class="position-relative">
                    <img src="https://lh3.googleusercontent.com/aida/AEtjO1WFvF7Iq6ZoyAsINeCigTQed_XObjbC-yV7L5hg8CJknfK-ZsqNV0QDBXsRZ2bVTQuBUuRbPtkI0czTvDAQ0MyBz2aIspqBYU12KcMDzt1iLfs8nKHG7MuI2Q5aXI670nXvSQCMIsUgh575RVamDeYyMzODedg3i61x8SpGhrIl4SfJFdh6sQaW0CIaFKAjBX3YdwMsUWQSxCm5BIRCnZqy1cl-hkWPN_GFZXQyTHByrCcuNP_dwYyJ04U"
                         alt="Resa Komara Akbari" class="rounded-4 object-fit-cover shadow-lg border border-light border-opacity-10" width="136" height="136">
                    <span class="position-absolute bottom-0 start-50 translate-middle-x badge rounded-pill bg-dark border border-secondary-subtle font-code px-2 py-1 shadow-sm" style="font-size: 0.72rem;">
                        <i class="bi bi-circle-fill text-success me-1" style="font-size: 7px;"></i> Malam Hari
                    </span>
                </div>
            </div>
            <div class="col">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1 font-code" style="font-size: 0.75rem;">
                        <i class="bi bi-code-slash me-1"></i> Fullstack Programmer &amp; Night Writer
                    </span>
                    <span class="badge rounded-pill bg-dark border border-secondary border-opacity-25 text-secondary font-code" style="font-size: 0.75rem;">
                        <i class="bi bi-terminal me-1 text-info"></i>@@StepMe
                    </span>
                    <span class="badge rounded-pill bg-dark border border-secondary border-opacity-25 text-secondary font-code" style="font-size: 0.75rem;">
                        <i class="bi bi-geo-alt me-1 text-info"></i>Yogyakarta
                    </span>
                </div>
                <h1 class="h2 fw-bold text-light mb-1 d-flex align-items-baseline gap-2 flex-wrap">
                    Resa Komara Akbari
                    <span class="text-secondary fs-6 fw-normal font-code">(StepMe)</span>
                </h1>
                <p class="text-secondary mb-3" style="max-width: 620px; font-size: 0.98rem; line-height: 1.6;">
                    Merajut baris kode di siang hari, merapikan benang kusut pikiran di keheningan malam. Ruang suaka digital untuk merekam ide, arsitektur sistem, dan renungan hidup.
                </p>
                <div class="d-flex flex-wrap gap-2 pt-1">
                    <div class="badge bg-body-tertiary border text-body-secondary py-2 px-3 rounded-3 d-inline-flex align-items-center gap-2 fw-normal">
                        <i class="bi bi-braces text-primary"></i>
                        <span class="fw-semibold text-light">Fullstack</span> Engineering
                    </div>
                    <div class="badge bg-body-tertiary border text-body-secondary py-2 px-3 rounded-3 d-inline-flex align-items-center gap-2 fw-normal">
                        <i class="bi bi-journal-text text-info"></i>
                        <span class="fw-semibold text-light">148+</span> Catatan Disusun
                    </div>
                    <div class="badge bg-body-tertiary border text-body-secondary py-2 px-3 rounded-3 d-inline-flex align-items-center gap-2 fw-normal">
                        <i class="bi bi-moon-stars text-secondary"></i>
                        <span>Ritme Hening</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Manifesto Quote Card --}}
        <div class="card card-sunyi rounded-4 mt-4 p-3 p-md-4 shadow-sm border-start border-start-3 border-start-primary">
            <div class="d-flex align-items-start gap-3">
                <span class="text-primary opacity-50 fs-2 lh-1"><i class="bi bi-quote"></i></span>
                <blockquote class="blockquote mb-0 font-editorial-italic text-light" style="font-size: 1.15rem; line-height: 1.7;">
                    "Bagi saya, menulis kode dan merangkai kata memiliki esensi yang serupa: keduanya menuntut kejujuran struktur, ketelitian logika, dan ruang jeda untuk bernapas."
                </blockquote>
            </div>
        </div>
    </section>

    {{-- Main Layout: Sidebar and Essays --}}
    <div class="row g-4 pt-2">
        {{-- Sidebar Navigation & Sparkline --}}
        <aside class="col-lg-4 order-lg-1">
            <div class="sticky-top" style="top: 86px; z-index: 10;">
                <div class="card card-sunyi rounded-4 p-3 mb-4 shadow-sm">
                    <div class="d-flex align-items-center gap-2 text-primary font-code mb-3 fw-medium" style="font-size: 0.8rem; letter-spacing: 0.08em;">
                        <i class="bi bi-list-nested"></i> DAFTAR REFLEKSI
                    </div>
                    <div class="list-group list-group-flush bg-transparent">
                        <a class="list-group-item list-group-item-action bg-transparent border-0 px-2 py-2 d-flex justify-content-between align-items-center rounded-2 text-secondary" href="#mengapa-ada">
                            <span>1. Mengapa Tempat Ini Ada?</span>
                            <span class="font-code small text-secondary opacity-50">01</span>
                        </a>
                        <a class="list-group-item list-group-item-action bg-transparent border-0 px-2 py-2 d-flex justify-content-between align-items-center rounded-2 text-secondary" href="#tentang-penulis">
                            <span>2. Di Balik Meja Kerja</span>
                            <span class="font-code small text-secondary opacity-50">02</span>
                        </a>
                        <a class="list-group-item list-group-item-action bg-transparent border-0 px-2 py-2 d-flex justify-content-between align-items-center rounded-2 text-secondary" href="#filosofi-sunyi">
                            <span>3. Menulis Lambat (Slow Web)</span>
                            <span class="font-code small text-secondary opacity-50">03</span>
                        </a>
                    </div>
                    <hr class="border-secondary opacity-10 my-3">
                    {{-- Night rhythm visualizer --}}
                    <div class="p-2 rounded-3 bg-dark-subtle border border-light border-opacity-5">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Frekuensi Malam</span>
                            <span class="font-code text-primary small fw-semibold">22:00 — 03:00</span>
                        </div>
                        <div class="d-flex align-items-end justify-content-between gap-1" style="height: 38px;">
                            <div class="sparkline-bar" style="height: 25%;"></div>
                            <div class="sparkline-bar" style="height: 40%;"></div>
                            <div class="sparkline-bar" style="height: 30%;"></div>
                            <div class="sparkline-bar" style="height: 65%;"></div>
                            <div class="sparkline-bar active" style="height: 95%;"></div>
                            <div class="sparkline-bar active" style="height: 100%;"></div>
                            <div class="sparkline-bar" style="height: 80%;"></div>
                            <div class="sparkline-bar" style="height: 45%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Ritual Section Mini List --}}
                <div class="card card-sunyi-dark rounded-4 p-3 border border-secondary border-opacity-10">
                    <h6 class="font-code text-uppercase text-secondary small fw-semibold mb-3">
                        <i class="bi bi-cup-hot me-1 text-warning"></i> Perlengkapan Sunyi
                    </h6>
                    <ul class="list-unstyled small text-secondary mb-0 d-flex flex-column gap-2">
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2 text-primary"></i> Neovim / VSCode Minimalist
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2 text-primary"></i> V60 Single Origin Flores
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2 text-primary"></i> Buku Distributed Systems
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="bi bi-check2 text-primary"></i> Lo-Fi &amp; Suara Gemericik Air Hujan
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        {{-- Right Essay Articles --}}
        <article class="col-lg-8 order-lg-2">
            {{-- Section 1 --}}
            <section class="mb-5 pb-2" id="mengapa-ada">
                <div class="d-flex align-items-center gap-2 font-code text-secondary mb-2" style="font-size: 0.8rem; letter-spacing: 0.1em;">
                    <span class="text-primary fw-semibold">#01</span>
                    <span>—</span>
                    <span>INTENSI &amp; KELUASAN</span>
                </div>
                <h2 class="h3 fw-semibold text-light mb-3">Mengapa Tempat Ini Ada?</h2>
                <div class="font-editorial text-secondary">
                    <p>
                        Di jagat maya hari ini, kita terus digiring untuk berbicara cepat, bereaksi tanpa jeda, dan menimbang nilai gagasan hanya berdasarkan angka metrik yang rapuh. Suara-suara paling riuh menjadi pemenang, sementara perenungan yang membutuhkan waktu justru tergilas tanpa jejak.
                    </p>
                    <p>
                        <strong class="text-light fw-medium">Ruang Sunyi</strong> saya bangun sebagai tempat berteduh. Sebuah santuari digital sederhana di mana kata-kata tidak diproduksi untuk memikat algoritma linimasa, melainkan dibiarkan tumbuh organik layaknya catatan harian di pinggir meja kayu lapuk.
                    </p>
                    <p class="mb-0">
                        Di sini, saya mendokumentasikan serpihan pikiran setengah matang, kutipan buku yang menyenggol kesadaran, serta percakapan hening antara diri saya dan malam yang sunyi.
                    </p>
                </div>
            </section>

            {{-- Section 2 --}}
            <section class="mb-5 pb-2" id="tentang-penulis">
                <div class="d-flex align-items-center gap-2 font-code text-secondary mb-2" style="font-size: 0.8rem; letter-spacing: 0.1em;">
                    <span class="text-primary fw-semibold">#02</span>
                    <span>—</span>
                    <span>DI BALIK LAYAR &amp; KACA JENDELA</span>
                </div>
                <h2 class="h3 fw-semibold text-light mb-3">Tentang Penulis // Resa Komara Akbari</h2>
                <div class="font-editorial text-secondary">
                    <p>
                        Keseharian saya berporos pada dunia rekayasa perangkat lunak sebagai fullstack engineer dengan alias <em class="text-light">StepMe</em>. Di balik layar, saya bergulat dengan arsitektur sistem, rancang bangun database, API yang efisien, hingga estetika antarmuka modern yang intuitif.
                    </p>
                    <p>
                        Namun di luar deru commit dan arsitektur kode berskala besar, saya memerlukan ruang untuk memperlambat tempo. <strong class="text-light fw-medium">Ruang Sunyi</strong> saya jadikan sanctuary digital untuk menerapkan prinsip <em>slow web</em>: wadah menulis bebas tanpa intervensi algoritma umpan beranda media sosial, tanpa kejar tayang metrik impresi, dan tanpa hiruk-pikuk kebisingan maya.
                    </p>
                    <p>
                        Bagi saya, menyusun logika kode yang bersih dan merapikan paragraf tulisan yang mengalir memiliki kepuasan yang identik: menuntut kejernihan budi, integritas struktur, serta pembersihan atas segala hal yang berlebih.
                    </p>
                </div>
                {{-- Highlight Quote Callout --}}
                <div class="card card-sunyi-dark border-0 p-3 rounded-4 mt-3">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-flower1 text-secondary fs-3"></i>
                        <div>
                            <h6 class="text-light mb-1 fw-semibold">Kredo Sederhana</h6>
                            <p class="text-secondary small mb-0 font-editorial-italic" style="font-size: 1.05rem;">
                                "Kode yang baik dibangun dengan ketenangan, pemikiran yang jernih lahir dari jeda."
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Section 3 --}}
            <section class="mb-5 pb-2" id="filosofi-sunyi">
                <div class="d-flex align-items-center gap-2 font-code text-secondary mb-2" style="font-size: 0.8rem; letter-spacing: 0.1em;">
                    <span class="text-primary fw-semibold">#03</span>
                    <span>—</span>
                    <span>GERAKAN LAMBAT</span>
                </div>
                <h2 class="h3 fw-semibold text-light mb-3">Merawat Gerakan 'Slow Web'</h2>
                <div class="font-editorial text-secondary">
                    <p class="mb-0">
                        Saya percaya pada web personal: ruang yang dimiliki sendiri, mandiri dari platform raksasa, bebas dari pelacakan yang agresif, dan bernafas tenang. Setiap catatan di linimasa ini bisa Anda baca tanpa desakan notifikasi, tanpa tombol suka yang memicu kecemasan, dan tanpa keharusan untuk selalu sepakat.
                    </p>
                </div>
            </section>

            {{-- Rituals / Hal-hal yang Menemani --}}
            <section class="mb-5 pt-3 border-top border-secondary border-opacity-10">
                <div class="mb-4">
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 font-code px-2 py-1 mb-2">
                        <i class="bi bi-cup-hot me-1"></i> RITUAL HENING
                    </span>
                    <h3 class="h4 fw-bold text-light mb-1">Hal-hal yang Menemani</h3>
                    <p class="text-secondary small mb-0">Perangkat, kebiasaan kecil, dan elemen yang menjaga kejernihan di tengah kesunyian malam.</p>
                </div>
                <div class="row g-3">
                    {{-- Item 1 --}}
                    <div class="col-sm-6">
                        <div class="card card-sunyi h-100 p-3 rounded-4 shadow-sm border border-secondary border-opacity-10">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-primary bg-opacity-10 text-primary mb-3" style="width: 44px; height: 44px;">
                                <i class="bi bi-terminal fs-5"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-light mb-2">Terminal &amp; Clean Architecture</h5>
                            <p class="text-secondary small mb-3">Pemujaan terhadap struktur data yang terukur, refactoring tanpa ampun, dan kode modular yang dapat bernapas dengan tenang.</p>
                            <div class="mt-auto">
                                <span class="font-code small text-secondary opacity-75">TypeScript • Go • Neovim</span>
                            </div>
                        </div>
                    </div>
                    {{-- Item 2 --}}
                    <div class="col-sm-6">
                        <div class="card card-sunyi h-100 p-3 rounded-4 shadow-sm border border-secondary border-opacity-10">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-warning bg-opacity-10 text-warning mb-3" style="width: 44px; height: 44px;">
                                <i class="bi bi-cup-hot-fill fs-5"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-light mb-2">Kopi Flores Seduh Manual</h5>
                            <p class="text-secondary small mb-3">Aroma manis cokelat dan acidity seimbang yang diseduh saat malam mulai tenang. Teman setia pembuka sesi coding &amp; renungan.</p>
                            <div class="mt-auto">
                                <span class="font-code small text-secondary opacity-75">V60 • 92°C • 1:15</span>
                            </div>
                        </div>
                    </div>
                    {{-- Item 3 --}}
                    <div class="col-sm-6">
                        <div class="card card-sunyi h-100 p-3 rounded-4 shadow-sm border border-secondary border-opacity-10">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-info bg-opacity-10 text-info mb-3" style="width: 44px; height: 44px;">
                                <i class="bi bi-book-half fs-5"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-light mb-2">Buku &amp; Arsitektur Sistem</h5>
                            <p class="text-secondary small mb-3">Eksplorasi buku perancangan sistem terdistribusi, filosofi eksistensialisme, dan lembaran esai yang selalu berlipat.</p>
                            <div class="mt-auto">
                                <span class="font-code small text-secondary opacity-75">System Design • Filsafat</span>
                            </div>
                        </div>
                    </div>
                    {{-- Item 4 --}}
                    <div class="col-sm-6">
                        <div class="card card-sunyi h-100 p-3 rounded-4 shadow-sm border border-secondary border-opacity-10">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-3 bg-success bg-opacity-10 text-success mb-3" style="width: 44px; height: 44px;">
                                <i class="bi bi-soundwave fs-5"></i>
                            </div>
                            <h5 class="h6 fw-semibold text-light mb-2">Alunan Ambient &amp; Hujan</h5>
                            <p class="text-secondary small mb-3">Gubahan nada drone lembut, piano minimalis, dan suara tetesan hujan malam. Menepis riuh luar demi konsentrasi penuh.</p>
                            <div class="mt-auto">
                                <span class="font-code small text-secondary opacity-75">Brian Eno • Stars of the Lid</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Guestbook / Digital Mail Contact Form --}}
            <section class="card card-sunyi rounded-4 p-4 shadow-sm border border-secondary border-opacity-10 mb-4 position-relative overflow-hidden">
                <div class="row g-4">
                    <div class="col-md-5">
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 font-code px-2 py-1 mb-2">
                            <i class="bi bi-envelope me-1"></i> KORESPONDENSI
                        </span>
                        <h4 class="h5 fw-bold text-light mb-2">Kirim Surat Digital</h4>
                        <p class="text-secondary small mb-3">
                            Punya tanggapan atas suatu catatan, refleksi yang seirama, atau sekadar ingin bertukar kabar tanpa kerumunan orang banyak? Tinggalkan pesan di sini.
                        </p>
                        <div class="small text-secondary d-flex align-items-center gap-2">
                            <i class="bi bi-shield-lock text-info"></i>
                            <span>Pesan ini hanya terbaca oleh saya secara privat.</span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <form id="quietNoteForm">
                            <div class="mb-3">
                                <label class="form-label small fw-medium text-light" for="senderName">
                                    Nama atau Panggilan <span class="text-secondary opacity-50 fw-normal">(opsional)</span>
                                </label>
                                <input class="form-control bg-dark border-secondary border-opacity-25 text-light" id="senderName" placeholder="Misal: Kawan dari seberang malam" type="text">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-medium text-light" for="senderMessage">
                                    Pesan dari Hati <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control bg-dark border-secondary border-opacity-25 text-light" id="senderMessage" placeholder="Tuliskan apa pun yang sedang bersemayam di pikiranmu..." rows="4" required></textarea>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-1">
                                <small class="text-secondary font-code">Hening &amp; santai.</small>
                                <button class="btn btn-primary btn-sm px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2" type="submit">
                                    <i class="bi bi-send-fill"></i> Kirim Catatan Tenang
                                </button>
                            </div>
                        </form>
                        {{-- Feedback confirmation --}}
                        <div class="d-none text-center p-4 bg-dark-subtle rounded-3 border border-light border-opacity-5" id="thankYouNote">
                            <div class="text-primary mb-2 fs-3"><i class="bi bi-check-circle-fill"></i></div>
                            <h6 class="text-light fw-semibold">Pesan Telah Dihantarkan</h6>
                            <p class="text-secondary small mb-0">Terima kasih telah berbagi ruang batin. Pesanmu tersimpan dengan aman dan akan saya baca di keheningan berikutnya.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Social Anchors & Jump Link --}}
            <div class="card card-sunyi-dark rounded-4 p-3 border border-secondary border-opacity-10 d-flex flex-row flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <a class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 hover-light" href="https://github.com" rel="noopener noreferrer" target="_blank">
                        <i class="bi bi-github"></i> GitHub
                    </a>
                    <a class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 hover-light" href="https://x.com" rel="noopener noreferrer" target="_blank">
                        <i class="bi bi-twitter-x"></i> Twitter / X
                    </a>
                    <a class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 hover-light" href="#">
                        <i class="bi bi-rss-fill"></i> RSS Catatan
                    </a>
                </div>
                <a class="btn btn-link text-primary text-decoration-none small p-0 fw-semibold d-inline-flex align-items-center gap-1" href="{{ route('linimasa.index') }}">
                    <span>Menuju Linimasa Publik</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </article>
    </div>
</div>
@endsection
