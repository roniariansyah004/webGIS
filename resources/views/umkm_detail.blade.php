<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $umkm->nama_umkm }} - Detail Profil UMKM Tembakau Pamekasan</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Leaflet.js CSS for Mini Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .gis-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.2rem;
        }

        .hero-banner {
            background: linear-gradient(135deg, #092e1e 0%, #0f172a 100%);
            padding: 3rem 0;
            color: #ffffff;
            position: relative;
        }

        #mini-map {
            height: 280px;
            width: 100%;
            border-radius: 14px;
            z-index: 1;
        }

        .card-profile {
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .product-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
            background: #ffffff;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        }

        .product-img {
            height: 170px;
            width: 100%;
            object-fit: cover;
        }

        .info-pill {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-pill .pill-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .footer {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 1.5rem 0;
            color: #64748b;
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
    <header class="gis-navbar sticky-top">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('peta') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <div class="brand-logo">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div>
                    <div class="fw-bold text-dark lh-1">TembakauGIS</div>
                    <small class="text-success fw-bold text-uppercase" style="font-size: 0.68rem; letter-spacing: 0.05em;">Kabupaten Pamekasan</small>
                </div>
            </a>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('peta') }}" class="btn btn-outline-secondary rounded-pill btn-sm px-3 fw-semibold">
                    <i class="bi bi-map me-1"></i> Kembali ke Peta Publik
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark rounded-pill btn-sm px-3 fw-semibold">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-success rounded-pill btn-sm px-3 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO HEADER -->
    <div class="hero-banner">
        <div class="container">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('peta') }}" class="text-white-50 text-decoration-none">Peta WebGIS</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('peta') }}?kecamatan_id={{ $umkm->kecamatan_id }}" class="text-white-50 text-decoration-none">Kec. {{ $umkm->kecamatan->nama_kecamatan ?? '-' }}</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $umkm->nama_umkm }}</li>
                </ol>
            </nav>

            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold">
                            <i class="bi {{ $umkm->kategori->ikon ?? 'bi-tags' }} me-1"></i>{{ $umkm->kategori->nama_kategori ?? 'UMKM' }}
                        </span>
                        <span class="badge bg-white text-dark px-3 py-1.5 rounded-pill fw-semibold">
                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>Kec. {{ $umkm->kecamatan->nama_kecamatan ?? '-' }}
                        </span>
                    </div>
                    <h1 class="fw-bold mb-2 text-white">{{ $umkm->nama_umkm }}</h1>
                    <p class="text-white-50 lead mb-0 fs-6">
                        <i class="bi bi-person-circle me-1 text-white"></i> Pemilik: <strong>{{ $umkm->nama_pemilik ?? 'Belum ada data' }}</strong>
                        @if($umkm->tahun_berdiri)
                            &bull; Berdiri sejak tahun {{ $umkm->tahun_berdiri }}
                        @endif
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    @php
                        $cleanPhone = $umkm->no_telepon ? preg_replace('/\D/', '', $umkm->no_telepon) : '';
                        $waPhone = str_starts_with($cleanPhone, '0') ? '62' . substr($cleanPhone, 1) : $cleanPhone;
                    @endphp
                    @if($waPhone)
                        <a href="https://wa.me/{{ $waPhone }}?text=Halo%20{{ urlencode($umkm->nama_umkm) }},%20saya%20tertarik%20dengan%20produk%20dan%20profil%20usaha%20Anda%20melalui%20TembakauGIS%20Pamekasan." 
                           target="_blank" 
                           class="btn btn-success btn-lg rounded-pill px-4 shadow-sm fw-bold">
                            <i class="bi bi-whatsapp me-2 fs-5"></i> Hubungi WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN BODY CONTENT -->
    <main class="container my-5">
        <div class="row g-4">
            <!-- Kolom Kiri: Profil, Alamat & Mini-Map -->
            <div class="col-lg-7">
                <!-- Card Profil Utama -->
                <div class="card card-profile p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-building me-2 text-primary"></i>Profil & Deskripsi Usaha</h5>
                    
                    <p class="text-muted lh-base mb-4">
                        {{ $umkm->deskripsi ?? 'Belum ada deskripsi profil untuk unit UMKM ini.' }}
                    </p>

                    <!-- 4 Kartu Info Pokok (Kapasitas, Pekerja, Tahun, Telepon) -->
                    <div class="row g-3">
                        <!-- 1. Kapasitas Produksi -->
                        <div class="col-sm-6">
                            <div class="info-pill">
                                <div class="pill-icon bg-success-subtle text-success">
                                    <i class="bi bi-speedometer2"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="text-muted small">Kapasitas Produksi</div>
                                    <div class="fw-bold text-dark text-truncate" title="{{ $umkm->kapasitas_produksi ?? 'Tidak terdata' }}">
                                        {{ $umkm->kapasitas_produksi ?? 'Tidak terdata' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Jumlah Tenaga Kerja / Pekerja -->
                        <div class="col-sm-6">
                            <div class="info-pill">
                                <div class="pill-icon bg-primary-subtle text-primary">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="text-muted small">Jumlah Pekerja</div>
                                    <div class="fw-bold text-dark">
                                        {{ $umkm->jumlah_pekerja ? $umkm->jumlah_pekerja . ' Tenaga Kerja' : 'Belum terdata' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Nomor Telepon / Kontak -->
                        <div class="col-sm-6">
                            <div class="info-pill">
                                <div class="pill-icon bg-warning-subtle text-warning">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="text-muted small">Kontak Telepon</div>
                                    <div class="fw-bold text-dark text-truncate">
                                        {{ $umkm->no_telepon ?? 'Belum terdata' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Wilayah Kecamatan -->
                        <div class="col-sm-6">
                            <div class="info-pill">
                                <div class="pill-icon bg-danger-subtle text-danger">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="text-muted small">Kecamatan Wilayah</div>
                                    <div class="fw-bold text-dark">
                                        Kec. {{ $umkm->kecamatan->nama_kecamatan ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Alamat & Titik Lokasi Mini-Map -->
                <div class="card card-profile p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold text-dark mb-1"><i class="bi bi-map-fill me-2 text-danger"></i>Lokasi Geografis Titik UMKM</h5>
                            <p class="text-muted small mb-0">Koordinat lintang & bujur pemetaan spasial sistem GIS</p>
                        </div>
                        <a href="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}" 
                           target="_blank" 
                           class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Rute Maps
                        </a>
                    </div>

                    <div class="mb-3 text-muted small">
                        <i class="bi bi-geo me-1 text-danger"></i> <strong>Alamat:</strong> {{ $umkm->alamat ?? 'Wilayah Kab. Pamekasan, Jawa Timur' }}
                    </div>

                    <!-- Mini Map Element -->
                    <div id="mini-map" class="border shadow-sm mb-3"></div>

                    <div class="d-flex justify-content-between align-items-center bg-light p-2.5 rounded-3 font-monospace small text-muted">
                        <span><i class="bi bi-compass me-1"></i>Latitude: <strong>{{ number_format($umkm->latitude, 6) }}</strong></span>
                        <span>Longitude: <strong>{{ number_format($umkm->longitude, 6) }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Foto Profil & Grid Katalog Produk -->
            <div class="col-lg-5">
                <!-- Foto Tempat Usaha -->
                <div class="card card-profile overflow-hidden mb-4 p-0">
                    <img src="{{ $umkm->foto_url }}" 
                         alt="{{ $umkm->nama_umkm }}" 
                         class="w-100 object-fit-cover" 
                         style="height: 260px;"
                         onerror="this.src='{{ asset('storage/umkm/gudang_tembakau_proppo.jpg') }}'">
                    <div class="p-3 text-center bg-white border-top">
                        <small class="text-muted fw-semibold">Dokumentasi Tempat Usaha / Fasilitas UMKM</small>
                    </div>
                </div>

                <!-- Grid / Card Daftar Produk yang Dijual -->
                <div class="card card-profile p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-box-seam me-2 text-warning"></i>Katalog Produk
                        </h5>
                        <span class="badge bg-warning-subtle text-dark fw-bold">
                            {{ $umkm->produks->count() }} Produk
                        </span>
                    </div>

                    <div class="row g-3">
                        @forelse($umkm->produks as $produk)
                            <div class="col-12">
                                <div class="product-card p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ $produk->foto_url }}" 
                                             alt="{{ $produk->nama_produk }}" 
                                             class="rounded-3 border object-fit-cover" 
                                             style="width: 80px; height: 80px;"
                                             onerror="this.src='{{ asset('storage/produk/tembakau_rajangan_super.jpg') }}'">
                                        <div class="overflow-hidden flex-grow-1">
                                            <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                                <h6 class="fw-bold text-dark mb-0 text-truncate" title="{{ $produk->nama_produk }}">
                                                    {{ $produk->nama_produk }}
                                                </h6>
                                                @if($produk->stok_status == 'Tersedia')
                                                    <span class="badge bg-success-subtle text-success small">Tersedia</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning small">{{ $produk->stok_status }}</span>
                                                @endif
                                            </div>
                                            <div class="text-success fw-bold fs-6 mb-1">
                                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                            </div>
                                            <p class="text-muted small mb-0 text-truncate" title="{{ $produk->deskripsi }}">
                                                {{ $produk->deskripsi ?? 'Produk tembakau olahan berkualitas.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-1 text-secondary opacity-50"></i>
                                Belum ada data produk untuk UMKM ini.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Rekomendasi UMKM Terkait di Kecamatan yang Sama -->
                @if($relatedUmkms->count() > 0)
                    <div class="card card-profile p-4 mt-4">
                        <h6 class="fw-bold text-dark mb-3">UMKM Terdekat di Kec. {{ $umkm->kecamatan->nama_kecamatan }}</h6>
                        <div class="list-group list-group-flush">
                            @foreach($relatedUmkms as $rel)
                                <a href="{{ route('umkm.detail', $rel->id) }}" class="list-group-item list-group-item-action px-0 py-2 d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="fw-bold text-dark small">{{ $rel->nama_umkm }}</div>
                                        <small class="text-muted">{{ $rel->kategori->nama_kategori ?? '-' }}</small>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted small"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-1 fw-bold text-dark">&copy; {{ date('Y') }} TembakauGIS Kabupaten Pamekasan</p>
            <small class="text-muted">Sistem Informasi Geografis Pemetaan Komoditas & Sentra UMKM Tembakau Madura</small>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet.js JS for Mini Map -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = {{ $umkm->latitude }};
            const lng = {{ $umkm->longitude }};

            // Inisialisasi Mini Map
            const miniMap = L.map('mini-map', {
                center: [lat, lng],
                zoom: 14,
                scrollWheelZoom: false
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(miniMap);

            // Custom Pin Marker
            const markerColor = "{{ str_contains(strtolower($umkm->kategori->nama_kategori ?? ''), 'pabrik') ? '#dc2626' : (str_contains(strtolower($umkm->kategori->nama_kategori ?? ''), 'rajangan') ? '#16a34a' : (str_contains(strtolower($umkm->kategori->nama_kategori ?? ''), 'gudang') ? '#d97706' : '#2563eb')) }}";

            const pinIcon = L.divIcon({
                className: 'mini-map-pin',
                html: `
                    <div style="
                        width: 34px; 
                        height: 34px; 
                        background-color: ${markerColor}; 
                        border: 2px solid #fff; 
                        border-radius: 50% 50% 50% 0; 
                        transform: rotate(-45deg); 
                        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                        <i class="bi bi-geo-alt-fill text-white" style="transform: rotate(45deg); font-size: 14px;"></i>
                    </div>
                `,
                iconSize: [34, 34],
                iconAnchor: [17, 34],
                popupAnchor: [0, -34]
            });

            const marker = L.marker([lat, lng], { icon: pinIcon }).addTo(miniMap);
            marker.bindPopup(`
                <div class="p-2 text-center">
                    <strong class="d-block text-dark">${"{{ addslashes($umkm->nama_umkm) }}"}</strong>
                    <small class="text-muted">${"{{ addslashes($umkm->alamat ?? 'Pamekasan') }}"}</small>
                </div>
            `).openPopup();
        });
    </script>
</body>
</html>
