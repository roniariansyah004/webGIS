<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin Default
        User::updateOrCreate(
            ['email' => 'admin@tembakau.com'],
            [
                'name' => 'Administrator TembakauGIS',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Data Kecamatan di Kabupaten Pamekasan
        $kecamatansData = [
            ['nama_kecamatan' => 'Pamekasan', 'kode_kecamatan' => '35.28.01', 'warna_wilayah' => '#10b981', 'deskripsi' => 'Pusat pemerintahan dan perdagangan tembakau.'],
            ['nama_kecamatan' => 'Pademawu', 'kode_kecamatan' => '35.28.02', 'warna_wilayah' => '#059669', 'deskripsi' => 'Wilayah pesisir selatan dengan banyak sentra industri rokok kretek.'],
            ['nama_kecamatan' => 'Tlanakan', 'kode_kecamatan' => '35.28.03', 'warna_wilayah' => '#047857', 'deskripsi' => 'Kawasan agraris penghasil tembakau rajangan.'],
            ['nama_kecamatan' => 'Proppo', 'kode_kecamatan' => '35.28.04', 'warna_wilayah' => '#0d9488', 'deskripsi' => 'Pusat sentra pengolahan dan penjemuran daun tembakau.'],
            ['nama_kecamatan' => 'Palengaan', 'kode_kecamatan' => '35.28.05', 'warna_wilayah' => '#0891b2', 'deskripsi' => 'Daerah perbukitan penghasil tembakau gunung berkualitas tinggi.'],
            ['nama_kecamatan' => 'Pegantenan', 'kode_kecamatan' => '35.28.06', 'warna_wilayah' => '#0284c7', 'deskripsi' => 'Wilayah dataran tinggi dengan iklim sejuk penghasil tembakau super.'],
            ['nama_kecamatan' => 'Larangan', 'kode_kecamatan' => '35.28.07', 'warna_wilayah' => '#2563eb', 'deskripsi' => 'Sentra pasar tembakau dan gudang penampungan lokal.'],
            ['nama_kecamatan' => 'Pakong', 'kode_kecamatan' => '35.28.08', 'warna_wilayah' => '#4f46e5', 'deskripsi' => 'Kawasan budidaya tembakau aromatik khas Madura.'],
            ['nama_kecamatan' => 'Waru', 'kode_kecamatan' => '35.28.09', 'warna_wilayah' => '#7c3aed', 'deskripsi' => 'Wilayah utara penghasil tembakau gunung yang kuat aromanya.'],
            ['nama_kecamatan' => 'Batumarmar', 'kode_kecamatan' => '35.28.10', 'warna_wilayah' => '#9333ea', 'deskripsi' => 'Kawasan pantai utara dengan aktivitas pengolahan tembakau.'],
            ['nama_kecamatan' => 'Pasean', 'kode_kecamatan' => '35.28.11', 'warna_wilayah' => '#c026d3', 'deskripsi' => 'Pesisir utara dengan sentra perajangan tradisional.'],
            ['nama_kecamatan' => 'Kadur', 'kode_kecamatan' => '35.28.12', 'warna_wilayah' => '#db2777', 'deskripsi' => 'Daerah pertanian subur tembakau sawah.'],
            ['nama_kecamatan' => 'Galis', 'kode_kecamatan' => '35.28.13', 'warna_wilayah' => '#e11d48', 'deskripsi' => 'Wilayah perbatasan timur dengan pergudangan tembakau.'],
        ];

        foreach ($kecamatansData as $kData) {
            \App\Models\Kecamatan::updateOrCreate(
                ['kode_kecamatan' => $kData['kode_kecamatan']],
                $kData
            );
        }

        // 3. Data Kategori Usaha
        $kategorisData = [
            ['nama_kategori' => 'Pabrik Rokok (PR)', 'deskripsi' => 'Industri pengolahan tembakau menjadi rokok kretek, filter, atau cerutu legal', 'ikon' => 'bi-building'],
            ['nama_kategori' => 'Pengolahan Rajangan Tradisional', 'deskripsi' => 'Usaha mikro pemotongan, penjemuran, dan pengemasan tembakau rajangan khas Madura', 'ikon' => 'bi-scissors'],
            ['nama_kategori' => 'Gudang & Pengepul Tembakau', 'deskripsi' => 'Pusat sortasi grade tembakau, penyimpanan, dan distribusi ke pabrikan besar', 'ikon' => 'bi-boxes'],
            ['nama_kategori' => 'Sentra Pembibitan & Saprotan Tembakau', 'deskripsi' => 'Penyedia bibit unggul tembakau Madura dan sarana produksi pertanian', 'ikon' => 'bi-flower1'],
        ];

        foreach ($kategorisData as $katData) {
            \App\Models\Kategori::updateOrCreate(
                ['nama_kategori' => $katData['nama_kategori']],
                $katData
            );
        }

        // 4. Data UMKM Tembakau Contoh
        $kecPamekasan = \App\Models\Kecamatan::where('nama_kecamatan', 'Pamekasan')->first();
        $kecPademawu = \App\Models\Kecamatan::where('nama_kecamatan', 'Pademawu')->first();
        $kecPakong = \App\Models\Kecamatan::where('nama_kecamatan', 'Pakong')->first();

        $katPR = \App\Models\Kategori::where('nama_kategori', 'Pabrik Rokok (PR)')->first();
        $katRajangan = \App\Models\Kategori::where('nama_kategori', 'Pengolahan Rajangan Tradisional')->first();

        if ($kecPademawu && $katPR) {
            $umkm1 = \App\Models\Umkm::updateOrCreate(
                ['nama_umkm' => 'PR. Madura Berkah'],
                [
                    'kecamatan_id' => $kecPademawu->id,
                    'kategori_id' => $katPR->id,
                    'nama_pemilik' => 'H. Achmad Zaini',
                    'no_telepon' => '081234567890',
                    'alamat' => 'Jl. Raya Bunder No. 45, Kec. Pademawu, Pamekasan',
                    'latitude' => -7.17281450,
                    'longitude' => 113.48312010,
                    'foto' => 'umkm/pabrik_rokok_berkah.jpg',
                    'kapasitas_produksi' => '150.000 batang / bulan',
                    'jumlah_pekerja' => 85,
                    'deskripsi' => 'Pabrik rokok kretek lokal yang menyerap ratusan tenaga kerja lokal dan menggunakan tembakau asli Madura.',
                    'tahun_berdiri' => 2015,
                ]
            );

            // Tambahkan Produk
            \App\Models\Produk::updateOrCreate(
                ['nama_produk' => 'Rokok Kretek Madura 12 Batang', 'umkm_id' => $umkm1->id],
                [
                    'harga' => 14000,
                    'foto' => 'produk/rokok_kretek_madura.jpg',
                    'stok_status' => 'Tersedia',
                    'deskripsi' => 'Rokok kretek tangan dengan racikan tembakau pilihan aroma cengkeh asli Madura.'
                ]
            );

            \App\Models\Produk::updateOrCreate(
                ['nama_produk' => 'Rokok Filter Madura Berkah 16s', 'umkm_id' => $umkm1->id],
                [
                    'harga' => 22000,
                    'foto' => 'produk/rokok_kretek_madura.jpg',
                    'stok_status' => 'Tersedia',
                    'deskripsi' => 'Rokok mesin filter halus dengan tarikan mantap dan rasa gurih.'
                ]
            );
        }

        if ($kecPakong && $katRajangan) {
            $umkm2 = \App\Models\Umkm::updateOrCreate(
                ['nama_umkm' => 'UD. Rajangan Super Pakong'],
                [
                    'kecamatan_id' => $kecPakong->id,
                    'kategori_id' => $katRajangan->id,
                    'nama_pemilik' => 'Bpk. Subairi',
                    'no_telepon' => '085231987654',
                    'alamat' => 'Desa Pakong RT 03 RW 01, Kec. Pakong, Pamekasan',
                    'latitude' => -7.04231800,
                    'longitude' => 113.55194000,
                    'foto' => 'umkm/sentra_rajangan_pakong.jpg',
                    'kapasitas_produksi' => '5 ton tembakau rajangan / musim',
                    'jumlah_pekerja' => 32,
                    'deskripsi' => 'Spesialis perajangan tembakau gunung halus dengan aroma wangi tahan lama.',
                    'tahun_berdiri' => 2018,
                ]
            );

            \App\Models\Produk::updateOrCreate(
                ['nama_produk' => 'Tembakau Rajangan Super Gunung Madura 250g', 'umkm_id' => $umkm2->id],
                [
                    'harga' => 45000,
                    'foto' => 'produk/tembakau_rajangan_super.jpg',
                    'stok_status' => 'Tersedia',
                    'deskripsi' => 'Tembakau rajangan kering warna kuning keemasan, grade super ekspor.'
                ]
            );
        }

        $kecProppo = \App\Models\Kecamatan::where('nama_kecamatan', 'Proppo')->first();
        $katGudang = \App\Models\Kategori::where('nama_kategori', 'Gudang & Pengepul Tembakau')->first();
        $katBibit = \App\Models\Kategori::where('nama_kategori', 'Sentra Pembibitan & Saprotan Tembakau')->first();

        if ($kecProppo && $katGudang) {
            $umkm3 = \App\Models\Umkm::updateOrCreate(
                ['nama_umkm' => 'Gudang Tembakau Sumber Jaya Proppo'],
                [
                    'kecamatan_id' => $kecProppo->id,
                    'kategori_id' => $katGudang->id,
                    'nama_pemilik' => 'H. Moh. Ridwan',
                    'no_telepon' => '087812345678',
                    'alamat' => 'Jl. Raya Proppo KM 4, Kec. Proppo, Pamekasan',
                    'latitude' => -7.16542100,
                    'longitude' => 113.41258900,
                    'foto' => 'umkm/gudang_tembakau_proppo.jpg',
                    'kapasitas_produksi' => '25 ton penampungan / musim',
                    'jumlah_pekerja' => 18,
                    'deskripsi' => 'Pusat sortasi mutu daun tembakau dan distribusi tembakau kering petani ke pabrikan besar.',
                    'tahun_berdiri' => 2012,
                ]
            );

            \App\Models\Produk::updateOrCreate(
                ['nama_produk' => 'Tembakau Kering Sortir Grade A 1 Kg', 'umkm_id' => $umkm3->id],
                [
                    'harga' => 85000,
                    'foto' => 'produk/tembakau_kering_grade_a.jpg',
                    'stok_status' => 'Tersedia',
                    'deskripsi' => 'Tembakau mutu tinggi siap olah industri rokok.'
                ]
            );
        }

        if ($kecPamekasan && $katBibit) {
            $umkm4 = \App\Models\Umkm::updateOrCreate(
                ['nama_umkm' => 'Sentra Benih Tembakau Madura Unggul'],
                [
                    'kecamatan_id' => $kecPamekasan->id,
                    'kategori_id' => $katBibit->id,
                    'nama_pemilik' => 'Drs. Supriyadi, M.P.',
                    'no_telepon' => '082156789012',
                    'alamat' => 'Jl. Trunojoyo No. 88, Pamekasan Kota',
                    'latitude' => -7.15930000,
                    'longitude' => 113.47390000,
                    'foto' => 'umkm/sentra_benih_unggul.jpg',
                    'kapasitas_produksi' => '100.000 bibit polybag / musim',
                    'jumlah_pekerja' => 12,
                    'deskripsi' => 'Penyedia bibit unggul varietas Prancak-95 dan kemitraan kelompok tani tembakau.',
                    'tahun_berdiri' => 2020,
                ]
            );

            \App\Models\Produk::updateOrCreate(
                ['nama_produk' => 'Bibit Siap Tanam Prancak-95 (Pack 100 Batang)', 'umkm_id' => $umkm4->id],
                [
                    'harga' => 50000,
                    'foto' => 'produk/bibit_tembakau_prancak.jpg',
                    'stok_status' => 'Tersedia',
                    'deskripsi' => 'Bibit unggul tahan penyakit layu fusarium bersertifikasi.'
                ]
            );
        }
    }
}
