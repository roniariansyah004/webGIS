<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'ikon',
    ];

    /**
     * Relasi ke data UMKM dalam kategori ini
     */
    public function umkms(): HasMany
    {
        return $this->hasMany(Umkm::class, 'kategori_id');
    }
}
