<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PenerimaanDiPusat;
use Illuminate\Database\Eloquent\Builder;

class PenerimaanDiPusatTable extends DataTableComponent
{
    protected $model = PenerimaanDiPusat::class;

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
        ];
    }

    public function builder(): Builder
    {
        return PenerimaanDiPusat::query()
            ->where('id_jenis_penerimaan', 1);
    }
}
