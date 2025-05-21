<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\GudangDanToko;
use Illuminate\Database\Eloquent\Builder;

class TokosTable extends DataTableComponent
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
            Column::make("Kategori bangunan", "kategori_bangunan")
                ->sortable()
                ->searchable(),
            Column::make("Alamat", "alamat")
                ->sortable()
                ->searchable(),
            Column::make("No telepon", "no_telepon")
                ->sortable()
                ->searchable(),
            Column::make("Action")
                 ->label(fn($row, Column $column) => view('components.table-actions-barang')->with([
                    'row' => $row,
                    'rute_lihat' => route('tokos.show', $row->id),
                    'rute_edit' => route('tokos.edit', $row->id),
                    'rute_deactivate' => route('tokos.deactivate', $row->id),
                    'rute_activate' => route('tokos.activate', $row->id),
                ])),
            
        ];
    }

    public function builder(): Builder
    {
        return GudangDanToko::query()
            ->where('kategori_bangunan', 2);
    }
}
