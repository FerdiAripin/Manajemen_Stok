<?php

namespace App\Filament\Resources\ProdukBaruResource\Pages;

use App\Filament\Resources\ProdukBaruResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProdukBaru extends CreateRecord
{
    protected static string $resource = ProdukBaruResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'baru';
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
