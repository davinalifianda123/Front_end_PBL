<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'id_gudang',
        'id_toko',
        'tanggal_pengiriman',
        'id_kurir',
        'id_status_pengiriman',
    ];

    protected $casts = [
        'tanggal_pengiriman' => 'datetime',
    ];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'id_gudang');
    }

    public function kurir()
    {
        return $this->belongsTo(Kurir::class, 'id_kurir');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'id_toko');
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
