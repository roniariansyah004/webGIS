<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard statistik admin
     */
    public function index()
    {
        $totalKecamatan = \App\Models\Kecamatan::count();
        $totalKategori = \App\Models\Kategori::count();
        $totalUmkm = \App\Models\Umkm::count();
        $totalProduk = \App\Models\Produk::count();
        $totalTenagaKerja = \App\Models\Umkm::sum('jumlah_pekerja');

        // Ranking Kecamatan dengan konsentrasi UMKM tertinggi
        $rankingKecamatan = \App\Models\Kecamatan::withCount('umkms')
            ->orderByDesc('umkms_count')
            ->take(5)
            ->get();

        // Data Sebaran Kecamatan untuk Chart
        $kecamatanChart = \App\Models\Kecamatan::withCount('umkms')
            ->having('umkms_count', '>', 0)
            ->orderByDesc('umkms_count')
            ->get();

        // Data Kategori untuk Chart
        $kategoriChart = \App\Models\Kategori::withCount('umkms')->get();

        // Ambil 5 UMKM terbaru untuk ditampilkan di dashboard dengan eager loading
        $latestUmkms = \App\Models\Umkm::with(['kecamatan', 'kategori', 'produks'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKecamatan',
            'totalKategori',
            'totalUmkm',
            'totalProduk',
            'totalTenagaKerja',
            'rankingKecamatan',
            'kecamatanChart',
            'kategoriChart',
            'latestUmkms'
        ));
    }
}
