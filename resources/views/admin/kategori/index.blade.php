@extends('layouts.admin')

@section('title', 'Kelola Kategori Usaha')
@section('page-title', 'Kelola Kategori Usaha')

@section('content')
<div class="container-fluid p-0">

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Kategori Usaha Tembakau</h5>
                    <p class="text-muted small mb-0">Total {{ $kategoris->total() }} kategori bidang usaha dan klasifikasi tembakau</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary d-flex align-items-center gap-2 rounded-3 shadow-sm px-3 py-2">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah Kategori</span>
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <form action="{{ route('admin.kategori.index') }}" method="GET" class="row g-2 mt-3">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama kategori atau deskripsi..." value="{{ $search }}">
                        @if($search)
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary border-start-0" title="Reset pencarian"><i class="bi bi-x-lg"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-light border px-3">Cari</button>
                </div>
            </form>
        </div>

        <div class="card-body p-4 pt-2">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 60px;">No</th>
                            <th scope="col">Kategori Usaha</th>
                            <th scope="col">Ikon</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Jumlah UMKM</th>
                            <th scope="col" class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $idx => $kat)
                            <tr>
                                <td>{{ $kategoris->firstItem() + $idx }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $kat->nama_kategori }}</span>
                                </td>
                                <td>
                                    <div class="rounded-3 p-2 bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="bi {{ $kat->ikon ?? 'bi-tags' }} fs-5"></i>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted small text-truncate d-inline-block" style="max-width: 320px;" title="{{ $kat->deskripsi }}">
                                        {{ $kat->deskripsi ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.umkm.index', ['kategori_id' => $kat->id]) }}" class="badge bg-primary-subtle text-primary text-decoration-none px-2.5 py-1.5">
                                        <i class="bi bi-shop me-1"></i> {{ $kat->umkms_count }} UMKM
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.kategori.edit', $kat->id) }}" class="btn btn-sm btn-outline-primary rounded-2" title="Edit Kategori">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-2" title="Hapus Kategori" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $kat->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $kat->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3">
                                                        <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                                                    </div>
                                                    <h6 class="fw-bold mb-1">Konfirmasi Hapus</h6>
                                                    <p class="text-muted small mb-4">
                                                        Hapus kategori <strong>{{ $kat->nama_kategori }}</strong>? Seluruh data UMKM dalam kategori ini juga akan terhapus.
                                                    </p>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-light border w-50" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.kategori.destroy', $kat->id) }}" method="POST" class="w-50">
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
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Tidak ada data kategori ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $kategoris->firstItem() ?? 0 }} - {{ $kategoris->lastItem() ?? 0 }} dari {{ $kategoris->total() }} data
                </small>
                <div>
                    {{ $kategoris->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
