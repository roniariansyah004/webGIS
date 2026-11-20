@extends('layouts.admin')

@section('title', 'Kelola Data Kecamatan')
@section('page-title', 'Kelola Data Kecamatan')

@section('content')
<div class="container-fluid p-0">

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1">Daftar Kecamatan Kab. Pamekasan</h5>
                    <p class="text-muted small mb-0">Total {{ $kecamatans->total() }} kecamatan terdaftar di sistem GIS</p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.kecamatan.create') }}" class="btn btn-success d-flex align-items-center gap-2 rounded-3 shadow-sm px-3 py-2">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah Kecamatan</span>
                    </a>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <form action="{{ route('admin.kecamatan.index') }}" method="GET" class="row g-2 mt-3">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama atau kode kecamatan..." value="{{ $search }}">
                        @if($search)
                            <a href="{{ route('admin.kecamatan.index') }}" class="btn btn-outline-secondary border-start-0" title="Reset pencarian"><i class="bi bi-x-lg"></i></a>
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
                            <th scope="col">Nama Kecamatan</th>
                            <th scope="col">Kode Wilayah</th>
                            <th scope="col">Warna Peta</th>
                            <th scope="col">Jumlah UMKM</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col" class="text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kecamatans as $idx => $kec)
                            <tr>
                                <td>{{ $kecamatans->firstItem() + $idx }}</td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $kec->nama_kecamatan }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-secondary border font-monospace">
                                        {{ $kec->kode_kecamatan ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="d-inline-block rounded-circle border shadow-sm" style="width: 18px; height: 18px; background-color: {{ $kec->warna_wilayah }};"></span>
                                        <code class="small text-muted">{{ $kec->warna_wilayah }}</code>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.umkm.index', ['kecamatan_id' => $kec->id]) }}" class="badge bg-success-subtle text-success text-decoration-none px-2.5 py-1.5">
                                        <i class="bi bi-shop me-1"></i> {{ $kec->umkms_count }} UMKM
                                    </a>
                                </td>
                                <td>
                                    <span class="text-muted small text-truncate d-inline-block" style="max-width: 250px;" title="{{ $kec->deskripsi }}">
                                        {{ $kec->deskripsi ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.kecamatan.edit', $kec->id) }}" class="btn btn-sm btn-outline-primary rounded-2" title="Edit Kecamatan">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-2" title="Hapus Kecamatan" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $kec->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Confirm Modal -->
                                    <div class="modal fade" id="deleteModal{{ $kec->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-body text-center p-4">
                                                    <div class="text-danger mb-3">
                                                        <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                                                    </div>
                                                    <h6 class="fw-bold mb-1">Konfirmasi Hapus</h6>
                                                    <p class="text-muted small mb-4">
                                                        Hapus kecamatan <strong>{{ $kec->nama_kecamatan }}</strong>? Seluruh data UMKM di kecamatan ini juga akan terhapus.
                                                    </p>
                                                    <div class="d-flex gap-2">
                                                        <button type="button" class="btn btn-light border w-50" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.kecamatan.destroy', $kec->id) }}" method="POST" class="w-50">
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
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    Tidak ada data kecamatan ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Menampilkan {{ $kecamatans->firstItem() ?? 0 }} - {{ $kecamatans->lastItem() ?? 0 }} dari {{ $kecamatans->total() }} data
                </small>
                <div>
                    {{ $kecamatans->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
