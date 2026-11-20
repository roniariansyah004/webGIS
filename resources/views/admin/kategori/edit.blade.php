@extends('layouts.admin')

@section('title', 'Edit Kategori Usaha')
@section('page-title', 'Edit Kategori Usaha')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">Edit Kategori: {{ $kategori->nama_kategori }}</h5>
                        <p class="text-muted small mb-0">Perbarui klasifikasi jenis usaha</p>
                    </div>
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-light border btn-sm rounded-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label fw-semibold small">Nama Kategori Usaha <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama_kategori" 
                                   id="nama_kategori" 
                                   class="form-control @error('nama_kategori') is-invalid @enderror" 
                                   placeholder="Contoh: Pabrik Rokok (PR)" 
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                   required>
                            @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ikon" class="form-label fw-semibold small">Ikon Bootstrap Icons</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" id="icon-preview"><i class="bi {{ $kategori->ikon ?? 'bi-tags' }} fs-5"></i></span>
                                <input type="text" 
                                       name="ikon" 
                                       id="ikon" 
                                       class="form-control @error('ikon') is-invalid @enderror" 
                                       placeholder="Contoh: bi-building, bi-scissors, bi-boxes" 
                                       value="{{ old('ikon', $kategori->ikon) }}">
                            </div>
                            <div class="form-text small">Gunakan nama class dari Bootstrap Icons.</div>
                            @error('ikon')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-semibold small">Deskripsi Kategori</label>
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="3" 
                                      class="form-control @error('deskripsi') is-invalid @enderror" 
                                      placeholder="Penjelasan singkat mengenai kategori usaha ini...">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Perbarui Kategori
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
    document.getElementById('ikon').addEventListener('input', function(e) {
        const val = e.target.value.trim();
        const preview = document.getElementById('icon-preview');
        preview.innerHTML = `<i class="bi ${val || 'bi-tags'} fs-5"></i>`;
    });
</script>
@endpush
