<?php

namespace App\Filament\Resources\ProdukBaruResource\Pages;

use App\Filament\Resources\ProdukBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProdukBarus extends ListRecords
{
    protected static string $resource = ProdukBaruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
   }
   public function getTitle(): string
    {
        return 'Daftar Produk Baru';
    }
}
