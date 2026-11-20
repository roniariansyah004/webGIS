<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans';

    protected $fillable = [
        'nama_kecamatan',
        'kode_kecamatan',
        'warna_wilayah',
        'deskripsi',
        'geojson',
    ];

    /**
     * Relasi ke data UMKM di kecamatan ini
     */
    public function umkms(): HasMany
    {
        return $this->hasMany(Umkm::class, 'kecamatan_id');
    }
}
