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
        'id_supplier',
        'id_gudang',
        'tanggal_penerimaan',
    ];

    protected $casts = [
        'tanggal_penerimaan' => 'datetime',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'id_supplier');
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
