<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PusatKeCabang;
use Illuminate\Database\Eloquent\Builder;

class PusatKeCabangTable extends DataTableComponent
{
    protected $model = PusatKeCabang::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Kode", "kode")
                ->sortable(),
            Column::make("Id pusat", "id_pusat")
                ->sortable(),
            Column::make("Id status", "id_status")
                ->sortable(),
            Column::make("Id kurir", "id_kurir")
                ->sortable(),
            Column::make("Id cabang", "id_cabang")
                ->sortable(),
            Column::make("Id barang", "id_barang")
                ->sortable(),
            Column::make("Id satuan berat", "id_satuan_berat")
                ->sortable(),
            Column::make("Berat satuan barang", "berat_satuan_barang")
                ->sortable(),
            Column::make("Jumlah barang", "jumlah_barang")
                ->sortable(),
            Column::make("Tanggal", "tanggal")
                ->sortable(),
        ];
    }
}
