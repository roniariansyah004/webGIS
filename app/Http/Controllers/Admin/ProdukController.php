<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk UMKM
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $umkmFilter = $request->query('umkm_id');

        $produks = Produk::with(['umkm.kecamatan', 'umkm.kategori'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_produk', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($umkmFilter, function ($query, $umkmId) {
                $query->where('umkm_id', $umkmId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $umkms = Umkm::orderBy('nama_umkm')->get();

        return view('admin.produk.index', compact('produks', 'umkms', 'search', 'umkmFilter'));
    }

    /**
     * Menampilkan form tambah produk
     */
    public function create(Request $request)
    {
        $umkms = Umkm::orderBy('nama_umkm')->get();
        $selectedUmkmId = $request->query('umkm_id');

        return view('admin.produk.create', compact('umkms', 'selectedUmkmId'));
    }

    /**
     * Menyimpan data produk baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'umkm_id' => ['required', 'exists:umkms,id'],
            'nama_produk' => ['required', 'string', 'max:150'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok_status' => ['required', 'string', 'in:Tersedia,Habis,Pre-Order'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'umkm_id.required' => 'Pilih UMKM produsen dari produk ini.',
            'umkm_id.exists' => 'UMKM yang dipilih tidak valid.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'harga.numeric' => 'Harga produk harus berupa nilai angka numerik.',
            'stok_status.required' => 'Pilih status ketersediaan stok.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('produk', 'public');
        }

        Produk::create($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk "' . $validated['nama_produk'] . '" berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit produk
     */
    public function edit(Produk $produk)
    {
        $umkms = Umkm::orderBy('nama_umkm')->get();

        return view('admin.produk.edit', compact('produk', 'umkms'));
    }

    /**
     * Memperbarui data produk
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'umkm_id' => ['required', 'exists:umkms,id'],
            'nama_produk' => ['required', 'string', 'max:150'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok_status' => ['required', 'string', 'in:Tersedia,Habis,Pre-Order'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'umkm_id.required' => 'Pilih UMKM produsen dari produk ini.',
            'umkm_id.exists' => 'UMKM yang dipilih tidak valid.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'harga.numeric' => 'Harga produk harus berupa nilai angka numerik.',
            'stok_status.required' => 'Pilih status ketersediaan stok.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $validated['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk "' . $produk->nama_produk . '" berhasil diperbarui.');
    }

    /**
     * Menghapus data produk
     */
    public function destroy(Produk $produk)
    {
        $nama = $produk->nama_produk;

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk "' . $nama . '" berhasil dihapus.');
    }
}
