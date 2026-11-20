<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori usaha
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $kategoris = Kategori::withCount('umkms')
            ->when($search, function ($query, $search) {
                $query->where('nama_kategori', 'like', "%{$search}%")
                      ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderBy('nama_kategori')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kategori.index', compact('kategoris', 'search'));
    }

    /**
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Menyimpan data kategori baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'ikon' => ['nullable', 'string', 'max:50'],
        ], [
            'nama_kategori.required' => 'Nama kategori usaha wajib diisi.',
        ]);

        if (empty($validated['ikon'])) {
            $validated['ikon'] = 'bi-tags';
        }

        Kategori::create($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori usaha "' . $validated['nama_kategori'] . '" berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kategori
     */
    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui data kategori
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'ikon' => ['nullable', 'string', 'max:50'],
        ], [
            'nama_kategori.required' => 'Nama kategori usaha wajib diisi.',
        ]);

        if (empty($validated['ikon'])) {
            $validated['ikon'] = 'bi-tags';
        }

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori usaha "' . $kategori->nama_kategori . '" berhasil diperbarui.');
    }

    /**
     * Menghapus data kategori
     */
    public function destroy(Kategori $kategori)
    {
        $nama = $kategori->nama_kategori;
        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori usaha "' . $nama . '" beserta data terkait berhasil dihapus.');
    }
}
