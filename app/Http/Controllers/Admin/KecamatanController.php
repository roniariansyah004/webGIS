<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KecamatanController extends Controller
{
    /**
     * Menampilkan daftar kecamatan
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        
        $kecamatans = Kecamatan::withCount('umkms')
            ->when($search, function ($query, $search) {
                $query->where('nama_kecamatan', 'like', "%{$search}%")
                      ->orWhere('kode_kecamatan', 'like', "%{$search}%");
            })
            ->orderBy('nama_kecamatan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kecamatan.index', compact('kecamatans', 'search'));
    }

    /**
     * Menampilkan form tambah kecamatan
     */
    public function create()
    {
        return view('admin.kecamatan.create');
    }

    /**
     * Menyimpan data kecamatan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kecamatan' => ['required', 'string', 'max:100'],
            'kode_kecamatan' => ['nullable', 'string', 'max:50', 'unique:kecamatans,kode_kecamatan'],
            'warna_wilayah' => ['required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'geojson' => ['nullable', 'string'],
        ], [
            'nama_kecamatan.required' => 'Nama kecamatan wajib diisi.',
            'kode_kecamatan.unique' => 'Kode wilayah kecamatan sudah terdaftar.',
            'warna_wilayah.required' => 'Warna wilayah peta wajib dipilih.',
        ]);

        Kecamatan::create($validated);

        return redirect()->route('admin.kecamatan.index')
            ->with('success', 'Data Kecamatan "' . $validated['nama_kecamatan'] . '" berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kecamatan
     */
    public function edit(Kecamatan $kecamatan)
    {
        return view('admin.kecamatan.edit', compact('kecamatan'));
    }

    /**
     * Memperbarui data kecamatan
     */
    public function update(Request $request, Kecamatan $kecamatan)
    {
        $validated = $request->validate([
            'nama_kecamatan' => ['required', 'string', 'max:100'],
            'kode_kecamatan' => [
                'nullable', 
                'string', 
                'max:50', 
                Rule::unique('kecamatans', 'kode_kecamatan')->ignore($kecamatan->id)
            ],
            'warna_wilayah' => ['required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'geojson' => ['nullable', 'string'],
        ], [
            'nama_kecamatan.required' => 'Nama kecamatan wajib diisi.',
            'kode_kecamatan.unique' => 'Kode wilayah kecamatan sudah digunakan oleh data lain.',
            'warna_wilayah.required' => 'Warna wilayah peta wajib dipilih.',
        ]);

        $kecamatan->update($validated);

        return redirect()->route('admin.kecamatan.index')
            ->with('success', 'Data Kecamatan "' . $kecamatan->nama_kecamatan . '" berhasil diperbarui.');
    }

    /**
     * Menghapus data kecamatan
     */
    public function destroy(Kecamatan $kecamatan)
    {
        $nama = $kecamatan->nama_kecamatan;
        $kecamatan->delete();

        return redirect()->route('admin.kecamatan.index')
            ->with('success', 'Data Kecamatan "' . $nama . '" beserta data terkait berhasil dihapus.');
    }
}
