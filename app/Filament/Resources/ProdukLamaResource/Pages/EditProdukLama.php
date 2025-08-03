<?php

namespace App\Filament\Resources\ProdukLamaResource\Pages;

use App\Filament\Resources\ProdukLamaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProdukLama extends EditRecord
{
    protected static string $resource = ProdukLamaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['status'] = 'lama';
        return $data;
    }
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
