<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengirimanBarang extends Model
{
    /** @use HasFactory<\Database\Factories\PengirimanBarangFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_asal_barang',
        'id_tujuan_pengiriman',
        'tanggal_pengiriman',
        'id_kurir',
        'id_status_pengiriman',
        'flag',
    ];

    protected $casts = [
        'tanggal_pengiriman' => 'datetime',
    ];

    public function lokasiAsal()
    {
        return $this->belongsTo(Lokasi::class, 'id_asal_barang');
    }

    public function lokasiTujuan()
    {
        return $this->belongsTo(Lokasi::class, 'id_tujuan_pengiriman');
    }

    public function kurir(): BelongsTo
    {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }

    public function statusPengiriman()
    {
        return $this->belongsTo(StatusPengirimanBarang::class, 'id_status_pengiriman');
    }

    public function detailPengirimanBarangs()
    {
        return $this->hasMany(DetailPengirimanBarang::class, 'id_pengiriman_barang');
    }
}
