<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class CabangKePusat extends Model
{
    /** @use HasFactory<\Database\Factories\KurirFactory> */
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
        'tanggal',
        'flag',
    ];

    public function pusat() : BelongsTo
    {
        return $this->belongsTo(GudangDanToko::class,
         'id_pusat');
    }

    public function cabang() : BelongsTo
    {
        return $this->belongsTo(GudangDanToko::class,
         'id_cabang');
    }

    public function barang() : BelongsTo
    {
        return $this->belongsTo(Barang::class,
         'id_barang');
    }
}
