<?php

namespace App\Filament\Resources\TransaksiStokResource\Pages;

use App\Filament\Resources\TransaksiStokResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransaksiStoks extends ListRecords
{
    protected static string $resource = TransaksiStokResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTitle(): string
    {
        return 'Manajemen Stok';
    }
}
