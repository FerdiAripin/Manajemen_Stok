<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukLamaResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class ProdukLamaResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Manajemen Produk';
    protected static ?string $navigationLabel = 'Produk Lama';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_produk')
                ->required()
                ->label('Nama Produk'),

            Forms\Components\Select::make('kategori_id')
                ->relationship('kategori', 'nama_kategori')
                ->required()
                ->label('Kategori'),

            Forms\Components\TextInput::make('stok_awal')
                ->numeric()
                ->required()
                ->label('Stok'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_produk')->label('Nama Produk')->searchable(),
                Tables\Columns\TextColumn::make('kategori.nama_kategori')->label('Kategori'),
                Tables\Columns\TextColumn::make('stok_awal')->label('Stok'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->date('d M Y')
                    ->sortable(),

            ])
            ->defaultSort('nama_produk')
            ->modifyQueryUsing(fn($query) => $query->where('status', 'lama'))
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdukLamas::route('/'),
            'create' => Pages\CreateProdukLama::route('/create'),
            'edit' => Pages\EditProdukLama::route('/{record}/edit'),
        ];
    }
}
