<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TembakauGIS - Portal Pemetaan & Potensi Ekonomi UMKM Tembakau Pamekasan</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #334155;
            overflow-x: hidden;
        }

        /* Top Navbar */
        .home-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 0;
            transition: all 0.3s ease;
        }

        .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.35rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        /* Hero Banner */
        .hero-section {
            background: linear-gradient(135deg, #064e3b 0%, #065f46 45%, #0f172a 100%);
            padding: 5rem 0 7rem;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .hero-glow {
            position: absolute;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.28) 0%, rgba(0, 0, 0, 0) 70%);
            top: -100px;
            right: -100px;
            pointer-events: none;
        }

        /* Stat Cards */
        .stat-card-overlay {
            margin-top: -3.5rem;
            position: relative;
            z-index: 10;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.12);
        }

        .stat-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        /* Chart & Ranking Section */
        .analytics-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.04);
            padding: 1.75rem;
            height: 100%;
        }

        .ranking-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .umkm-preview-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .umkm-preview-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px -5px rgba(0, 0, 0, 0.1);
        }

        .umkm-preview-img {
            height: 180px;
            width: 100%;
            object-fit: cover;
        }

        /* Footer */
        .footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 3.5rem 0 1.5rem;
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
    <nav class="home-navbar sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2.5 text-decoration-none">
                <div class="brand-logo">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark fs-5 lh-1">TembakauGIS</div>
                    <small class="text-success fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.06em;">Kabupaten Pamekasan</small>
                </div>
            </a>

            <div class="d-flex align-items-center gap-3">
                <a href="#statistik" class="text-secondary text-decoration-none small fw-semibold d-none d-md-inline">
                    <i class="bi bi-bar-chart-line me-1"></i> Potensi Ekonomi
                </a>
                <a href="#kategori" class="text-secondary text-decoration-none small fw-semibold d-none d-md-inline">
                    <i class="bi bi-tags me-1"></i> Kategori Usaha
                </a>
                <a href="{{ route('peta') }}" class="btn btn-outline-success rounded-pill px-3.5 py-1.5 small fw-bold d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-map-fill"></i>
                    <span>Peta WebGIS</span>
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark rounded-pill px-3.5 py-1.5 small fw-bold">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-dark rounded-pill px-3.5 py-1.5 small fw-bold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="hero-glow"></div>
        <div class="container position-relative z-1">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="d-inline-flex align-items-center gap-2 bg-success bg-opacity-25 border border-success border-opacity-50 px-3.5 py-1.5 rounded-pill mb-3">
                        <i class="bi bi-shield-check text-success"></i>
                        <span class="small fw-semibold text-white">Sistem Informasi Geografis Komoditas Unggulan</span>
                    </div>

                    <h1 class="display-5 fw-extrabold text-white mb-3 lh-sm">
                        Pemetaan Spasial & Potensi Ekonomi <span class="text-warning">UMKM Tembakau</span> Pamekasan
                    </h1>

                    <p class="text-white-50 lead fs-6 mb-4 lh-base">
                        Eksplorasi persebaran industri hasil tembakau di Pulau Madura. Meliputi pabrik rokok kretek legal, sentra pengolahan rajangan tradisional, pergudangan sortasi grade, hingga serapan tenaga kerja lokal berbasis peta geospasial interaktif.
                    </p>

                    <!-- QUICK LINKS & CTA -->
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <a href="{{ route('peta') }}" class="btn btn-success btn-lg rounded-pill px-4 py-2.5 fw-bold shadow-lg d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt-fill fs-5"></i>
                            <span>Buka Peta Interaktif WebGIS</span>
                        </a>
                        <a href="#statistik" class="btn btn-outline-light btn-lg rounded-pill px-4 py-2.5 fw-semibold d-flex align-items-center gap-2">
                            <i class="bi bi-graph-up-arrow fs-5"></i>
                            <span>Lihat Analisis Statistik</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 text-center d-none d-lg-block">
                    <div class="position-relative">
                        <!-- Card Ilustrasi Peta -->
                        <div class="p-3 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-4 shadow-lg backdrop-blur">
                            <img src="{{ asset('storage/umkm/sentra_rajangan_pakong.jpg') }}" 
                                 alt="Perkebunan Tembakau Madura" 
                                 class="rounded-3 w-100 object-fit-cover shadow" 
                                 style="height: 290px;">
                            <div class="mt-3 text-start d-flex justify-content-between align-items-center text-white">
                                <div>
                                    <div class="fw-bold small">Komoditas Emas Hijau Madura</div>
                                    <small class="text-white-50">Sentra Tembakau Gunung & Sawah Kab. Pamekasan</small>
                                </div>
                                <span class="badge bg-warning text-dark font-monospace fw-bold">GIS Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4 RINGKASAN STATISTIK UTAMA -->
    <section class="stat-card-overlay">
        <div class="container">
            <div class="row g-3">
                <!-- 1. Total UMKM Terdata -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box bg-success-subtle text-success">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted small fw-semibold text-uppercase tracking-wider">Total UMKM Terdata</span>
                                <h3 class="fw-bold text-dark mb-0">{{ $totalUmkm }} <small class="fs-6 fw-normal text-muted">Unit</small></h3>
                            </div>
                        </div>
                        <div class="mt-2.5 pt-2.5 border-top d-flex justify-content-between align-items-center small">
                            <span class="text-muted">Titik Lokasi GIS</span>
                            <a href="{{ route('peta') }}" class="text-success text-decoration-none fw-semibold">Peta <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- 2. Total Kecamatan Terjangkau -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box bg-primary-subtle text-primary">
                                <i class="bi bi-map"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted small fw-semibold text-uppercase tracking-wider">Kecamatan Wilayah</span>
                                <h3 class="fw-bold text-dark mb-0">{{ $totalKecamatan }} <small class="fs-6 fw-normal text-muted">Kecamatan</small></h3>
                            </div>
                        </div>
                        <div class="mt-2.5 pt-2.5 border-top d-flex justify-content-between align-items-center small">
                            <span class="text-muted">Kab. Pamekasan</span>
                            <span class="badge bg-primary-subtle text-primary">100% Wilayah</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Total Tenaga Kerja Terserap -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box bg-warning-subtle text-warning">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted small fw-semibold text-uppercase tracking-wider">Serapan Tenaga Kerja</span>
                                <h3 class="fw-bold text-dark mb-0">{{ number_format($totalTenagaKerja) }} <small class="fs-6 fw-normal text-muted">Orang</small></h3>
                            </div>
                        </div>
                        <div class="mt-2.5 pt-2.5 border-top d-flex justify-content-between align-items-center small">
                            <span class="text-muted">Pekerja Lokal Terdata</span>
                            <span class="badge bg-success-subtle text-success">Pemberdayaan</span>
                        </div>
                    </div>
                </div>

                <!-- 4. Estimasi Total Kapasitas Produksi -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="stat-card h-100">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon-box bg-danger-subtle text-danger">
                                <i class="bi bi-speedometer2"></i>
                            </div>
                            <div class="overflow-hidden">
                                <span class="text-muted small fw-semibold text-uppercase tracking-wider">Kapasitas Produksi</span>
                                <h5 class="fw-bold text-dark mb-0 text-truncate" title="{{ $kapasitasSummary }}">{{ $kapasitasSummary }}</h5>
                            </div>
                        </div>
                        <div class="mt-2.5 pt-2.5 border-top d-flex justify-content-between align-items-center small">
                            <span class="text-muted">Produksi Olahan</span>
                            <span class="badge bg-danger-subtle text-danger">{{ $totalProduk }} Produk</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION DASHBOARD STATISTIK & POTENSI EKONOMI (CHART.JS & RANKING KECAMATAN) -->
    <section class="py-5 mt-4" id="statistik">
        <div class="container">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2">
                    <i class="bi bi-pie-chart-fill me-1"></i> Indikator Potensi Ekonomi
                </span>
                <h2 class="fw-bold text-dark">Konsentrasi & Sebaran Geospasial UMKM</h2>
                <p class="text-muted small mx-auto" style="max-width: 650px;">
                    Analisis data persebaran sentra industri tembakau, ranking kecamatan dengan konsentrasi usaha tertinggi, dan proporsi klasifikasi usaha di Pamekasan.
                </p>
            </div>

            <!-- ROW 1: Ranking Kecamatan & Doughnut Chart Kategori -->
            <div class="row g-4 mb-4">
                <!-- RANKING KECAMATAN TERINGGI -->
                <div class="col-lg-5">
                    <div class="analytics-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Ranking Wilayah Sentra</h5>
                                <p class="text-muted small mb-0">Konsentrasi UMKM tembakau tertinggi</p>
                            </div>
                            <span class="badge bg-warning text-dark fw-bold">Top Sentra</span>
                        </div>

                        <div class="list-group list-group-flush mt-2">
                            @php
                                $rankColors = ['bg-warning text-dark', 'bg-secondary text-white', 'bg-danger text-white', 'bg-success text-white', 'bg-primary text-white', 'bg-dark text-white'];
                            @endphp
                            @forelse($rankingKecamatan as $idx => $rk)
                                @php
                                    $percentage = $totalUmkm > 0 ? round(($rk->umkms_count / $totalUmkm) * 100) : 0;
                                @endphp
                                <div class="list-group-item px-0 py-3 border-bottom">
                                    <div class="d-flex align-items-center justify-content-between mb-1.5">
                                        <div class="d-flex align-items-center gap-2.5">
                                            <div class="ranking-badge {{ $rankColors[$idx] ?? 'bg-light text-dark' }}">
                                                #{{ $idx + 1 }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">Kecamatan {{ $rk->nama_kecamatan }}</div>
                                                <small class="text-muted">Kode: {{ $rk->kode_kecamatan ?? '-' }}</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="fw-bold text-success fs-6">{{ $rk->umkms_count }} UMKM</span>
                                            <div class="text-muted small">{{ $percentage }}% dari total</div>
                                        </div>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="progress" style="height: 6px; border-radius: 4px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">Belum ada data kecamatan.</div>
                            @endforelse
                        </div>

                        <div class="mt-3 pt-2 text-center">
                            <a href="{{ route('peta') }}" class="btn btn-outline-success btn-sm rounded-pill px-4 fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i> Tampilkan Seluruh Kecamatan di Peta
                            </a>
                        </div>
                    </div>
                </div>

                <!-- DOUGHNUT CHART DISTRIBUSI KATEGORI -->
                <div class="col-lg-7">
                    <div class="analytics-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Distribusi Berdasarkan Kategori Usaha</h5>
                                <p class="text-muted small mb-0">Klasifikasi jenis kegiatan usaha pertembakauan</p>
                            </div>
                            <span class="badge bg-primary-subtle text-primary fw-bold">Chart.js</span>
                        </div>

                        <div class="row align-items-center g-3 pt-2">
                            <div class="col-md-7">
                                <div style="position: relative; height: 260px;">
                                    <canvas id="categoryDoughnutChart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="p-3 bg-light rounded-3 small">
                                    <div class="fw-bold text-dark mb-2">Rincian Klasifikasi:</div>
                                    @foreach($kategoris as $k)
                                        <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom">
                                            <div class="text-truncate me-2" title="{{ $k->nama_kategori }}">
                                                <i class="bi {{ $k->ikon ?? 'bi-tags' }} me-1 text-primary"></i>
                                                {{ $k->nama_kategori }}
                                            </div>
                                            <strong>{{ $k->umkms_count }} Unit</strong>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ROW 2: Bar Chart Sebaran UMKM per Kecamatan -->
            <div class="row">
                <div class="col-12">
                    <div class="analytics-card">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Sebaran Jumlah UMKM per Kecamatan</h5>
                                <p class="text-muted small mb-0">Perbandingan jumlah entitas usaha tembakau antar kecamatan di Kab. Pamekasan</p>
                            </div>
                            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-semibold">
                                <i class="bi bi-graph-up me-1"></i>Visualisasi Spasial
                            </span>
                        </div>

                        <div style="position: relative; height: 320px;" class="mt-3">
                            <canvas id="kecamatanBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION SHOWCASE UMKM TERPILIH -->
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
                <div>
                    <span class="badge bg-warning-subtle text-dark px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2">
                        <i class="bi bi-stars me-1 text-warning"></i> Entitas Terdata
                    </span>
                    <h3 class="fw-bold text-dark mb-1">Highlight UMKM Tembakau Pamekasan</h3>
                    <p class="text-muted small mb-0">Unit usaha percontohan dengan sertifikasi dan titik koordinat spasial lengkap</p>
                </div>
                <a href="{{ route('peta') }}" class="btn btn-outline-dark rounded-pill px-4 btn-sm fw-semibold">
                    Jelajahi Semua di WebGIS <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-4">
                @forelse($featuredUmkms as $fUmkm)
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="umkm-preview-card">
                            <img src="{{ $fUmkm->foto_url }}" 
                                 alt="{{ $fUmkm->nama_umkm }}" 
                                 class="umkm-preview-img"
                                 onerror="this.src='{{ asset('storage/umkm/gudang_tembakau_proppo.jpg') }}'">
                            <div class="p-3.5 d-flex flex-column flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="badge bg-success-subtle text-success small">
                                        <i class="bi bi-geo-alt-fill me-1"></i>Kec. {{ $fUmkm->kecamatan->nama_kecamatan ?? '-' }}
                                    </span>
                                    <span class="badge bg-light text-muted border small">
                                        {{ $fUmkm->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </div>
                                <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $fUmkm->nama_umkm }}">
                                    {{ $fUmkm->nama_umkm }}
                                </h6>
                                <p class="text-muted small mb-2 text-truncate">
                                    <i class="bi bi-person me-1"></i>{{ $fUmkm->nama_pemilik ?? 'Belum ada pemilik' }}
                                </p>
                                <div class="bg-light p-2 rounded-3 small mb-3 mt-auto">
                                    <div class="text-muted" style="font-size: 0.75rem;">Kapasitas Produksi:</div>
                                    <div class="fw-bold text-dark text-truncate" title="{{ $fUmkm->kapasitas_produksi ?? 'Tidak terdata' }}">
                                        {{ $fUmkm->kapasitas_produksi ?? 'Tidak terdata' }}
                                    </div>
                                </div>
                                <a href="{{ route('umkm.detail', $fUmkm->id) }}" class="btn btn-dark btn-sm rounded-pill w-100 fw-semibold">
                                    <i class="bi bi-info-circle me-1"></i> Lihat Detail Profil
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4 text-muted">Belum ada data UMKM.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION KATEGORI USAHA TEMBAKAU -->
    <section class="py-5" id="kategori">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge bg-primary-subtle text-primary px-3 py-1.5 rounded-pill fw-bold text-uppercase mb-2">
                    <i class="bi bi-grid-fill me-1"></i> Klasifikasi Usaha
                </span>
                <h2 class="fw-bold text-dark">Kategori Bidang Usaha Pertembakauan</h2>
                <p class="text-muted small mx-auto" style="max-width: 600px;">
                    Rantai pasok industri tembakau Madura terbagi ke dalam beberapa sub-sektor utama pengolahan
                </p>
            </div>

            <div class="row g-4">
                @foreach($kategoris as $kat)
                    @php
                        $colorMeta = match(true) {
                            str_contains(strtolower($kat->nama_kategori), 'pabrik rokok') => ['bg' => 'bg-danger-subtle text-danger', 'border' => 'border-danger-subtle'],
                            str_contains(strtolower($kat->nama_kategori), 'rajangan') => ['bg' => 'bg-success-subtle text-success', 'border' => 'border-success-subtle'],
                            str_contains(strtolower($kat->nama_kategori), 'gudang') || str_contains(strtolower($kat->nama_kategori), 'pengepul') => ['bg' => 'bg-warning-subtle text-warning', 'border' => 'border-warning-subtle'],
                            str_contains(strtolower($kat->nama_kategori), 'bibit') || str_contains(strtolower($kat->nama_kategori), 'benih') => ['bg' => 'bg-primary-subtle text-primary', 'border' => 'border-primary-subtle'],
                            default => ['bg' => 'bg-info-subtle text-info', 'border' => 'border-info-subtle'],
                        };
                    @endphp
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="card h-100 border p-4 rounded-4 shadow-sm">
                            <div class="stat-icon-box {{ $colorMeta['bg'] }} mb-3">
                                <i class="bi {{ $kat->ikon ?? 'bi-tags' }}"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">{{ $kat->nama_kategori }}</h5>
                            <span class="badge bg-light text-dark border mb-3 align-self-start">{{ $kat->umkms_count }} UMKM Terdaftar</span>
                            <p class="text-muted small mb-0 lh-base">
                                {{ $kat->deskripsi ?? 'Kegiatan pengolahan dan distribusi komoditas tembakau di Kabupaten Pamekasan.' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-logo" style="width: 36px; height: 36px; font-size: 1.1rem;">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <span class="fw-bold text-white fs-5">TembakauGIS Pamekasan</span>
                    </div>
                    <p class="small text-muted lh-base mb-0">
                        Platform Sistem Informasi Geografis Terpadu untuk pemetaan, pendataan, dan analisis potensi ekonomi UMKM komoditas tembakau di wilayah Kabupaten Pamekasan, Madura, Jawa Timur.
                    </p>
                </div>

                <div class="col-lg-3 col-6">
                    <h6 class="text-white fw-bold mb-3">Navigasi Utama</h6>
                    <ul class="list-unstyled small mb-0">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda Publik</a></li>
                        <li class="mb-2"><a href="{{ route('peta') }}" class="text-muted text-decoration-none">Peta Interaktif WebGIS</a></li>
                        <li class="mb-2"><a href="#statistik" class="text-muted text-decoration-none">Indikator Ekonomi</a></li>
                        <li class="mb-2"><a href="#kategori" class="text-muted text-decoration-none">Kategori Usaha</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-6">
                    <h6 class="text-white fw-bold mb-3">Akses Administrator</h6>
                    <p class="small text-muted mb-3">
                        Kelola data master kecamatan, kategori usaha, entitas UMKM, titik koordinat, dan katalog produk.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-outline-success btn-sm rounded-pill px-3.5">
                        <i class="bi bi-shield-lock me-1"></i> Masuk Admin Portal
                    </a>
                </div>
            </div>

            <div class="border-top border-secondary border-opacity-25 pt-3 text-center small text-muted">
                &copy; {{ date('Y') }} <strong>TembakauGIS Kabupaten Pamekasan</strong>. Seluruh Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- INLINE CHART.JS INITIALIZATION SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data untuk Chart Kategori (Doughnut)
            const kategoriLabels = {!! json_encode($kategoris->pluck('nama_kategori')) !!};
            const kategoriCounts = {!! json_encode($kategoris->pluck('umkms_count')) !!};

            const categoryCtx = document.getElementById('categoryDoughnutChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: kategoriLabels,
                    datasets: [{
                        data: kategoriCounts,
                        backgroundColor: [
                            '#dc2626', // Merah (Pabrik Rokok)
                            '#16a34a', // Hijau (Rajangan)
                            '#d97706', // Kuning (Gudang)
                            '#2563eb', // Biru (Bibit)
                            '#7c3aed'  // Ungu (Lainnya)
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': ' + context.raw + ' UMKM';
                                }
                            }
                        }
                    },
                    cutout: '68%'
                }
            });

            // Data untuk Chart Sebaran Kecamatan (Bar Chart)
            const kecamatanLabels = {!! json_encode($kecamatanChartData->pluck('nama_kecamatan')) !!};
            const kecamatanCounts = {!! json_encode($kecamatanChartData->pluck('umkms_count')) !!};

            const kecamatanCtx = document.getElementById('kecamatanBarChart').getContext('2d');
            new Chart(kecamatanCtx, {
                type: 'bar',
                data: {
                    labels: kecamatanLabels,
                    datasets: [{
                        label: 'Jumlah UMKM Terdata',
                        data: kecamatanCounts,
                        backgroundColor: 'rgba(16, 185, 129, 0.85)',
                        borderColor: '#10b981',
                        borderWidth: 1.5,
                        borderRadius: 8,
                        hoverBackgroundColor: '#059669'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.raw + ' Unit UMKM Tembakau';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    family: 'Plus Jakarta Sans'
                                }
                            },
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    family: 'Plus Jakarta Sans',
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
