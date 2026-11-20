@extends('layouts.admin')

@section('title', 'Edit Data UMKM')
@section('page-title', 'Edit Data UMKM: ' . $umkm->nama_umkm)

@push('styles')
<!-- Leaflet CSS for Map Picker -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map-picker {
        height: 380px;
        width: 100%;
        border-radius: 12px;
        z-index: 1;
    }
    .preview-box {
        width: 100%;
        height: 180px;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f8fafc;
    }
    .preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Kolom Kiri: Informasi Pokok Usaha -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">Identitas & Profil Usaha</h5>
                            <p class="text-muted small mb-0">Perbarui informasi profil dan data pemilik UMKM</p>
                        </div>
                        <a href="{{ route('admin.umkm.index') }}" class="btn btn-light border btn-sm rounded-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <!-- Nama UMKM -->
                        <div class="mb-3">
                            <label for="nama_umkm" class="form-label fw-semibold small">Nama UMKM / Usaha <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_umkm" 
                                   id="nama_umkm" 
                                   class="form-control @error('nama_umkm') is-invalid @enderror" 
                                   placeholder="Contoh: PR. Madura Makmur Sentosa" 
                                   value="{{ old('nama_umkm', $umkm->nama_umkm) }}" 
                                   required>
                            @error('nama_umkm')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dropdown FK Kecamatan & Kategori -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="kecamatan_id" class="form-label fw-semibold small">Wilayah Kecamatan <span class="text-danger">*</span></label>
                                <select name="kecamatan_id" id="kecamatan_id" class="form-select @error('kecamatan_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach($kecamatans as $kec)
                                        <option value="{{ $kec->id }}" {{ old('kecamatan_id', $umkm->kecamatan_id) == $kec->id ? 'selected' : '' }}>
                                            {{ $kec->nama_kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kategori_id" class="form-label fw-semibold small">Kategori Usaha <span class="text-danger">*</span></label>
                                <select name="kategori_id" id="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $kat)
                                        <option value="{{ $kat->id }}" {{ old('kategori_id', $umkm->kategori_id) == $kat->id ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nama Pemilik & Kontak -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nama_pemilik" class="form-label fw-semibold small">Nama Pemilik / Pimpinan</label>
                                <input type="text" 
                                       name="nama_pemilik" 
                                       id="nama_pemilik" 
                                       class="form-control @error('nama_pemilik') is-invalid @enderror" 
                                       placeholder="Nama pemilik usaha" 
                                       value="{{ old('nama_pemilik', $umkm->nama_pemilik) }}">
                                @error('nama_pemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="no_telepon" class="form-label fw-semibold small">Nomor Telepon / WhatsApp</label>
                                <input type="text" 
                                       name="no_telepon" 
                                       id="no_telepon" 
                                       class="form-control @error('no_telepon') is-invalid @enderror" 
                                       placeholder="Contoh: 081234567890" 
                                       value="{{ old('no_telepon', $umkm->no_telepon) }}">
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tahun Berdiri & Alamat -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="tahun_berdiri" class="form-label fw-semibold small">Tahun Berdiri</label>
                                <input type="number" 
                                       name="tahun_berdiri" 
                                       id="tahun_berdiri" 
                                       class="form-control @error('tahun_berdiri') is-invalid @enderror" 
                                       placeholder="Contoh: 2018" 
                                       min="1900" 
                                       max="{{ date('Y') }}" 
                                       value="{{ old('tahun_berdiri', $umkm->tahun_berdiri) }}">
                                @error('tahun_berdiri')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="alamat" class="form-label fw-semibold small">Alamat Lengkap</label>
                                <input type="text" 
                                       name="alamat" 
                                       id="alamat" 
                                       class="form-control @error('alamat') is-invalid @enderror" 
                                       placeholder="Dusun, Desa, RT/RW, Jalan" 
                                       value="{{ old('alamat', $umkm->alamat) }}">
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kapasitas Produksi -->
                        <div class="mb-3">
                            <label for="kapasitas_produksi" class="form-label fw-semibold small">Kapasitas Produksi</label>
                            <input type="text" 
                                   name="kapasitas_produksi" 
                                   id="kapasitas_produksi" 
                                   class="form-control @error('kapasitas_produksi') is-invalid @enderror" 
                                   placeholder="Contoh: 50.000 batang/hari atau 2 ton daun kering/musim" 
                                   value="{{ old('kapasitas_produksi', $umkm->kapasitas_produksi) }}">
                            @error('kapasitas_produksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi Usaha -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold small">Deskripsi Profil Usaha</label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="3" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      placeholder="Keterangan kapasitas produksi, jumlah tenaga kerja, keunggulan produk...">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload / Ganti Foto -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Foto Tempat Usaha / Produk Utama</label>
                            <div class="preview-box mb-2" id="preview-container">
                                <img id="preview-img" src="{{ $umkm->foto_url }}" alt="{{ $umkm->nama_umkm }}">
                            </div>
                            <input type="file" 
                                   name="foto" 
                                   id="foto" 
                                   class="form-control @error('foto') is-invalid @enderror" 
                                   accept="image/*">
                            <div class="form-text small">Biarkan kosong jika tidak ingin mengubah foto yang sudah ada.</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Map Picker Koordinat GIS -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">Titik Lokasi GIS (Map Picker)</h5>
                            <p class="text-muted small mb-0">Klik pada peta atau geser pin merah untuk memperbarui titik koordinat</p>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <!-- Peta Leaflet Picker -->
                        <div id="map-picker" class="border"></div>

                        <!-- Tombol Bantu Lokasi -->
                        <div class="d-flex justify-content-between align-items-center my-3">
                            <span class="badge bg-light text-muted border">
                                <i class="bi bi-geo-alt me-1"></i>Posisi Saat Ini: {{ number_format($umkm->latitude, 5) }}, {{ number_format($umkm->longitude, 5) }}
                            </span>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-reset-map">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Titik Awal
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" id="btn-current-location">
                                    <i class="bi bi-crosshair me-1"></i> Lokasi Saya
                                </button>
                            </div>
                        </div>

                        <!-- Field Input Numerik Latitude & Longitude -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label fw-semibold small">
                                    Latitude (Garis Lintang) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-compass"></i></span>
                                    <input type="number" 
                                           step="any" 
                                           name="latitude" 
                                           id="latitude" 
                                           class="form-control font-monospace @error('latitude') is-invalid @enderror" 
                                           placeholder="-7.15930000" 
                                           value="{{ old('latitude', $umkm->latitude) }}" 
                                           required>
                                </div>
                                @error('latitude')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="longitude" class="form-label fw-semibold small">
                                    Longitude (Garis Bujur) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-compass"></i></span>
                                    <input type="number" 
                                           step="any" 
                                           name="longitude" 
                                           id="longitude" 
                                           class="form-control font-monospace @error('longitude') is-invalid @enderror" 
                                           placeholder="113.47390000" 
                                           value="{{ old('longitude', $umkm->longitude) }}" 
                                           required>
                                </div>
                                @error('longitude')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info border-0 rounded-3 small d-flex align-items-center gap-2 mb-4">
                            <i class="bi bi-lightbulb-fill text-info fs-5"></i>
                            <div>
                                Anda dapat mengklik sembarang titik di peta atau mengetikkan angka koordinat secara manual di kolom Latitude & Longitude.
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('admin.umkm.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                                <i class="bi bi-save me-1"></i> Perbarui Data UMKM
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const initialLat = parseFloat("{{ old('latitude', $umkm->latitude) }}") || -7.1593;
        const initialLng = parseFloat("{{ old('longitude', $umkm->longitude) }}") || 113.4739;

        // Inisialisasi Peta Leaflet
        const map = L.map('map-picker').setView([initialLat, initialLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);

        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = parseFloat(lat).toFixed(8);
            document.getElementById('longitude').value = parseFloat(lng).toFixed(8);
        }

        marker.on('dragend', function (e) {
            const position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            updateCoordinates(e.latlng.lat, e.latlng.lng);
        });

        function onManualInput() {
            const lat = parseFloat(document.getElementById('latitude').value);
            const lng = parseFloat(document.getElementById('longitude').value);
            if (!isNaN(lat) && !isNaN(lng)) {
                const newPos = [lat, lng];
                marker.setLatLng(newPos);
                map.panTo(newPos);
            }
        }

        document.getElementById('latitude').addEventListener('input', onManualInput);
        document.getElementById('longitude').addEventListener('input', onManualInput);

        // Reset Pin ke titik asal UMKM
        document.getElementById('btn-reset-map').addEventListener('click', function () {
            marker.setLatLng([initialLat, initialLng]);
            map.setView([initialLat, initialLng], 14);
            updateCoordinates(initialLat, initialLng);
        });

        // Geolocation Browser
        document.getElementById('btn-current-location').addEventListener('click', function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const userPos = [position.coords.latitude, position.coords.longitude];
                    marker.setLatLng(userPos);
                    map.setView(userPos, 15);
                    updateCoordinates(userPos[0], userPos[1]);
                }, function () {
                    alert('Gagal mendeteksi lokasi saat ini. Pastikan izin lokasi di browser diaktifkan.');
                });
            } else {
                alert('Browser Anda tidak mendukung fitur geolokasi.');
            }
        });

        // Pratinjau Foto saat file baru dipilih
        const fotoInput = document.getElementById('foto');
        const previewImg = document.getElementById('preview-img');

        fotoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    previewImg.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
