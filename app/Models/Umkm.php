<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkms';

    protected $fillable = [
        'kecamatan_id',
        'kategori_id',
        'nama_umkm',
        'nama_pemilik',
        'no_telepon',
        'alamat',
        'latitude',
        'longitude',
        'foto',
        'deskripsi',
        'kapasitas_produksi',
        'jumlah_pekerja',
        'tahun_berdiri',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'tahun_berdiri' => 'integer',
    ];

    /**
     * Relasi ke Kecamatan
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * Relasi ke Kategori
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke Produk olahan UMKM
     */
    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class, 'umkm_id');
    }

    /**
     * Accessor untuk URL foto
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
                return $this->foto;
            }
            if (Storage::disk('public')->exists($this->foto)) {
                return asset('storage/' . $this->foto);
            }
        }

        // Fallback cerdas sesuai kategori usaha tembakau
        $catName = strtolower($this->kategori->nama_kategori ?? '');
        if (str_contains($catName, 'pabrik')) {
            return asset('storage/umkm/pabrik_rokok_berkah.jpg');
        } elseif (str_contains($catName, 'rajangan')) {
            return asset('storage/umkm/sentra_rajangan_pakong.jpg');
        } elseif (str_contains($catName, 'gudang') || str_contains($catName, 'pengepul')) {
            return asset('storage/umkm/gudang_tembakau_proppo.jpg');
        } elseif (str_contains($catName, 'bibit') || str_contains($catName, 'benih')) {
            return asset('storage/umkm/sentra_benih_unggul.jpg');
        }

        return asset('storage/umkm/gudang_tembakau_proppo.jpg');
    }
}
