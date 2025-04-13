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
        'id_tujuan_pengiriman',
        'tanggal_pengiriman',
        'id_kurir',
        'id_status_pengiriman',
    ];
}
