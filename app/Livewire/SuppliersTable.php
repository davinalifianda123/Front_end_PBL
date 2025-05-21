<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\GudangDanToko;
use Illuminate\Database\Eloquent\Builder;

class SuppliersTable extends DataTableComponent
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
            Column::make("Nama Supplier", "nama_gudang_toko")
                ->sortable()
                ->searchable(),
            Column::make("Alamat", "alamat")
                ->sortable()
                ->searchable(),
            Column::make("No telepon", "no_telepon")
                ->sortable()
                ->searchable(),
            Column::make("Action")
            ->label(fn($row, Column $column) => view('components.table-actions-suppliers')->with([
                'row' => $row,
                'rute_lihat' => route('suppliers.show', $row->id),
                'rute_edit' => route('suppliers.edit', $row->id),
            ])),
        ];
    }

    public function builder(): Builder
    {
        return GudangDanToko::query()
            ->where('kategori_bangunan', 1)
            ->where('flag', 1);
    }
}
