<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PusatKeSupplier extends Model
{
    use HasFactory,SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kode',
        'id_pusat',
        'id_supplier',
        'id_barang',
        'jumlah',
        'tanggal',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
    public function pusat()
    {
        return $this->belongsTo(GudangDanToko::class, 'id_pusat');
    }
    public function supplier()
    {
        return $this->belongsTo(GudangDanToko::class, 'id_supplier');
    }
}
