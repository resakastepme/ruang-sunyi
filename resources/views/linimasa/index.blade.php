@extends('layouts.app')

@section('title', 'Linimasa Publik - Ruang Sunyi')

@section('content')
<div class="container">
    {{-- Profile Header Banner --}}
    <section class="card bg-surface-card rounded-4 shadow-sm border-0 mb-4 position-relative overflow-hidden">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-8 d-flex flex-column flex-sm-row align-items-start gap-4">
                    <div class="position-relative flex-shrink-0">
                        <img src="https://lh3.googleusercontent.com/aida/AEtjO1WFvF7Iq6ZoyAsINeCigTQed_XObjbC-yV7L5hg8CJknfK-ZsqNV0QDBXsRZ2bVTQuBUuRbPtkI0czTvDAQ0MyBz2aIspqBYU12KcMDzt1iLfs8nKHG7MuI2Q5aXI670nXvSQCMIsUgh575RVamDeYyMzODedg3i61x8SpGhrIl4SfJFdh6sQaW0CIaFKAjBX3YdwMsUWQSxCm5BIRCnZqy1cl-hkWPN_GFZXQyTHByrCcuNP_dwYyJ04U"
                             alt="Resa Komara Akbari" class="rounded-circle object-fit-cover border border-2 border-primary border-opacity-50 shadow" width="80" height="80">
                        <span class="position-absolute bottom-0 end-0 p-1 bg-info border border-2 border-dark rounded-circle" title="Online late night"></span>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h1 class="h3 fw-bold mb-0 text-light">Resa Komara Akbari</h1>
                            <span class="badge badge-soft-info rounded-pill d-inline-flex align-items-center gap-1">
                                <i class="bi bi-patch-check-fill"></i> @@StepMe
                            </span>
                            <span class="badge bg-secondary bg-opacity-25 text-light rounded-pill">Penulis Tunggal</span>
                        </div>
                        <p class="text-secondary mb-2" style="font-size: 0.95rem;">
                            Fullstack Programmer &amp; Night Writer. Menulis apa yang berkeliaran di kepala saat larut malam. Jeda kontemplatif di sela bising kode dan dunia modern.
                        </p>
                        <div class="d-flex flex-wrap align-items-center gap-2 pt-1">
                            <span class="badge bg-dark border border-secondary border-opacity-25 text-light py-2 px-3 rounded-pill fw-normal">
                                <i class="bi bi-cloud-rain me-1 text-info"></i> Mendengarkan hujan &amp; merevisi naskah
                            </span>
                            <span class="badge badge-soft-secondary py-2 px-3 rounded-pill fw-normal">
                                🌙 Reflektif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 border-start-lg border-secondary border-opacity-10">
                    <div class="d-flex justify-content-around text-center py-2">
                        <div class="px-2">
                            <div class="h4 fw-bold mb-0 text-light">148</div>
                            <small class="text-uppercase text-muted fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.08em;">Catatan</small>
                        </div>
                        <div class="vr bg-secondary opacity-25"></div>
                        <div class="px-2">
                            <div class="h4 fw-bold mb-0" style="color: #c0c1ff !important;">1.2k</div>
                            <small class="text-uppercase text-muted fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.08em;">Pembaca</small>
                        </div>
                        <div class="vr bg-secondary opacity-25"></div>
                        <div class="px-2">
                            <div class="h4 fw-bold mb-0 text-info">23:40</div>
                            <small class="text-uppercase text-muted fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.08em;">Waktu Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Category Filter Pills --}}
    <div class="d-flex gap-2 overflow-x-auto pb-2 mb-4 scrollbar-none" id="filter-bar">
        <button class="btn btn-pill-filter active" data-category="all">Semua Curahan</button>
        <button class="btn btn-pill-filter" data-category="renungan">🌙 Renungan Malam</button>
        <button class="btn btn-pill-filter" data-category="kopi">☕ Keseharian &amp; Kopi</button>
        <button class="btn btn-pill-filter" data-category="catatan">✍️ Catatan Lepas</button>
        <button class="btn btn-pill-filter" data-category="buku">📖 Buku &amp; Ide</button>
    </div>

    {{-- Main Layout Grid --}}
    <div class="row g-4">
        {{-- Feed Column (Col 8) --}}
        <div class="col-lg-8">
            {{-- Post 1: Pinned --}}
            <article class="card bg-surface-card rounded-4 border-0 shadow-sm mb-4 position-relative overflow-hidden feed-entry" data-tags="renungan">
                <div class="pinned-accent-bar"></div>
                <div class="card-body p-4 pt-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge badge-soft-primary rounded-pill d-inline-flex align-items-center gap-1">
                                <i class="bi bi-pin-angle-fill"></i> Disematkan
                            </span>
                            <small class="text-muted">• 12 Maret 2025</small>
                            <small class="text-muted">• 1 mnt baca</small>
                        </div>
                        <span class="badge bg-transparent text-info font-mono-code">#Refleksi</span>
                    </div>
                    <h2 class="h4 fw-bold text-light mb-3">Tentang alasan membuat ruang sunyi ini...</h2>
                    <div class="font-editorial text-secondary mb-4">
                        <p class="mb-3">
                            Media sosial kontemporer menuntut kita untuk selalu reaktif, berpendapat cepat, dan mengonsumsi stimulasi tanpa jeda. Ruang ini lahir justru dari kelelahan itu—sebuah suaka kecil tempat pikiran tidak perlu dipoles untuk algoritma.
                        </p>
                        <div class="font-editorial-quote text-light p-3 my-3 rounded-3 border-start border-3 border-primary" style="background-color: rgba(99, 102, 241, 0.08);">
                            "Di dalam keheningan larut malam, kejujuran terhadap diri sendiri menemukan jalannya kembali."
                        </div>
                        <p class="mb-0">
                            Hanya catatan ringkas, sesekali foto jalan sepi, dan serpihan ide yang belum matang. Selamat datang, silakan merenung sejenak sebelum kembali melangkah.
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top border-secondary border-opacity-10 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-reaction d-flex align-items-center gap-1">
                                <span>❤️</span> <span class="font-mono-code">42</span>
                            </button>
                            <button class="btn btn-reaction d-flex align-items-center gap-1">
                                <span>☕</span> <span class="font-mono-code">19</span>
                            </button>
                            <button class="btn btn-reaction d-flex align-items-center gap-1">
                                <span>💭</span> <span class="font-mono-code">8</span>
                            </button>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary rounded-circle border-0 text-muted" title="Simpan catatan">
                                <i class="bi bi-bookmark fs-6"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary rounded-circle border-0 text-muted" title="Bagikan">
                                <i class="bi bi-share fs-6"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Post 2: Short Note --}}
            <article class="card bg-surface-card rounded-4 border-0 shadow-sm mb-4 feed-entry" data-tags="renungan">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted">2 jam yang lalu</small>
                            <small class="text-muted">•</small>
                            <small class="text-secondary">🌧️ Tenang</small>
                        </div>
                        <span class="badge bg-transparent text-secondary font-mono-code">#LarutMalam</span>
                    </div>
                    <div class="py-2">
                        <p class="fs-5 fw-medium text-light lh-base mb-0">
                            “Terkadang yang kita butuhkan bukan jawaban cepat, melainkan ruang sunyi untuk membiarkan pertanyaan selesai bernapas dengan sendirinya.”
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-3 mt-3 border-top border-secondary border-opacity-10">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-reaction d-flex align-items-center gap-1">
                                <span>✨</span> <span class="font-mono-code">27</span>
                            </button>
                            <button class="btn btn-reaction d-flex align-items-center gap-1">
                                <span>🌙</span> <span class="font-mono-code">35</span>
                            </button>
                        </div>
                        <small class="text-muted" style="font-size: 0.8rem;">Catatan spontan</small>
                    </div>
                </div>
            </article>

            {{-- Post 3: Editorial with Image --}}
            <article class="card bg-surface-card rounded-4 border-0 shadow-sm mb-4 feed-entry" data-tags="kopi">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted">Kemarin, 22:15</small>
                            <small class="text-muted">• 2 mnt baca</small>
                        </div>
                        <span class="badge bg-transparent text-info font-mono-code">#KopiDanJalan</span>
                    </div>
                    <h3 class="h4 fw-bold text-light mb-3">Sudut Kedai Pukul Sepuluh Malam</h3>
                    <div class="position-relative rounded-3 overflow-hidden my-3" style="max-height: 380px;">
                        <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuALkr_D9YLt8oI2IReqfDY9WT_zA5LlFly9ganWgp1f1NLbXVBRz-h1yYAdv1R3ugdD0x5o_BmyYaBMrXgnEXs_eFKUPbsysOYbxB-2fdW3HeopLCeGzALDpjEKUC6QiwcQoj3hRB9CGi-CcdO4e3iPPiBGBAvrua6-2q9calstZbsbAx4fcloMBq60DTtj89F-doA6lwMNco5AouC_IN9q6j78He3PKPGlYjPlisGzRFds4kVRykNDHA"
                             alt="Kedai Kopi Sepi" class="w-100 object-fit-cover" style="height: 320px;">
                        <div class="position-absolute bottom-0 start-0 m-3 px-3 py-1 rounded-pill bg-dark bg-opacity-75 backdrop-blur text-light small">
                            Kedai Sudut Barat, Jakarta
                        </div>
                    </div>
                    <div class="font-editorial text-secondary mb-4">
                        <p class="mb-3">
                            Berjalan kaki menembus rintik gerimis setelah menyelesaikan 800 kata pertama bab empat. Kedai langganan di pengkolan jalan hampir tutup, menyisakan barista yang sedang menyeka mesin espresso dan alunan lo-fi yang sayup.
                        </p>
                        <p class="mb-0">
                            Secangkir filter beans Flores Manggarai hangat, aroma rempah dan asam manis yang tertinggal di langit-langit lidah. Aneh bagaimana kelelahan fisik bisa terasa begitu damai ketika pikiran berhasil memuntahkan uneg-unegnya ke atas kertas.
                        </p>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top border-secondary border-opacity-10 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-reaction d-flex align-items-center gap-1">
                                <span>☕</span> <span class="font-mono-code">54</span>
                            </button>
                            <button class="btn btn-reaction d-flex align-items-center gap-1">
                                <span>❤️</span> <span class="font-mono-code">31</span>
                            </button>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary rounded-circle border-0 text-muted" title="Simpan catatan">
                                <i class="bi bi-bookmark fs-6"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary rounded-circle border-0 text-muted" title="Bagikan">
                                <i class="bi bi-share fs-6"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </article>

            {{-- Post 4: Tech Fragment --}}
            <article class="card bg-surface-card rounded-4 border-0 shadow-sm mb-4 feed-entry" data-tags="catatan buku">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted">3 hari yang lalu</small>
                            <small class="text-muted">• Fragmentasi</small>
                        </div>
                        <span class="badge bg-transparent text-secondary font-mono-code">#CatatanTeknis</span>
                    </div>
                    <p class="text-light mb-3">
                        Eksperimen menyusun arsip digital berbasis markdown sederhana: tidak perlu basis data raksasa jika yang kita butuhkan hanya kejernihan teks murni.
                    </p>
                    <div class="p-3 rounded-3 bg-surface-subtle-dark font-mono-code text-info small mb-3 border border-secondary border-opacity-10 overflow-x-auto">
                        <div class="text-muted">// index.nocturne: refleksi malam</div>
                        <div>const mood = "hening";</div>
                        <div>const pikiran = draft.filter(ide =&gt; ide.isHonest &amp;&amp; ide.lateNight);</div>
                        <div class="text-primary-emphasis">console.log(`Menyimpan ${pikiran.length} renungan ke arsip.`);</div>
                    </div>
                    <p class="text-secondary small mb-3">
                        Ketika teknologi disederhanakan, proses berpikir manusiawi justru mendapatkan kembali panggung utamanya.
                    </p>
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top border-secondary border-opacity-10">
                        <button class="btn btn-reaction d-flex align-items-center gap-1">
                            <span>💡</span> <span class="font-mono-code">18</span>
                        </button>
                        <small class="text-muted" style="font-size: 0.8rem;">Ide micro-arsip</small>
                    </div>
                </div>
            </article>

            <div class="py-4 text-center">
                <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.15em;">
                    — Akhir dari cuplikan linimasa minggu ini —
                </span>
            </div>
        </div>

        {{-- Sidebar Column (Col 4) --}}
        <div class="col-lg-4">
            <aside class="d-flex flex-column gap-4 sticky-top" style="top: 5rem; z-index: 10;">
                {{-- Widget: About Space --}}
                <div class="card bg-surface-card rounded-4 border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="https://lh3.googleusercontent.com/aida/AEtjO1WFvF7Iq6ZoyAsINeCigTQed_XObjbC-yV7L5hg8CJknfK-ZsqNV0QDBXsRZ2bVTQuBUuRbPtkI0czTvDAQ0MyBz2aIspqBYU12KcMDzt1iLfs8nKHG7MuI2Q5aXI670nXvSQCMIsUgh575RVamDeYyMzODedg3i61x8SpGhrIl4SfJFdh6sQaW0CIaFKAjBX3YdwMsUWQSxCm5BIRCnZqy1cl-hkWPN_GFZXQyTHByrCcuNP_dwYyJ04U"
                             alt="Resa Komara Akbari" class="rounded-circle object-fit-cover border border-primary border-opacity-50" width="48" height="48">
                        <div>
                            <h3 class="h6 fw-bold mb-0 text-light">Tentang Ruang Ini</h3>
                            <small class="text-muted">Catatan Mandiri</small>
                        </div>
                    </div>
                    <p class="text-secondary small mb-3">
                        Hanya pemilik ruang ini yang dapat menerbitkan tulisan. Publik dipersilakan membaca, menikmati keheningan, atau sekadar meninggalkan tanda bahwa Anda pernah singgah.
                    </p>
                    <div class="p-3 rounded-3 bg-dark-subtle border border-secondary border-opacity-10 d-flex align-items-start gap-2 text-info small">
                        <i class="bi bi-moon-stars mt-1"></i>
                        <span>Rerata jam rilis catatan berkisar antara pukul 22.00 hingga 02.30 WIB.</span>
                    </div>
                </div>

                {{-- Widget: Popular Topics --}}
                <div class="card bg-surface-card rounded-4 border-0 shadow-sm p-4">
                    <h4 class="h6 text-uppercase fw-bold text-light mb-3" style="letter-spacing: 0.05em; font-size: 0.8rem;">
                        Topik Populer
                    </h4>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#Refleksi (48)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#LarutMalam (36)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#KopiDanJalan (21)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#Buku (19)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#Keheningan (14)</span>
                        <span class="badge bg-dark border border-secondary border-opacity-25 text-secondary rounded-pill px-3 py-2 fw-normal" role="button">#CatatanLepas (10)</span>
                    </div>
                </div>

                {{-- Widget: Monthly Archives --}}
                <div class="card bg-surface-card rounded-4 border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="h6 text-uppercase fw-bold text-light mb-0" style="letter-spacing: 0.05em; font-size: 0.8rem;">
                            Arsip Bulan Ini
                        </h4>
                        <span class="badge badge-soft-info rounded-pill">Maret 2025</span>
                    </div>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary border-opacity-10 text-secondary" role="button">
                            <span>Minggu ke-2 (Saat Ini)</span>
                            <span class="font-mono-code fw-medium" style="color: #c0c1ff !important;">6 catatan</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary border-opacity-10 text-secondary" role="button">
                            <span>Minggu ke-1</span>
                            <span class="font-mono-code text-muted">12 catatan</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 text-secondary" role="button">
                            <span>Februari 2025</span>
                            <span class="font-mono-code text-muted">38 catatan</span>
                        </li>
                    </ul>
                </div>

                {{-- Widget: Anonymous Support --}}
                <div class="card bg-surface-card rounded-4 border-0 shadow-sm p-4">
                    <h4 class="h6 text-uppercase fw-bold text-light d-flex align-items-center gap-2 mb-2" style="letter-spacing: 0.05em; font-size: 0.8rem;">
                        <i class="bi bi-heart text-info"></i> Kirim Dukungan Hangat
                    </h4>
                    <p class="text-secondary small mb-3">
                        Meninggalkan jejak anonim untuk penulis tanpa perlu mendaftar akun:
                    </p>
                    <div class="d-flex flex-column gap-2">
                        <input type="text" class="form-control form-control-sm bg-dark border-secondary border-opacity-25 text-light" id="anon-input" placeholder="Tuliskan sepatah kata atau sapaan...">
                        <button type="button" class="btn btn-sm btn-primary rounded-3 d-flex align-items-center justify-content-center gap-2 fw-medium" id="send-salam-btn" style="background-color: #8083ff; border-color: #8083ff;">
                            <i class="bi bi-send-fill"></i> Kirimkan Salam
                        </button>
                        <div class="d-none text-center py-2 text-info small" id="salam-feedback">
                            ✨ Salam hangatmu telah terkirim ke meja penulis.
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
