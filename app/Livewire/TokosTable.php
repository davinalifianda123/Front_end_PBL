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
                ->sortable(),
            Column::make("Nama gudang toko", "nama_gudang_toko")
                ->sortable(),
            Column::make("Kategori bangunan", "kategori_bangunan")
                ->sortable(),
            Column::make("Alamat", "alamat")
                ->sortable(),
            Column::make("No telepon", "no_telepon")
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return GudangDanToko::query()
            ->where('kategori_bangunan', 2);
    }
}
