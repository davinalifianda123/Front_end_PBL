<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierKePusat extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierKePusatFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode',
        'id_supplier',
        'id_pusat',
        'id_barang',
        'jumlah',
        'tanggal'
    ];
}
