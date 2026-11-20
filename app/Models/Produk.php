<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'umkm_id',
        'nama_produk',
        'harga',
        'foto',
        'stok_status',
        'deskripsi',
    ];

    protected $casts = [
        'harga' => 'float',
    ];

    /**
     * Relasi ke UMKM produsen
     */
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }

    /**
     * Accessor URL Foto
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

        $prodName = strtolower($this->nama_produk ?? '');
        if (str_contains($prodName, 'rokok')) {
            return asset('storage/produk/rokok_kretek_madura.jpg');
        } elseif (str_contains($prodName, 'rajangan')) {
            return asset('storage/produk/tembakau_rajangan_super.jpg');
        } elseif (str_contains($prodName, 'kering') || str_contains($prodName, 'daun')) {
            return asset('storage/produk/tembakau_kering_grade_a.jpg');
        } elseif (str_contains($prodName, 'bibit') || str_contains($prodName, 'benih')) {
            return asset('storage/produk/bibit_tembakau_prancak.jpg');
        }

        return asset('storage/produk/tembakau_rajangan_super.jpg');
    }
}
