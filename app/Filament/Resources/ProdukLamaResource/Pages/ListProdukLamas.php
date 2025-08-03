<?php

namespace App\Filament\Resources\ProdukLamaResource\Pages;

use App\Filament\Resources\ProdukLamaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProdukLamas extends ListRecords
{
    protected static string $resource = ProdukLamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTitle(): string
    {
        return 'Daftar Produk Lama';
    }

}
