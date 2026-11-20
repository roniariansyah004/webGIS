@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">Form Tambah Produk UMKM</h5>
                        <p class="text-muted small mb-0">Hubungkan produk olahan tembakau ke unit UMKM produsen</p>
                    </div>
                    <a href="{{ route('admin.produk.index') }}" class="btn btn-light border btn-sm rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Dropdown FK UMKM Produsen -->
                        <div class="mb-3">
                            <label for="umkm_id" class="form-label fw-semibold small">UMKM Produsen <span class="text-danger">*</span></label>
                            <select name="umkm_id" id="umkm_id" class="form-select @error('umkm_id') is-invalid @enderror" required>
                                <option value="">-- Pilih UMKM Produsen --</option>
                                @foreach($umkms as $u)
                                    <option value="{{ $u->id }}" {{ old('umkm_id', $selectedUmkmId) == $u->id ? 'selected' : '' }}>
                                        {{ $u->nama_umkm }} (Kec. {{ $u->kecamatan->nama_kecamatan ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('umkm_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label fw-semibold small">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_produk" 
                                   id="nama_produk" 
                                   class="form-control @error('nama_produk') is-invalid @enderror" 
                                   placeholder="Contoh: Rokok Kretek Madura 12s" 
                                   value="{{ old('nama_produk') }}" 
                                   required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga & Status Stok -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="harga" class="form-label fw-semibold small">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">Rp</span>
                                    <input type="number" 
                                           name="harga" 
                                           id="harga" 
                                           min="0" 
                                           step="500" 
                                           class="form-control @error('harga') is-invalid @enderror" 
                                           placeholder="15000" 
                                           value="{{ old('harga') }}" 
                                           required>
                                </div>
                                @error('harga')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="stok_status" class="form-label fw-semibold small">Status Ketersediaan <span class="text-danger">*</span></label>
                                <select name="stok_status" id="stok_status" class="form-select @error('stok_status') is-invalid @enderror" required>
                                    <option value="Tersedia" {{ old('stok_status') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="Habis" {{ old('stok_status') == 'Habis' ? 'selected' : '' }}>Habis</option>
                                    <option value="Pre-Order" {{ old('stok_status') == 'Pre-Order' ? 'selected' : '' }}>Pre-Order</option>
                                </select>
                                @error('stok_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi Produk -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold small">Deskripsi Produk & Spesifikasi</label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="3" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      placeholder="Rincian rasa, kemasan, gramatur, atau varian...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Produk -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Foto Kemasan / Produk</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <img id="preview-produk" 
                                     src="https://images.unsplash.com/photo-1527661591475-527312dd65f5?w=600&auto=format&fit=crop&q=80" 
                                     alt="Pratinjau" 
                                     class="rounded-3 border object-fit-cover shadow-sm" 
                                     style="width: 100px; height: 100px;">
                                <div class="flex-grow-1">
                                    <input type="file" 
                                           name="foto" 
                                           id="foto" 
                                           class="form-control @error('foto') is-invalid @enderror" 
                                           accept="image/*">
                                    <div class="form-text small">Format JPG, JPEG, PNG, WEBP. Maksimal 2MB.</div>
                                </div>
                            </div>
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-save me-1"></i> Simpan Produk
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
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview-produk').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
