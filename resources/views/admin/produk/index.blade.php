@extends('layouts.admin')

@section('title', 'Kelola Data Produk')
@section('page-title', 'Katalog Produk Olahan Tembakau')

@section('content')
<div class="container-fluid p-0">

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Produk Olahan UMKM</h5>
                    <p class="text-muted small mb-0">Total {{ $produks->total() }} produk terdaftar dari berbagai UMKM tembakau</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.produk.create') }}" class="btn btn-danger d-flex align-items-center gap-2 rounded-3 shadow-sm px-3 py-2">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah Produk Baru</span>
                    </a>
                </div>
            </div>

            <!-- Search & Filters -->
            <form action="{{ route('admin.produk.index') }}" method="GET" class="row g-2 mt-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama produk, deskripsi..." value="{{ $search }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <select name="umkm_id" class="form-select">
                        <option value="">-- Semua UMKM Produsen --</option>
                        @foreach($umkms as $u)
                            <option value="{{ $u->id }}" {{ $umkmFilter == $u->id ? 'selected' : '' }}>
                                {{ $u->nama_umkm }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto d-flex gap-1">
                    <button type="submit" class="btn btn-dark px-3">Filter</button>
                    @if($search || $umkmFilter)
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-outline-secondary px-3" title="Reset filter">Reset</a>
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
                            <th scope="col">Nama Produk</th>
                            <th scope="col">UMKM Produsen</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Status Stok</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col" class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produks as $idx => $prod)
                            <tr>
                                <td>{{ $produks->firstItem() + $idx }}</td>
                                <td>
                                    <img src="{{ $prod->foto_url }}" 
                                         alt="{{ $prod->nama_produk }}" 
                                         class="rounded-3 shadow-sm object-fit-cover border" 
                                         style="width: 60px; height: 50px;"
                                         onerror="this.src='{{ asset('storage/produk/tembakau_rajangan_super.jpg') }}'">
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $prod->nama_produk }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.umkm.index', ['search' => $prod->umkm->nama_umkm ?? '']) }}" class="text-decoration-none text-dark d-inline-flex align-items-center gap-1 small">
                                        <i class="bi bi-shop text-warning"></i>
                                        <span class="fw-semibold">{{ $prod->umkm->nama_umkm ?? '-' }}</span>
                                    </a>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">
                                        Rp {{ number_format($prod->harga, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @if($prod->stok_status == 'Tersedia')
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="bi bi-check-circle me-1"></i>Tersedia
                                        </span>
                                    @elseif($prod->stok_status == 'Habis')
                                        <span class="badge bg-danger-subtle text-danger">
                                            <i class="bi bi-x-circle me-1"></i>Habis
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">
                                            <i class="bi bi-clock-history me-1"></i>Pre-Order
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted small text-truncate d-inline-block" style="max-width: 250px;" title="{{ $prod->deskripsi }}">
                                        {{ $prod->deskripsi ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.produk.edit', $prod->id) }}" class="btn btn-sm btn-outline-primary rounded-2" title="Edit Produk">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-2" title="Hapus Produk" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $prod->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $prod->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3">
                                                        <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                                                    </div>
                                                    <h6 class="fw-bold mb-1">Konfirmasi Hapus</h6>
                                                    <p class="text-muted small mb-4">
                                                        Hapus produk <strong>{{ $prod->nama_produk }}</strong>?
                                                    </p>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-light border w-50" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.produk.destroy', $prod->id) }}" method="POST" class="w-50">
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
                                    Tidak ada data produk ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $produks->firstItem() ?? 0 }} - {{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }} produk
                </small>
                <div>
                    {{ $produks->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
