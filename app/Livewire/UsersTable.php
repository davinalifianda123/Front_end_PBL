<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UsersTable extends DataTableComponent
{
    protected $model = User::class;

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
            Column::make("Nama user", "nama_user")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make("Id role", "id_role")
                ->sortable()
                ->searchable(),
            Column::make("Id lokasi", "id_lokasi")
                ->sortable()
                ->searchable(),
            Column::make("Action")
            ->label(fn($row, Column $column) => view('components.table-actions-user')->with([
                'row' => $row,
                'rute_lihat' => route('users.show', $row->id),
                'rute_edit' => route('users.edit', $row->id),
            ])),
        ];
    }

     public function builder(): Builder
    {
        return User::query()
            ->where('flag', 1);
    }
}
