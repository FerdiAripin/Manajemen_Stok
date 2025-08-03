<?php

namespace App\Filament\Resources\ProdukBaruResource\Pages;

use App\Filament\Resources\ProdukBaruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdukBaru extends EditRecord
{
    protected static string $resource = ProdukBaruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['status'] = 'baru';
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
