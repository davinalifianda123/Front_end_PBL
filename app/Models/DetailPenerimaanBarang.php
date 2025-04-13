<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPenerimaanBarang extends Model
{
    /** @use HasFactory<\Database\Factories\DetailPenerimaanBarangFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_penerimaan_barang',
        'id_barang',
        'jumlah',
        'harga_beli',
    ];

    public function penerimaanBarang(): BelongsTo
    {
        return $this->belongsTo(PenerimaanBarang::class, 'id_penerimaan_barang');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
