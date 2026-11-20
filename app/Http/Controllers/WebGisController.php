<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kategori;
use App\Models\Umkm;
use Illuminate\Http\Request;

class WebGisController extends Controller
{
    /**
     * Halaman Beranda Publik (/)
     */
    public function home()
    {
        $totalUmkm = Umkm::count();
        $totalKecamatan = Kecamatan::count();
        $totalTenagaKerja = Umkm::sum('jumlah_pekerja');
        $totalProduk = \App\Models\Produk::count();

        // Estimasi ringkasan kapasitas produksi total
        $kapasitasSummary = '250.000+ Batang & 30+ Ton/Musim';

        // Ranking Kecamatan dengan konsentrasi UMKM tertinggi
        $rankingKecamatan = Kecamatan::withCount('umkms')
            ->orderByDesc('umkms_count')
            ->take(6)
            ->get();

        // Data Kategori Usaha untuk Chart dan Cards
        $kategoris = Kategori::withCount('umkms')->get();

        // Data Sebaran Kecamatan untuk Chart.js (hanya yang memiliki UMKM)
        $kecamatanChartData = Kecamatan::withCount('umkms')
            ->having('umkms_count', '>', 0)
            ->orderByDesc('umkms_count')
            ->get();

        // 4 UMKM Terpilih untuk preview di beranda
        $featuredUmkms = Umkm::with(['kecamatan', 'kategori', 'produks'])
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact(
            'totalUmkm',
            'totalKecamatan',
            'totalTenagaKerja',
            'totalProduk',
            'kapasitasSummary',
            'rankingKecamatan',
            'kategoris',
            'kecamatanChartData',
            'featuredUmkms'
        ));
    }

    /**
     * Menampilkan halaman publik WebGIS Tembakau Pamekasan
     */
    public function index()
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $kategoris = Kategori::withCount('umkms')->orderBy('nama_kategori')->get();
        $totalUmkm = Umkm::count();

        return view('peta', compact('kecamatans', 'kategoris', 'totalUmkm'));
    }

    /**
     * Endpoint API JSON untuk data titik lokasi UMKM WebGIS
     * Route: /api/umkm-locations
     */
    public function getUmkmLocations(Request $request)
    {
        $kecamatanId = $request->query('kecamatan_id');
        $kategoriId = $request->query('kategori_id');
        $search = $request->query('search');

        $umkms = Umkm::with(['kecamatan', 'kategori', 'produks'])
            ->when($kecamatanId, function ($query, $kecId) {
                $query->where('kecamatan_id', $kecId);
            })
            ->when($kategoriId, function ($query, $katId) {
                $query->where('kategori_id', $katId);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_umkm', 'like', "%{$search}%")
                      ->orWhere('nama_pemilik', 'like', "%{$search}%")
                      ->orWhere('alamat', 'like', "%{$search}%")
                      ->orWhereHas('produks', function ($pq) use ($search) {
                          $pq->where('nama_produk', 'like', "%{$search}%")
                             ->orWhere('deskripsi', 'like', "%{$search}%");
                      });
                });
            })
            ->get();

        // Pemetaan data JSON yang kaya dan siap dirender di Leaflet
        $formatted = $umkms->map(function ($item) {
            $markerMeta = $this->getCategoryMarkerMeta($item->kategori->nama_kategori ?? '');

            return [
                'id' => $item->id,
                'detail_url' => route('umkm.detail', $item->id),
                'nama_umkm' => $item->nama_umkm,
                'nama_pemilik' => $item->nama_pemilik ?? 'Belum terdata',
                'no_telepon' => $item->no_telepon ?? '-',
                'alamat' => $item->alamat ?? 'Wilayah Kab. Pamekasan',
                'latitude' => (float) $item->latitude,
                'longitude' => (float) $item->longitude,
                'foto_url' => $item->foto_url,
                'deskripsi' => $item->deskripsi ?? 'Tidak ada deskripsi profil.',
                'kapasitas_produksi' => $item->kapasitas_produksi ?? 'Tidak ada data kapasitas.',
                'jumlah_pekerja' => $item->jumlah_pekerja ? $item->jumlah_pekerja . ' Orang' : 'Tidak terdata',
                'tahun_berdiri' => $item->tahun_berdiri ? (string) $item->tahun_berdiri : '-',
                'kecamatan' => [
                    'id' => $item->kecamatan->id ?? null,
                    'nama_kecamatan' => $item->kecamatan->nama_kecamatan ?? '-',
                    'warna_wilayah' => $item->kecamatan->warna_wilayah ?? '#10b981',
                ],
                'kategori' => [
                    'id' => $item->kategori->id ?? null,
                    'nama_kategori' => $item->kategori->nama_kategori ?? 'Umum',
                    'ikon' => $item->kategori->ikon ?? 'bi-tags',
                ],
                'marker' => [
                    'color' => $markerMeta['color'],
                    'bg_class' => $markerMeta['bg_class'],
                    'icon' => $markerMeta['icon'],
                ],
                'produks' => $item->produks->map(function ($prod) {
                    return [
                        'id' => $prod->id,
                        'nama_produk' => $prod->nama_produk,
                        'harga' => $prod->harga,
                        'harga_formatted' => 'Rp ' . number_format($prod->harga, 0, ',', '.'),
                        'foto_url' => $prod->foto_url,
                        'stok_status' => $prod->stok_status,
                        'deskripsi' => $prod->deskripsi,
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => 'success',
            'total' => $formatted->count(),
            'data' => $formatted,
        ]);
    }

    /**
     * Halaman Publik Detail UMKM
     * Route: /umkm/{id}
     */
    public function showDetail($id)
    {
        $umkm = Umkm::with(['kecamatan', 'kategori', 'produks'])->findOrFail($id);

        // Ambil UMKM lain di kecamatan yang sama untuk rekomendasi dengan eager loading
        $relatedUmkms = Umkm::with(['kecamatan', 'kategori', 'produks'])
            ->where('kecamatan_id', $umkm->kecamatan_id)
            ->where('id', '!=', $umkm->id)
            ->take(3)
            ->get();

        return view('umkm_detail', compact('umkm', 'relatedUmkms'));
    }

    /**
     * Helper untuk menentukan visualisasi marker berdasarkan kategori
     */
    private function getCategoryMarkerMeta(string $kategoriName): array
    {
        $kategoriNameLower = strtolower($kategoriName);

        if (str_contains($kategoriNameLower, 'pabrik rokok')) {
            return [
                'color' => '#dc2626', // Red
                'bg_class' => 'bg-danger',
                'icon' => 'bi-fire',
            ];
        }

        if (str_contains($kategoriNameLower, 'rajangan')) {
            return [
                'color' => '#16a34a', // Emerald Green
                'bg_class' => 'bg-success',
                'icon' => 'bi-scissors',
            ];
        }

        if (str_contains($kategoriNameLower, 'gudang') || str_contains($kategoriNameLower, 'pengepul')) {
            return [
                'color' => '#d97706', // Amber / Gold
                'bg_class' => 'bg-warning',
                'icon' => 'bi-boxes',
            ];
        }

        if (str_contains($kategoriNameLower, 'bibit') || str_contains($kategoriNameLower, 'benih')) {
            return [
                'color' => '#2563eb', // Royal Blue
                'bg_class' => 'bg-primary',
                'icon' => 'bi-flower1',
            ];
        }

        return [
            'color' => '#7c3aed', // Purple default
            'bg_class' => 'bg-info',
            'icon' => 'bi-geo-alt-fill',
        ];
    }
}
