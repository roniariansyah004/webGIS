<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WebGIS Pemetaan UMKM Tembakau - Kabupaten Pamekasan</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #0f172a;
        }

        /* Top Navbar */
        .gis-navbar {
            height: 65px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1020;
            position: relative;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .gis-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .gis-brand .brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.3rem;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        }

        .gis-brand .brand-text {
            line-height: 1.2;
        }

        .gis-brand .brand-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .gis-brand .brand-subtitle {
            font-size: 0.72rem;
            color: #10b981;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Main Map Container */
        #map-container {
            height: calc(100vh - 65px);
            width: 100%;
            position: relative;
            z-index: 1;
        }

        #map {
            height: 100%;
            width: 100%;
        }

        /* Floating Filter Panel (Top-Left / Top) */
        .floating-filter-panel {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.8);
            padding: 1.25rem;
            width: 360px;
            max-width: calc(100vw - 40px);
            transition: all 0.3s ease;
        }

        /* Floating Legend Panel (Bottom-Right) */
        .floating-legend-panel {
            position: absolute;
            bottom: 25px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            border: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
            min-width: 260px;
            max-width: 320px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            font-size: 0.82rem;
            color: #334155;
            cursor: pointer;
            padding: 4px 6px;
            border-radius: 8px;
            transition: background 0.15s ease;
        }

        .legend-item:hover {
            background: #f1f5f9;
        }

        .legend-pin {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.75rem;
            flex-shrink: 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Custom Leaflet Marker Styling */
        .custom-gis-marker {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px !important;
            height: 36px !important;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border: 2.5px solid #ffffff;
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .custom-gis-marker:hover {
            transform: rotate(-45deg) scale(1.2);
            z-index: 9999 !important;
        }

        .custom-gis-marker i {
            transform: rotate(45deg);
            color: #ffffff;
            font-size: 15px;
        }

        /* Custom Leaflet Popup */
        .leaflet-popup-content-wrapper {
            padding: 0 !important;
            border-radius: 16px !important;
            overflow: hidden;
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.25) !important;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .leaflet-popup-content {
            margin: 0 !important;
            line-height: 1.4 !important;
            width: 290px !important;
        }

        .popup-header-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            position: relative;
        }

        .popup-body {
            padding: 1rem 1.15rem 1.15rem;
            background: #ffffff;
        }

        /* Basemap Toggle Control */
        .basemap-control {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            display: flex;
            overflow: hidden;
        }

        .basemap-btn {
            border: none;
            background: transparent;
            padding: 0.45rem 0.85rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .basemap-btn.active {
            background: #10b981;
            color: #ffffff;
        }

        /* Mobile tweaks */
        @media (max-width: 768px) {
            .floating-filter-panel {
                top: 10px;
                left: 10px;
                right: 10px;
                width: auto;
                padding: 1rem;
            }
            .floating-legend-panel {
                bottom: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
            .basemap-control {
                top: auto;
                bottom: 220px;
                right: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- TOP NAVBAR -->
    <header class="gis-navbar">
        <a href="{{ route('peta') }}" class="gis-brand">
            <div class="brand-logo">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <div class="brand-text">
                <div class="brand-title">TembakauGIS</div>
                <div class="brand-subtitle">Kabupaten Pamekasan</div>
            </div>
        </a>

        <div class="d-flex align-items-center gap-2">
            <!-- Counter Titik UMKM -->
            <div class="d-none d-md-flex align-items-center gap-2 bg-success-subtle text-success px-3 py-1.5 rounded-pill small fw-semibold">
                <i class="bi bi-geo-fill"></i>
                <span id="counter-badge">Memuat {{ $totalUmkm }} Titik UMKM...</span>
            </div>

            <!-- Tombol Login Admin / Dashboard -->
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark rounded-pill px-3.5 py-1.5 small fw-bold d-flex align-items-center gap-1.5">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard Admin</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-success rounded-pill px-3.5 py-1.5 small fw-bold d-flex align-items-center gap-1.5 shadow-sm">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login Admin</span>
                </a>
            @endauth
        </div>
    </header>

    <!-- MAP CONTAINER -->
    <main id="map-container">
        <!-- Floating Layer / Basemap Switcher -->
        <div class="basemap-control">
            <button type="button" class="basemap-btn active" id="btn-map-street">
                <i class="bi bi-map"></i> Peta Jalan
            </button>
            <button type="button" class="basemap-btn" id="btn-map-satellite">
                <i class="bi bi-globe-americas"></i> Satelit
            </button>
        </div>

        <!-- Floating Filter Toolbar -->
        <div class="floating-filter-panel">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-bold text-dark small text-uppercase tracking-wider">
                    <i class="bi bi-funnel-fill text-success me-1"></i>Filter Sebaran UMKM
                </span>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-link text-decoration-none text-muted p-0 small" id="btn-reset-filters">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                    <button type="button" class="btn btn-sm btn-light border p-0 px-1 text-muted d-md-none rounded" data-bs-toggle="collapse" data-bs-target="#filterContent" aria-expanded="true" title="Buka/Tutup Filter">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>

            <div class="collapse show" id="filterContent">
                <div class="row g-2">
                    <!-- Search Input UMKM & Produk -->
                    <div class="col-12">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="filter-search" class="form-control border-start-0 ps-0" placeholder="Cari nama UMKM atau produk olahan...">
                        </div>
                    </div>

                    <!-- Dropdown Kecamatan -->
                    <div class="col-6">
                        <select id="filter-kecamatan" class="form-select form-select-sm">
                            <option value="">Semua Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Kategori -->
                    <div class="col-6">
                        <select id="filter-kategori" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Legend Panel -->
        <div class="floating-legend-panel">
            <div class="fw-bold small text-dark mb-2 d-flex align-items-center justify-content-between" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#legendContent" aria-expanded="true">
                <span class="d-flex align-items-center gap-1">
                    <i class="bi bi-palette-fill me-1 text-primary"></i>Legenda Kategori
                    <i class="bi bi-chevron-down text-muted small ms-1"></i>
                </span>
                <span class="badge bg-light text-muted border" id="legend-total-badge">{{ $totalUmkm }} UMKM</span>
            </div>

            <div class="collapse show" id="legendContent">
                <div class="legend-list">
                    @foreach($kategoris as $kat)
                        @php
                            $meta = match(true) {
                                str_contains(strtolower($kat->nama_kategori), 'pabrik rokok') => ['color' => '#dc2626', 'icon' => 'bi-fire'],
                                str_contains(strtolower($kat->nama_kategori), 'rajangan') => ['color' => '#16a34a', 'icon' => 'bi-scissors'],
                                str_contains(strtolower($kat->nama_kategori), 'gudang') || str_contains(strtolower($kat->nama_kategori), 'pengepul') => ['color' => '#d97706', 'icon' => 'bi-boxes'],
                                str_contains(strtolower($kat->nama_kategori), 'bibit') || str_contains(strtolower($kat->nama_kategori), 'benih') => ['color' => '#2563eb', 'icon' => 'bi-flower1'],
                                default => ['color' => '#7c3aed', 'icon' => 'bi-geo-alt-fill'],
                            };
                        @endphp
                        <div class="legend-item" onclick="filterByKategori('{{ $kat->id }}')">
                            <div class="legend-pin" style="background-color: {{ $meta['color'] }};">
                                <i class="bi {{ $meta['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1 text-truncate" title="{{ $kat->nama_kategori }}">
                                {{ $kat->nama_kategori }}
                            </div>
                            <span class="badge bg-light text-secondary border small">{{ $kat->umkms_count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- LEAFLET MAP ELEMENT -->
        <div id="map"></div>
    </main>

    <!-- MODAL DETAIL UMKM LENGKAP -->
    <div class="modal fade" id="modalDetailUmkm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <span class="badge bg-primary-subtle text-primary mb-1" id="m-kategori">Kategori</span>
                        <h4 class="modal-title fw-bold text-dark" id="m-nama">Nama UMKM</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Foto & Info Kontak -->
                        <div class="col-md-5">
                            <img id="m-foto" src="" alt="Foto UMKM" class="w-100 rounded-3 shadow-sm border object-fit-cover mb-3" style="height: 200px;">
                            
                            <ul class="list-group list-group-flush small">
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-person me-1"></i>Pemilik:</span>
                                    <strong id="m-pemilik">-</strong>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-geo-alt me-1"></i>Kecamatan:</span>
                                    <strong id="m-kecamatan">-</strong>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-calendar3 me-1"></i>Tahun Berdiri:</span>
                                    <strong id="m-tahun">-</strong>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-speedometer2 me-1"></i>Kapasitas:</span>
                                    <strong id="m-kapasitas" class="text-success text-end">-</strong>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-people me-1"></i>Tenaga Kerja:</span>
                                    <strong id="m-pekerja">-</strong>
                                </li>
                            </ul>

                            <div class="mt-3 d-grid gap-2">
                                <a id="m-detail-page-btn" href="#" class="btn btn-dark btn-sm rounded-pill fw-bold">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Lengkap UMKM
                                </a>
                                <a id="m-rute-btn" href="#" target="_blank" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold">
                                    <i class="bi bi-sign-turn-right-fill me-1"></i> Buka Rute Google Maps
                                </a>
                                <a id="m-wa-btn" href="#" target="_blank" class="btn btn-success btn-sm rounded-pill fw-semibold">
                                    <i class="bi bi-whatsapp me-1"></i> Hubungi Pemilik
                                </a>
                            </div>
                        </div>

                        <!-- Deskripsi & Produk Olahan -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <h6 class="fw-bold text-dark"><i class="bi bi-card-text me-1 text-primary"></i>Profil Usaha</h6>
                                <p class="text-muted small mb-0" id="m-deskripsi">-</p>
                            </div>

                            <div class="mb-3">
                                <h6 class="fw-bold text-dark"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>Alamat Lengkap</h6>
                                <p class="text-muted small mb-0" id="m-alamat">-</p>
                            </div>

                            <hr class="my-3">

                            <div>
                                <h6 class="fw-bold text-dark mb-2.5">
                                    <i class="bi bi-box-seam me-1 text-warning"></i>Katalog Produk Olahan (<span id="m-produk-count">0</span>)
                                </h6>
                                <div class="row g-2" id="m-produk-container">
                                    <!-- Rendered via JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Leaflet.js -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- WebGIS Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Inisialisasi Peta Leaflet berpusat di Kabupaten Pamekasan
            const PAMEKASAN_CENTER = [-7.1593, 113.4739];
            const DEFAULT_ZOOM = 12;

            const map = L.map('map', {
                center: PAMEKASAN_CENTER,
                zoom: DEFAULT_ZOOM,
                zoomControl: false // Kita pindahkan kontrol zoom
            });

            // Posisi tombol zoom di kanan bawah
            L.control.zoom({ position: 'bottomright' }).addTo(map);

            // Layer Peta (Basemaps)
            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 18,
                attribution: '&copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
            });

            // Toggle Basemap
            const btnStreet = document.getElementById('btn-map-street');
            const btnSat = document.getElementById('btn-map-satellite');

            btnStreet.addEventListener('click', function () {
                map.removeLayer(satelliteLayer);
                map.addLayer(osmLayer);
                btnStreet.classList.add('active');
                btnSat.classList.remove('active');
            });

            btnSat.addEventListener('click', function () {
                map.removeLayer(osmLayer);
                map.addLayer(satelliteLayer);
                btnSat.classList.add('active');
                btnStreet.classList.remove('active');
            });

            // Layer Group untuk Marker Dinamis
            const markerLayerGroup = L.layerGroup().addTo(map);

            // Simpan data UMKM secara global di JavaScript
            let allUmkmData = [];

            // 2. Fetch Data dari API Endpoint /api/umkm-locations
            function fetchUmkmLocations() {
                const search = document.getElementById('filter-search').value;
                const kecamatanId = document.getElementById('filter-kecamatan').value;
                const kategoriId = document.getElementById('filter-kategori').value;

                let url = new URL('/api/umkm-locations', window.location.origin);
                if (search) url.searchParams.append('search', search);
                if (kecamatanId) url.searchParams.append('kecamatan_id', kecamatanId);
                if (kategoriId) url.searchParams.append('kategori_id', kategoriId);

                fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if (res.status === 'success') {
                            allUmkmData = res.data;
                            renderMarkers(allUmkmData);
                            document.getElementById('counter-badge').textContent = `${allUmkmData.length} Titik UMKM Aktif`;
                            document.getElementById('legend-total-badge').textContent = `${allUmkmData.length} UMKM`;
                        }
                    })
                    .catch(err => {
                        console.error('Gagal mengambil data UMKM:', err);
                    });
            }

            // 3. Render Marker Dinamis dengan Custom Icon & Pop-up
            function renderMarkers(data) {
                markerLayerGroup.clearLayers();

                if (data.length === 0) return;

                const bounds = [];

                data.forEach(item => {
                    const lat = item.latitude;
                    const lng = item.longitude;

                    if (!lat || !lng) return;

                    bounds.push([lat, lng]);

                    // Buat Custom DivIcon dengan warna dan ikon kategori
                    const customIcon = L.divIcon({
                        className: 'custom-gis-pin-container',
                        html: `
                            <div class="custom-gis-marker" style="background-color: ${item.marker.color};">
                                <i class="bi ${item.marker.icon}"></i>
                            </div>
                        `,
                        iconSize: [36, 36],
                        iconAnchor: [18, 36],
                        popupAnchor: [0, -36]
                    });

                    // Konten Pop-up Marker
                    const popupContent = `
                        <div class="popup-wrapper">
                            <img src="${item.foto_url}" class="popup-header-img" alt="${item.nama_umkm}">
                            <div class="popup-body">
                                <div class="d-flex align-items-center justify-content-between mb-1.5">
                                    <span class="badge" style="background-color: ${item.marker.color}; font-size: 0.7rem;">
                                        <i class="bi ${item.marker.icon} me-1"></i>${item.kategori.nama_kategori}
                                    </span>
                                    <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">
                                        ${item.kecamatan.nama_kecamatan}
                                    </span>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">${item.nama_umkm}</h6>
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-person me-1"></i>${item.nama_pemilik}
                                </div>
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-speedometer2 me-1 text-success"></i>Kapasitas: <strong>${item.kapasitas_produksi}</strong>
                                </div>
                                <div class="text-muted small mb-2.5">
                                    <i class="bi bi-people me-1 text-primary"></i>Pekerja: <strong>${item.jumlah_pekerja}</strong>
                                </div>
                                <div class="d-flex gap-1.5">
                                    <a href="${item.detail_url}" class="btn btn-success btn-sm w-50 rounded-pill py-1.5 fw-bold text-center text-decoration-none">
                                        <i class="bi bi-box-arrow-up-right me-1"></i> Detail
                                    </a>
                                    <button type="button" class="btn btn-dark btn-sm w-50 rounded-pill py-1.5 fw-semibold" onclick="openDetailModal(${item.id})">
                                        <i class="bi bi-eye me-1"></i> Quick View
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                    const marker = L.marker([lat, lng], { icon: customIcon })
                        .bindPopup(popupContent, { maxWidth: 300 });

                    markerLayerGroup.addLayer(marker);
                });

                // Auto-fit peta jika filter diterapkan
                if (bounds.length > 0) {
                    map.fitBounds(bounds, { padding: [60, 60], maxZoom: 15 });
                }
            }

            // Fungsi Buka Modal Detail UMKM
            window.openDetailModal = function (umkmId) {
                const item = allUmkmData.find(u => u.id === umkmId);
                if (!item) return;

                document.getElementById('m-nama').textContent = item.nama_umkm;
                document.getElementById('m-kategori').textContent = item.kategori.nama_kategori;
                document.getElementById('m-pemilik').textContent = item.nama_pemilik;
                document.getElementById('m-kecamatan').textContent = item.kecamatan.nama_kecamatan;
                document.getElementById('m-tahun').textContent = item.tahun_berdiri || '-';
                document.getElementById('m-kapasitas').textContent = item.kapasitas_produksi;
                document.getElementById('m-pekerja').textContent = item.jumlah_pekerja;
                document.getElementById('m-deskripsi').textContent = item.deskripsi;
                document.getElementById('m-alamat').textContent = item.alamat;
                document.getElementById('m-foto').src = item.foto_url;

                // Tombol Halaman Lengkap
                document.getElementById('m-detail-page-btn').href = item.detail_url;

                // Tombol Rute Maps
                document.getElementById('m-rute-btn').href = `https://www.google.com/maps?q=${item.latitude},${item.longitude}`;

                // Tombol WhatsApp
                const cleanPhone = item.no_telepon ? item.no_telepon.replace(/\D/g, '') : '';
                const waPhone = cleanPhone.startsWith('0') ? '62' + cleanPhone.slice(1) : cleanPhone;
                document.getElementById('m-wa-btn').href = `https://wa.me/${waPhone}?text=Halo%20${encodeURIComponent(item.nama_umkm)},%20saya%20menemukan%20usaha%20Anda%20melalui%20WebGIS%20Tembakau%20Pamekasan.`;

                // Render Katalog Produk
                const prodContainer = document.getElementById('m-produk-container');
                prodContainer.innerHTML = '';
                document.getElementById('m-produk-count').textContent = item.produks.length;

                if (item.produks.length === 0) {
                    prodContainer.innerHTML = '<div class="col-12 text-muted small py-2">Belum ada produk olahan yang didaftarkan untuk UMKM ini.</div>';
                } else {
                    item.produks.forEach(p => {
                        prodContainer.innerHTML += `
                            <div class="col-12 col-sm-6">
                                <div class="card border p-2 rounded-3 h-100">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="${p.foto_url}" class="rounded-2 border object-fit-cover" style="width: 48px; height: 48px;" alt="${p.nama_produk}">
                                        <div class="overflow-hidden">
                                            <div class="fw-bold text-dark small text-truncate" title="${p.nama_produk}">${p.nama_produk}</div>
                                            <div class="text-success fw-bold small">${p.harga_formatted}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }

                // Tampilkan Bootstrap Modal
                const modalEl = document.getElementById('modalDetailUmkm');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            };

            // Filter Event Listeners
            let debounceTimer;
            document.getElementById('filter-search').addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(fetchUmkmLocations, 350);
            });

            document.getElementById('filter-kecamatan').addEventListener('change', fetchUmkmLocations);
            document.getElementById('filter-kategori').addEventListener('change', fetchUmkmLocations);

            // Reset Filter
            document.getElementById('btn-reset-filters').addEventListener('click', function () {
                document.getElementById('filter-search').value = '';
                document.getElementById('filter-kecamatan').value = '';
                document.getElementById('filter-kategori').value = '';
                fetchUmkmLocations();
                map.setView(PAMEKASAN_CENTER, DEFAULT_ZOOM);
            });

            // Klik item legenda untuk filter cepat
            window.filterByKategori = function (kategoriId) {
                document.getElementById('filter-kategori').value = kategoriId;
                fetchUmkmLocations();
            };

            // Muat data awal saat halaman selesai render
            fetchUmkmLocations();
        });
    </script>
</body>
</html>
