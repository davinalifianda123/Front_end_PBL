<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    /** @use HasFactory<\Database\Factories\BarangFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_barang',
        'id_kategori',
        'id_parent_barang',
        'id_gudang',
        'id_toko',
        'jumlah_stok',
        'berat',
        'flag'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori');
    }

    public function parentBarang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_parent_barang');
    }

    public function childBarang(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_parent_barang');
    }
    
    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class, 'id_gudang');
    }

    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'id_toko');
    }

    public function detailPengirimanBarang(): HasMany
    {
        return $this->hasMany(DetailPenerimaanBarang::class, 'id_barang');
    }
}
