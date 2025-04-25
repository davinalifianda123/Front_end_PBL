<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenerimaanDiCabang extends Model
{
    /** @use HasFactory<\Database\Factories\PenerimaanDiCabangFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_jenis_penerimaan',
        'id_asal_barang',
        'id_barang',
        'jumlah',
        'tanggal',
    ];
}
