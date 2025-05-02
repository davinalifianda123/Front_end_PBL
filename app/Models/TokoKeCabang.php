<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'flag'
    ];

    public function toko(): BelongsTo
    {
        return $this->belongsTo(GudangDanToko::class,
        'id_toko');
    }

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(GudangDanToko::class,
        'id_cabang');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class,
        'id_barang');
    }

}
