<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturBarang extends Model
{
    /** @use HasFactory<\Database\Factories\ReturBarangFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_pengiriman_barang',
        'id_barang',
        'id_user',
        'tanggal_retur',
        'alasan_retur',
        'status_retur'
    ];
}
