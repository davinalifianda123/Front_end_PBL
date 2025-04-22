<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturBarang extends Model
{
    /** @use HasFactory<\Database\Factories\ReturBarangFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_pengiriman_barang',
        'id_barang',
        'id_penanggung_jawab',
        'tanggal_retur',
        'alasan_retur',
        'id_status_retur',
        'flag'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_penanggung_jawab');
    }
    
    public function statusRetur()
    {
        return $this->belongsTo(StatusRetur::class, 'id_status_retur');
    }
    
    public function pengirimanBarang()
    {
        return $this->belongsTo(PengirimanBarang::class, 'id_pengiriman_barang');
    }
    
    public function detailReturBarangs()
    {
        return $this->hasMany(DetailReturBarang::class, 'id_retur');
    }
}
