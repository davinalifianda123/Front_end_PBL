<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Builder;

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
                ->sortable()
                ->searchable(),
            Column::make("Nama barang", "nama_barang")
                ->sortable()
                ->searchable(),
            Column::make("Id kategori barang", "id_kategori_barang")
                ->sortable()
                ->searchable(),
            Column::make("Status", "flag")
                ->format(fn($value, $row, Column $column) => view('components.badge-status')->with("flag", $row->flag)),
            Column::make("Action")
                 ->label(fn($row, Column $column) => view('components.table-actions-barang')->with([
                    'row' => $row,
                    'rute_lihat' => route('barangs.show', $row->id),
                    'rute_edit' => route('barangs.edit', $row->id),
                ])),
        ];
    }
}