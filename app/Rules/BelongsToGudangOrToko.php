<?php

namespace App\Rules;

use Closure;
use App\Models\Toko;
use App\Models\Gudang;
use App\Models\Lokasi;
use Illuminate\Contracts\Validation\ValidationRule;

class BelongsToGudangOrToko implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $lokasi = Lokasi::where('id', $value)->first();

        if (!$lokasi) {
            $fail('ID Lokasi tidak ditemukan.');
            return;
        }

        if ($lokasi->id_gudang !== null) {
            if (!Gudang::where('id', $lokasi->id_gudang)->exists()) {
                $fail('ID tidak valid untuk Gudang.');
            }
            return;
        }

        if ($lokasi->id_toko !== null) {
            if (!Toko::where('id', $lokasi->id_toko)->exists()) {
                $fail('ID tidak valid untuk Toko.');
            }
            return;
        }

        $fail('ID Lokasi tidak terkait dengan Gudang atau Toko.');
    }
}
