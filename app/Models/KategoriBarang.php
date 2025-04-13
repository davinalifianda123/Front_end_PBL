<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBarang extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriBarangFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_kategori'
    ];

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'id_kategori');
    }
}
