<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisToko extends Model
{
    /** @use HasFactory<\Database\Factories\JenisTokoFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_toko',
        'flag'
    ];

    public function tokos(): HasMany
    {
        return $this->hasMany(Toko::class, 'id_jenis_toko');
    }
}
