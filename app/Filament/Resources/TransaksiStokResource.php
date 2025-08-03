<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiStokResource\Pages;
use App\Models\TransaksiStok;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransaksiStokResource extends Resource
{
    protected static ?string $model = TransaksiStok::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationGroup = 'Manajemen Produk';
    protected static ?string $navigationLabel = 'Manajemen Stok';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->label('Tanggal'),

                Forms\Components\Select::make('produk_id')
                    ->relationship('produk', 'nama_produk')
                    ->required()
                    ->label('Produk'),

                Forms\Components\Select::make('tipe')
                    ->options([
                        'masuk' => 'Masuk',
                        'keluar' => 'Keluar',
                    ])
                    ->required()
                    ->label('Tipe Transaksi'),

                Forms\Components\TextInput::make('jumlah')
                    ->numeric()
                    ->required()
                    ->label('Jumlah'),

                Forms\Components\Textarea::make('keterangan')
                    ->rows(2)
                    ->label('Keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->label('Tanggal'),
                Tables\Columns\TextColumn::make('produk.nama_produk')->label('Produk'),
                Tables\Columns\BadgeColumn::make('tipe')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'masuk',
                        'danger' => 'keluar',
                    ]),
                Tables\Columns\TextColumn::make('jumlah')->label('Jumlah'),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan')->limit(30),
            ])
            ->defaultSort('tanggal', 'desc')
            ->filters([])
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
            'index' => Pages\ListTransaksiStoks::route('/'),
            'create' => Pages\CreateTransaksiStok::route('/create'),
            'edit' => Pages\EditTransaksiStok::route('/{record}/edit'),
        ];
    }
}
