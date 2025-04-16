<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gudang extends Model
{
    /** @use HasFactory<\Database\Factories\GudangFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_gudang',
        'lokasi',
        'flag'
    ];

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_gudang');
    }

    public function pengirimanBarangs(): HasMany
    {
        return $this->hasMany(PengirimanBarang::class, 'id_pengiriman_barang');
    }
}
