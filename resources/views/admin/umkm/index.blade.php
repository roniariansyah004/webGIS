@extends('layouts.admin')

@section('title', 'Kelola Data UMKM')
@section('page-title', 'Kelola Data UMKM Tembakau')

@section('content')
<div class="container-fluid p-0">

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1">Daftar UMKM Tembakau Terdata</h5>
                    <p class="text-muted small mb-0">Total {{ $umkms->total() }} entitas UMKM terpetakan di wilayah Kab. Pamekasan</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.umkm.create') }}" class="btn btn-warning text-dark fw-semibold d-flex align-items-center gap-2 rounded-3 shadow-sm px-3 py-2">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah UMKM Baru</span>
                    </a>
                </div>
            </div>

            <!-- Search & Filters -->
            <form action="{{ route('admin.umkm.index') }}" method="GET" class="row g-2 mt-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama UMKM, pemilik, alamat..." value="{{ $search }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="kecamatan_id" class="form-select">
                        <option value="">-- Semua Kecamatan --</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}" {{ $kecamatanFilter == $kec->id ? 'selected' : '' }}>
                                {{ $kec->nama_kecamatan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ $kategoriFilter == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto d-flex gap-1">
                    <button type="submit" class="btn btn-dark px-3">Filter</button>
                    @if($search || $kecamatanFilter || $kategoriFilter)
                        <a href="{{ route('admin.umkm.index') }}" class="btn btn-outline-secondary px-3" title="Reset filter">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card-body p-4 pt-2">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 50px;">No</th>
                            <th scope="col" style="width: 80px;">Foto</th>
                            <th scope="col">Nama UMKM & Pemilik</th>
                            <th scope="col">Kecamatan</th>
                            <th scope="col">Kategori Usaha</th>
                            <th scope="col">Koordinat GIS</th>
                            <th scope="col">Katalog Produk</th>
                            <th scope="col" class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($umkms as $idx => $umkm)
                            <tr>
                                <td>{{ $umkms->firstItem() + $idx }}</td>
                                <td>
                                    <div class="position-relative">
                                        <img src="{{ $umkm->foto_url }}" 
                                             alt="{{ $umkm->nama_umkm }}" 
                                             class="rounded-3 shadow-sm object-fit-cover border" 
                                             style="width: 65px; height: 50px;"
                                             onerror="this.src='{{ asset('storage/umkm/gudang_tembakau_proppo.jpg') }}'">
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $umkm->nama_umkm }}</div>
                                    <div class="text-muted small">
                                        <i class="bi bi-person me-1"></i>{{ $umkm->nama_pemilik ?? 'Belum ada data pemilik' }}
                                        @if($umkm->no_telepon)
                                            &bull; <i class="bi bi-telephone ms-1 me-1"></i>{{ $umkm->no_telepon }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-geo-alt text-success me-1"></i>{{ $umkm->kecamatan->nama_kecamatan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary">
                                        <i class="bi {{ $umkm->kategori->ikon ?? 'bi-tags' }} me-1"></i>{{ $umkm->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <a href="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}" 
                                           target="_blank" 
                                           class="text-decoration-none small text-dark d-inline-flex align-items-center gap-1 font-monospace"
                                           title="Buka di Google Maps">
                                            <i class="bi bi-pin-map-fill text-danger"></i>
                                            <span>{{ number_format($umkm->latitude, 5) }}, {{ number_format($umkm->longitude, 5) }}</span>
                                            <i class="bi bi-box-arrow-up-right text-muted small"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.produk.index', ['umkm_id' => $umkm->id]) }}" class="badge bg-warning-subtle text-dark text-decoration-none px-2.5 py-1.5">
                                        <i class="bi bi-box-seam me-1"></i> {{ $umkm->produks_count }} Produk
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.produk.create', ['umkm_id' => $umkm->id]) }}" class="btn btn-sm btn-outline-success rounded-2" title="Tambah Produk UMKM Ini">
                                            <i class="bi bi-plus-lg"></i>
                                        </a>
                                        <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="btn btn-sm btn-outline-primary rounded-2" title="Edit Data UMKM">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-2" title="Hapus UMKM" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $umkm->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $umkm->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3">
                                                        <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                                                    </div>
                                                    <h6 class="fw-bold mb-1">Hapus Data UMKM?</h6>
                                                    <p class="text-muted small mb-4">
                                                        Hapus <strong>{{ $umkm->nama_umkm }}</strong>? Semua data produk terkait juga akan ikut dihapus.
                                                    </p>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-light border w-50" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST" class="w-50">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger w-100">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Tidak ada data UMKM yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $umkms->firstItem() ?? 0 }} - {{ $umkms->lastItem() ?? 0 }} dari {{ $umkms->total() }} UMKM
                </small>
                <div>
                    {{ $umkms->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
