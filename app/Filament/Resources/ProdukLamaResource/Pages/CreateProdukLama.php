<?php

namespace App\Filament\Resources\ProdukLamaResource\Pages;

use App\Filament\Resources\ProdukLamaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProdukLama extends CreateRecord
{
    protected static string $resource = ProdukLamaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = 'lama';
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
