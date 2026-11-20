@extends('layouts.admin')

@section('title', 'Dashboard Statistik')
@section('page-title', 'Dashboard Statistik')

@section('content')
<div class="container-fluid p-0">

    <!-- Welcome Banner -->
    <div class="card border-0 rounded-4 overflow-hidden mb-4 shadow-sm" style="background: linear-gradient(135deg, #064e3b 0%, #065f46 60%, #047857 100%);">
        <div class="card-body p-4 text-white position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-success px-3 py-1.5 rounded-pill fw-bold mb-2 small">
                        <i class="bi bi-shield-check me-1"></i> Admin Portal
                    </span>
                    <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}! 👋</h3>
                    <p class="text-white-50 mb-0">
                        Sistem Informasi Geografis Pemetaan dan Potensi UMKM Tembakau di Wilayah Kabupaten Pamekasan.
                    </p>
                </div>
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <i class="bi bi-geo-alt-fill text-white-50" style="font-size: 5rem; opacity: 0.25;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 KARTU STATISTIK UTAMA -->
    <div class="row g-3 mb-4">
        <!-- 1. Total UMKM -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted fw-semibold small">Total UMKM Terdata</span>
                        <div class="rounded-3 p-2 bg-success-subtle text-success">
                            <i class="bi bi-shop fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $totalUmkm ?? 0 }}</h3>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted small">Titik Lokasi GIS</span>
                        <a href="{{ route('admin.umkm.index') }}" class="text-success text-decoration-none small fw-semibold">
                            Kelola <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Wilayah Kecamatan -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted fw-semibold small">Wilayah Kecamatan</span>
                        <div class="rounded-3 p-2 bg-primary-subtle text-primary">
                            <i class="bi bi-map fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $totalKecamatan ?? 13 }}</h3>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted small">Kab. Pamekasan</span>
                        <a href="{{ route('admin.kecamatan.index') }}" class="text-primary text-decoration-none small fw-semibold">
                            Kelola <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Serapan Tenaga Kerja -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted fw-semibold small">Serapan Tenaga Kerja</span>
                        <div class="rounded-3 p-2 bg-warning-subtle text-warning">
                            <i class="bi bi-people-fill fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ number_format($totalTenagaKerja ?? 0) }}</h3>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted small">Pekerja Lokal</span>
                        <span class="badge bg-warning-subtle text-dark">Indikator Ekonomi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Total Produk -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card h-100 border-0 shadow-sm rounded-4">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted fw-semibold small">Katalog Produk</span>
                        <div class="rounded-3 p-2 bg-danger-subtle text-danger">
                            <i class="bi bi-box-seam fs-5"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">{{ $totalProduk ?? 0 }}</h3>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted small">Varian Olahan</span>
                        <a href="{{ route('admin.produk.index') }}" class="text-danger text-decoration-none small fw-semibold">
                            Kelola <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ANALISIS POTENSI EKONOMI & VISUALISASI CHART.JS -->
    <div class="row g-4 mb-4">
        <!-- 1. Bar Chart Sebaran Kecamatan -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="bi bi-bar-chart-fill me-2 text-success"></i>Sebaran UMKM per Kecamatan</h5>
                        <p class="text-muted small mb-0">Perbandingan jumlah sentra usaha antar kecamatan di Pamekasan</p>
                    </div>
                    <span class="badge bg-success-subtle text-success">Chart.js Realtime</span>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 270px;">
                        <canvas id="adminKecamatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Doughnut Chart Kategori -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Proporsi Kategori Usaha</h5>
                        <p class="text-muted small mb-0">Klasifikasi kegiatan industri tembakau</p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary">Distribusi</span>
                </div>
                <div class="card-body p-4">
                    <div style="position: relative; height: 210px;" class="mb-3">
                        <canvas id="adminKategoriChart"></canvas>
                    </div>
                    <div class="d-flex justify-content-around text-center border-top pt-2 small text-muted">
                        @foreach($kategoriChart as $kc)
                            <div>
                                <span class="fw-bold text-dark d-block">{{ $kc->umkms_count }}</span>
                                <span style="font-size: 0.72rem;">{{ Str::limit($kc->nama_kategori, 12) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- RANKING KECAMATAN & QUICK ACTIONS -->
    <div class="row g-4 mb-4">
        <!-- Ranking Wilayah Tertinggi -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1"><i class="bi bi-trophy-fill me-2 text-warning"></i>Ranking Sentra Wilayah</h5>
                        <p class="text-muted small mb-0">Konsentrasi UMKM tembakau tertinggi</p>
                    </div>
                    <span class="badge bg-warning text-dark fw-bold">Top 5</span>
                </div>
                <div class="card-body p-4 pt-2">
                    <div class="list-group list-group-flush">
                        @forelse($rankingKecamatan as $idx => $rk)
                            @php
                                $percent = $totalUmkm > 0 ? round(($rk->umkms_count / $totalUmkm) * 100) : 0;
                            @endphp
                            <div class="list-group-item px-0 py-2.5 border-bottom">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark border fw-bold" style="width: 26px; height: 26px; display: inline-flex; align-items: center; justify-content: center;">
                                            {{ $idx + 1 }}
                                        </span>
                                        <span class="fw-bold text-dark small">Kec. {{ $rk->nama_kecamatan }}</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold text-success small">{{ $rk->umkms_count }} UMKM</span>
                                        <span class="text-muted small">({{ $percent }}%)</span>
                                    </div>
                                </div>
                                <div class="progress" style="height: 5px; border-radius: 3px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%;"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-muted small py-3 text-center">Belum ada data ranking.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Action Shortcuts -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-1">Akses Cepat Pengelolaan Data</h5>
                    <p class="text-muted small mb-0">Pintasan langsung ke modul manajemen data master</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.kecamatan.index') }}" class="card text-decoration-none border p-3 rounded-3 h-100 hover-shadow transition">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-3 p-3">
                                        <i class="bi bi-map fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Data Kecamatan</div>
                                        <small class="text-muted">Kelola koordinat batas wilayah</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.kategori.index') }}" class="card text-decoration-none border p-3 rounded-3 h-100 hover-shadow transition">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-primary text-white rounded-3 p-3">
                                        <i class="bi bi-tags fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Kategori Usaha</div>
                                        <small class="text-muted">Kelola tipe & jenis usaha</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.umkm.index') }}" class="card text-decoration-none border p-3 rounded-3 h-100 hover-shadow transition">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning text-white rounded-3 p-3">
                                        <i class="bi bi-shop fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Data UMKM</div>
                                        <small class="text-muted">Kelola profil & titik persebaran</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('admin.produk.index') }}" class="card text-decoration-none border p-3 rounded-3 h-100 hover-shadow transition">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-danger text-white rounded-3 p-3">
                                        <i class="bi bi-box-seam fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">Data Produk</div>
                                        <small class="text-muted">Kelola foto & spesifikasi produk</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Sistem / Status -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-1">Informasi Lingkungan Sistem</h5>
                    <p class="text-muted small mb-0">Status server dan platform aplikasi</p>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5">
                            <span class="text-muted"><i class="bi bi-layers me-2"></i>Framework</span>
                            <span class="badge bg-danger-subtle text-danger fw-semibold">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5">
                            <span class="text-muted"><i class="bi bi-code-slash me-2"></i>PHP Version</span>
                            <span class="badge bg-primary-subtle text-primary fw-semibold">{{ PHP_VERSION }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5">
                            <span class="text-muted"><i class="bi bi-database me-2"></i>Database Driver</span>
                            <span class="badge bg-secondary-subtle text-secondary fw-semibold">MySQL (XAMPP)</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5">
                            <span class="text-muted"><i class="bi bi-palette me-2"></i>Frontend UI</span>
                            <span class="badge bg-success-subtle text-success fw-semibold">Bootstrap 5.3 & Icons</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5">
                            <span class="text-muted"><i class="bi bi-shield-check me-2"></i>Sesi Login</span>
                            <span class="badge bg-info-subtle text-info fw-semibold">{{ Auth::user()->email ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <!-- TABEL 5 UMKM TERBARU -->
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1">Persebaran UMKM Tembakau Terbaru</h5>
                <p class="text-muted small mb-0">Entitas UMKM yang baru didaftarkan ke sistem pemetaan</p>
            </div>
            <a href="{{ route('admin.umkm.index') }}" class="btn btn-outline-warning text-dark btn-sm rounded-3 fw-semibold">
                Lihat Semua UMKM <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 70px;">Foto</th>
                            <th scope="col">Nama UMKM</th>
                            <th scope="col">Kecamatan</th>
                            <th scope="col">Kategori Usaha</th>
                            <th scope="col">Koordinat GIS</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestUmkms as $lUmkm)
                            <tr>
                                <td>
                                    <img src="{{ $lUmkm->foto_url }}" 
                                         alt="{{ $lUmkm->nama_umkm }}" 
                                         class="rounded-3 shadow-sm object-fit-cover border" 
                                         style="width: 55px; height: 45px;"
                                         onerror="this.src='{{ asset('storage/umkm/gudang_tembakau_proppo.jpg') }}'">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $lUmkm->nama_umkm }}</div>
                                    <small class="text-muted">{{ $lUmkm->nama_pemilik ?? 'Belum ada pemilik' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-geo-alt text-success me-1"></i>{{ $lUmkm->kecamatan->nama_kecamatan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="bi {{ $lUmkm->kategori->ikon ?? 'bi-tags' }} me-1"></i>{{ $lUmkm->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <code class="small text-muted">{{ number_format($lUmkm->latitude, 4) }}, {{ number_format($lUmkm->longitude, 4) }}</code>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.umkm.edit', $lUmkm->id) }}" class="btn btn-sm btn-outline-primary rounded-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data UMKM.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Chart Sebaran UMKM per Kecamatan (Bar Chart)
        const kecLabels = {!! json_encode($kecamatanChart->pluck('nama_kecamatan')) !!};
        const kecCounts = {!! json_encode($kecamatanChart->pluck('umkms_count')) !!};

        const ctxKec = document.getElementById('adminKecamatanChart').getContext('2d');
        new Chart(ctxKec, {
            type: 'bar',
            data: {
                labels: kecLabels,
                datasets: [{
                    label: 'Jumlah UMKM',
                    data: kecCounts,
                    backgroundColor: 'rgba(16, 185, 129, 0.85)',
                    borderColor: '#10b981',
                    borderWidth: 1.5,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // 2. Chart Distribusi Kategori (Doughnut)
        const katLabels = {!! json_encode($kategoriChart->pluck('nama_kategori')) !!};
        const katCounts = {!! json_encode($kategoriChart->pluck('umkms_count')) !!};

        const ctxKat = document.getElementById('adminKategoriChart').getContext('2d');
        new Chart(ctxKat, {
            type: 'doughnut',
            data: {
                labels: katLabels,
                datasets: [{
                    data: katCounts,
                    backgroundColor: [
                        '#dc2626', // PR
                        '#16a34a', // Rajangan
                        '#d97706', // Gudang
                        '#2563eb', // Bibit
                        '#7c3aed'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush
