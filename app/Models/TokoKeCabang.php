<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TokoKeCabang extends Model
{
    /** @use HasFactory<\Database\Factories\TokoKeCabangFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode',
        'id_toko',
        'id_cabang',
        'id_barang',
        'jumlah',
        'tanggal',
    ];
}
