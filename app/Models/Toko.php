<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Toko extends Model
{
    /** @use HasFactory<\Database\Factories\TokoFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_toko',
        'id_jenis_toko',
        'alamat',
        'no_telepon',
        'flag'
    ];

    public function jenisToko(): BelongsTo
    {
        return $this->belongsTo(JenisToko::class, 'id_jenis_toko');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_toko');
    }
}
