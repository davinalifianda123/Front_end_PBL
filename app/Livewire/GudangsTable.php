<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\GudangDanToko;
use Illuminate\Database\Eloquent\Builder;


class GudangsTable extends DataTableComponent
{
    protected $model = GudangDanToko::class;

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
            Column::make("Nama gudang toko", "nama_gudang_toko")
                ->sortable()
                ->searchable(),
            Column::make("Alamat", "alamat")
                ->sortable()
                ->searchable(),
            Column::make("No telepon", "no_telepon")
                ->sortable()
                ->searchable(),
           Column::make("Action")
                ->label(fn($row, Column $column) => view('components.table-actions-gudang')->with([
                    'row' => $row,
                    'rute_lihat' => route('gudangs.show', $row->id),
                    'rute_edit' => route('gudangs.edit', $row->id),
                ])),
        ];
    }

    public function builder(): Builder
    {
        return GudangDanToko::query()
            ->where('kategori_bangunan', 0)
            ->where('flag', 1);   
    }
}
