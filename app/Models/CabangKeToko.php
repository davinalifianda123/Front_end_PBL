<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CabangKeToko extends Model
{
    /** @use HasFactory<\Database\Factories\CabangKeTokoFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode',
        'id_cabang',
        'id_toko',
        'id_barang',
        'jumlah',
        'tanggal',
        'flag',
    ];

    public function cabang()
    {
        return $this->belongsTo(GudangDanToko::class, 'id_cabang');
    }

    public function toko()
    {
        return $this->belongsTo(GudangDanToko::class, 'id_toko');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
