@extends('layouts.admin')

@section('title', 'Tambah Kecamatan')
@section('page-title', 'Tambah Kecamatan')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">Form Tambah Kecamatan</h5>
                        <p class="text-muted small mb-0">Tambahkan wilayah administrasi kecamatan baru</p>
                    </div>
                    <a href="{{ route('admin.kecamatan.index') }}" class="btn btn-light border btn-sm rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.kecamatan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_kecamatan" class="form-label fw-semibold small">Nama Kecamatan <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_kecamatan" 
                                   id="nama_kecamatan" 
                                   class="form-control @error('nama_kecamatan') is-invalid @enderror" 
                                   placeholder="Contoh: Pademawu" 
                                   value="{{ old('nama_kecamatan') }}" 
                                   required>
                            @error('nama_kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="kode_kecamatan" class="form-label fw-semibold small">Kode Wilayah</label>
                                <input type="text" 
                                       name="kode_kecamatan" 
                                       id="kode_kecamatan" 
                                       class="form-control @error('kode_kecamatan') is-invalid @enderror" 
                                       placeholder="Contoh: 35.28.02" 
                                       value="{{ old('kode_kecamatan') }}">
                                @error('kode_kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="warna_wilayah" class="form-label fw-semibold small">Warna Wilayah (Peta GIS) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="color" 
                                           name="warna_wilayah" 
                                           id="warna_wilayah" 
                                           class="form-control form-control-color w-25 @error('warna_wilayah') is-invalid @enderror" 
                                           value="{{ old('warna_wilayah', '#10b981') }}" 
                                           title="Pilih warna untuk layer batas wilayah">
                                    <input type="text" 
                                           id="warna_wilayah_text" 
                                           class="form-control" 
                                           value="{{ old('warna_wilayah', '#10b981') }}" 
                                           readonly>
                                </div>
                                @error('warna_wilayah')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold small">Deskripsi Singkat</label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="3" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      placeholder="Keterangan potensi komoditas tembakau di kecamatan ini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="geojson" class="form-label fw-semibold small">GeoJSON Poligon Batas (Opsional)</label>
                            <textarea name="geojson" 
                                      id="geojson" 
                                      rows="3" 
                                      class="form-control font-monospace small @error('geojson') is-invalid @enderror" 
                                      placeholder='{"type": "Feature", "geometry": {...}}'>{{ old('geojson') }}</textarea>
                            <div class="form-text small">Dapat diisi koordinat GeoJSON poligon kecamatan jika sudah tersedia.</div>
                            @error('geojson')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.kecamatan.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="bi bi-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('warna_wilayah').addEventListener('input', function(e) {
        document.getElementById('warna_wilayah_text').value = e.target.value;
    });
</script>
@endpush
