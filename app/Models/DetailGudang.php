<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
>>>>>>> 95b39c10ea76bb9a4e707428240fd6e561b0887f

class DetailGudang extends Model
{
    /** @use HasFactory<\Database\Factories\KurirFactory> */
    use HasFactory, SoftDeletes;
    /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $fillable = [
        'id_gudang',
        'id_barang',
        'jumlah_stok',
        'stok_opname'
    ];

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(GudangDanToko::class, 'id_gudang');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
