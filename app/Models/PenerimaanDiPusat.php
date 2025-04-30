<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
<<<<<<< HEAD

=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;
>>>>>>> 95b39c10ea76bb9a4e707428240fd6e561b0887f
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

    public function jenisPenerimaan(): BelongsTo
    {
        return $this->belongsTo(JenisPenerimaan::class, 'id_jenis_penerimaan');
    }

    public function asalBarang(): BelongsTo
    {
        return $this->belongsTo(GudangDanToko::class, 'id_asal_barang');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
