<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PusatKeCabang extends Model
{
   /** @use HasFactory<\Database\Factories\PusatKeCabangFactory> */
    use HasFactory, SoftDeletes; 


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode',
        'id_pusat',
        'id_cabang',
        'id_barang',
        'jumlah',
        'tanggal'
    ];
}
