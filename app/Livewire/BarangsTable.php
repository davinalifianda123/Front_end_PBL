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

        // Tabel
        $this->setTableAttributes([
            'class' => 'w-full text-sm text-left rtl:text-right text-[#111827] bg-white',
        ]);

        // Header kolom
        $this->setTheadAttributes([
            'class' => 'text-xs uppercase bg-[#fcfcfc] text-[#687588] text-center',
        ]);        
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
                ->label(fn($row) => view('components.badge-status', ['flag' => $row->flag])),

            Column::make("Action")
                 ->label(fn($row, Column $column) => view('components.table-actions-barang')->with([
                    'row' => $row,
                    'rute_lihat' => route('barangs.show', $row->id),
                    'rute_edit' => route('barangs.edit', $row->id),
                    'rute_deactivate' => route('barangs.deactivate', $row->id),
                    'rute_activate' => route('barangs.activate', $row->id),
                ])),
        ];
    }
}