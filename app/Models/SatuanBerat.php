<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SatuanBerat extends Model
{
    /** @use HasFactory<\Database\Factories\SatuanBeratFactory> */
        /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_satuan_berat',
    ];
}
