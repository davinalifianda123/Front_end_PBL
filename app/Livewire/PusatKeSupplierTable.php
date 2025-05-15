<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PusatKeSupplier;

class PusatKeSupplierTable extends DataTableComponent
{
    protected $model = PusatKeSupplier::class;

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
            Column::make("Id supplier", "id_supplier")
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
