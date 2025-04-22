<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPengirimanBarang extends Model
{
    /** @use HasFactory<\Database\Factories\DetailPengirimanBarangFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_pengiriman_barang',
        'id_barang',
        'jumlah',
        'flag',
        // 'harga_jual_satuan',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function pengirimanBarang(): BelongsTo
    {
        return $this->belongsTo(PengirimanBarang::class, 'id_pengiriman_barang');
    }
}
