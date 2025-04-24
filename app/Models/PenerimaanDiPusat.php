<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenerimaanDiPusat extends Model
{
    /** @use HasFactory<\Database\Factories\KurirFactory> */
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
        'tanggal'
    ];
}
