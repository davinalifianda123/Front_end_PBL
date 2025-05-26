<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PenerimaanDiCabang;

class PenerimaanDiCabangTable extends DataTableComponent
{
    protected $model = PenerimaanDiCabang::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Id jenis penerimaan", "id_jenis_penerimaan")
                ->sortable(),
            Column::make("Id asal barang", "id_asal_barang")
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
            Column::make("Flag", "flag")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
