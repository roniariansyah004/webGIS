<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kategori;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    /**
     * Menampilkan daftar UMKM
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kecamatanFilter = $request->query('kecamatan_id');
        $kategoriFilter = $request->query('kategori_id');

        $umkms = Umkm::with(['kecamatan', 'kategori', 'produks'])
            ->withCount('produks')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_umkm', 'like', "%{$search}%")
                      ->orWhere('nama_pemilik', 'like', "%{$search}%")
                      ->orWhere('alamat', 'like', "%{$search}%");
                });
            })
            ->when($kecamatanFilter, function ($query, $kecamatanId) {
                $query->where('kecamatan_id', $kecamatanId);
            })
            ->when($kategoriFilter, function ($query, $kategoriId) {
                $query->where('kategori_id', $kategoriId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.umkm.index', compact('umkms', 'kecamatans', 'kategoris', 'search', 'kecamatanFilter', 'kategoriFilter'));
    }

    /**
     * Menampilkan form tambah UMKM
     */
    public function create()
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.umkm.create', compact('kecamatans', 'kategoris'));
    }

    /**
     * Menyimpan data UMKM baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_umkm' => ['required', 'string', 'max:150'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama_pemilik' => ['nullable', 'string', 'max:100'],
            'no_telepon' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'tahun_berdiri' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'kapasitas_produksi' => ['nullable', 'string', 'max:150'],
            'jumlah_pekerja' => ['nullable', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'nama_umkm.required' => 'Nama UMKM wajib diisi.',
            'kecamatan_id.required' => 'Pilih kecamatan tempat UMKM berlokasi.',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak valid.',
            'kategori_id.required' => 'Pilih kategori bidang usaha UMKM.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'latitude.required' => 'Koordinat Latitude wajib diisi (gunakan Map Picker).',
            'latitude.numeric' => 'Nilai koordinat Latitude harus berupa format numerik/angka.',
            'longitude.required' => 'Koordinat Longitude wajib diisi (gunakan Map Picker).',
            'longitude.numeric' => 'Nilai koordinat Longitude harus berupa format numerik/angka.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto yang diizinkan: JPG, JPEG, PNG, WEBP.',
            'foto.max' => 'Ukuran file foto maksimal adalah 2 MB.',
        ]);

        // Upload foto jika diunggah
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        Umkm::create($validated);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'Data UMKM "' . $validated['nama_umkm'] . '" berhasil ditambahkan beserta titik koordinat GIS.');
    }

    /**
     * Menampilkan form edit UMKM
     */
    public function edit(Umkm $umkm)
    {
        $kecamatans = Kecamatan::orderBy('nama_kecamatan')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('admin.umkm.edit', compact('umkm', 'kecamatans', 'kategoris'));
    }

    /**
     * Memperbarui data UMKM
     */
    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'nama_umkm' => ['required', 'string', 'max:150'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'nama_pemilik' => ['nullable', 'string', 'max:100'],
            'no_telepon' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'tahun_berdiri' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'kapasitas_produksi' => ['nullable', 'string', 'max:150'],
            'jumlah_pekerja' => ['nullable', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'nama_umkm.required' => 'Nama UMKM wajib diisi.',
            'kecamatan_id.required' => 'Pilih kecamatan tempat UMKM berlokasi.',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak valid.',
            'kategori_id.required' => 'Pilih kategori bidang usaha UMKM.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'latitude.required' => 'Koordinat Latitude wajib diisi (gunakan Map Picker).',
            'latitude.numeric' => 'Nilai koordinat Latitude harus berupa format numerik/angka.',
            'longitude.required' => 'Koordinat Longitude wajib diisi (gunakan Map Picker).',
            'longitude.numeric' => 'Nilai koordinat Longitude harus berupa format numerik/angka.',
            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Format foto yang diizinkan: JPG, JPEG, PNG, WEBP.',
            'foto.max' => 'Ukuran file foto maksimal adalah 2 MB.',
        ]);

        // Penggantian foto jika ada file baru yang diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($umkm->foto && Storage::disk('public')->exists($umkm->foto)) {
                Storage::disk('public')->delete($umkm->foto);
            }
            $validated['foto'] = $request->file('foto')->store('umkm', 'public');
        }

        $umkm->update($validated);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'Data UMKM "' . $umkm->nama_umkm . '" berhasil diperbarui.');
    }

    /**
     * Menghapus data UMKM
     */
    public function destroy(Umkm $umkm)
    {
        $nama = $umkm->nama_umkm;

        // Hapus foto dari storage
        if ($umkm->foto && Storage::disk('public')->exists($umkm->foto)) {
            Storage::disk('public')->delete($umkm->foto);
        }

        $umkm->delete();

        return redirect()->route('admin.umkm.index')
            ->with('success', 'Data UMKM "' . $nama . '" beserta produk terkait berhasil dihapus.');
    }
}
