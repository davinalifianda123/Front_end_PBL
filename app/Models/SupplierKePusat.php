<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'tanggal',
        'flag'
    ];
    public function supplier(): BelongsTo 
    {
        return $this->belongsTo(GudangDanToko::Class,'id_supplier');
    }

    public function pusat(): BelongsTo 
    {
        return $this->belongsTo(GudangDanToko::Class, 'id_pusat');
    }

    public function barang(): BelongsTo 
    {
        return $this->belongsTo(Barang::Class,'id_barang');
    }

    



}
