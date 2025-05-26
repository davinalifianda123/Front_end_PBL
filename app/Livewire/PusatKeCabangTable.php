<?php

namespace App\Livewire;

use App\Models\PusatKeCabang;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PusatKeCabangTable extends DataTableComponent
{
    protected $model = PusatKeCabang::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchDebounce(500);
        $this->setTableAttributes([
            'class' => 'w-full text-sm text-left text-gray-700 rounded-xl overflow-hidden shadow-md',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable()
                ->format(fn($value) => '#' . $value)
                ->searchable(),

            Column::make("Asal Barang", "id_pusat")
                ->sortable()
                ->format(fn($value, $row) => $row->pusat->nama ?? '-'),

            Column::make("Tujuan Pengiriman", "id_cabang")
                ->sortable()
                ->format(fn($value, $row) => $row->cabang->nama ?? '-'),

            Column::make("Kurir", "id_kurir")
                ->sortable()
                ->format(fn($value, $row) => $row->kurir->nama ?? '-'),

            Column::make("Status", "id_status")
                ->sortable()
                ->format(function ($value) {
                    $statusText = match($value) {
                        1 => 'Selesai',
                        2 => 'Proses',
                        default => 'Pending',
                    };

                    $badgeClass = match($value) {
                        1 => 'bg-green-100 text-green-800',
                        2 => 'bg-yellow-100 text-yellow-800',
                        default => 'bg-gray-200 text-gray-800',
                    };

                    return new HtmlString("<span class='px-3 py-1 rounded-full text-xs font-semibold $badgeClass'>$statusText</span>");
                }),

            Column::make("Jumlah", "jumlah_barang")
                ->sortable(),

           Column::make("Action")
                ->label(fn($row, Column $column) => view('components.table-actions-pengiriman')->with([
                    'row' => $row,
                    'rute_lihat' => route('pusat-ke-cabang.show', $row->id),
                    'rute_edit' => route('pusat-ke-cabang.edit', $row->id),
                    
                ])),
            
        
        ];
    }
}
