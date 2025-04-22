<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenerimaanBarang extends Model
{
    /** @use HasFactory<\Database\Factories\PenerimaanBarangFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_asal_barang',
        'id_tujuan_pengiriman',
        'id_gudang',
        'tanggal_penerimaan',
    ];

    protected $casts = [
        'tanggal_penerimaan' => 'datetime',
    ];

    public function lokasiAsal(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'id_asal_barang');
    }

    public function lokasiTujuan(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'id_tujuan_pengiriman');
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class, 'id_gudang');
    }

    public function detailPenerimaanBarang(): HasMany
    {
        return $this->hasMany(DetailPenerimaanBarang::class, 'id_penerimaan_barang');
    }
}
