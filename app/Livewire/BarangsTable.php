<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Barang;

class BarangsTable extends DataTableComponent
{
    protected $model = Barang::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nama barang", "nama_barang")
                ->sortable(),
            Column::make("Id kategori barang", "id_kategori_barang")
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
