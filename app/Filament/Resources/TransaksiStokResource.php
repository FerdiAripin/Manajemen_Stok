<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produk;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TransaksiStok;
use Filament\Resources\Resource;
use App\Filament\Resources\TransaksiStokResource\Pages;

class TransaksiStokResource extends Resource
{
    protected static ?string $model = TransaksiStok::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationGroup = 'Manajemen Produk';
    protected static ?string $navigationLabel = 'Manajemen Stok';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // 1. Pilih Status Produk
            Forms\Components\Select::make('status_produk')
                ->label('Status Produk')
                ->options([
                    'baru' => 'Produk Baru',
                    'lama' => 'Produk Lama',
                ])
                ->required()
                ->reactive()
                ->dehydrated(false) // tidak ikut disimpan ke database
                ->afterStateUpdated(fn ($state, callable $set) => [
                    $set('kategori_id', null),
                    $set('produk_id', null),
                ]),

            // 2. Pilih Kategori
            Forms\Components\Select::make('kategori_id')
                ->label('Kategori')
                ->options(fn () => Kategori::pluck('nama_kategori', 'id'))
                ->required()
                ->reactive()
                ->disabled(fn ($get) => !$get('status_produk'))
                ->afterStateUpdated(fn ($state, callable $set) => $set('produk_id', null)),

            // 3. Pilih Produk (filtered by status & kategori)
            Forms\Components\Select::make('produk_id')
                ->label('Produk')
                ->options(function ($get) {
                    $status = $get('status_produk');
                    $kategoriId = $get('kategori_id');

                    return $status && $kategoriId
                        ? Produk::where('status', $status)
                            ->where('kategori_id', $kategoriId)
                            ->get()
                            ->pluck('nama_produk', 'id')
                        : [];
                })
                ->required()
                ->searchable()
                ->disabled(fn ($get) => !$get('kategori_id') || !$get('status_produk'))
                ->reactive(),

            // 4. Tanggal, Tipe, Jumlah, Keterangan
            Forms\Components\DatePicker::make('tanggal')
                ->required()
                ->label('Tanggal'),

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
                Tables\Columns\TextColumn::make('tanggal')
                    ->date('d M Y')
                    ->label('Tanggal'),

                Tables\Columns\TextColumn::make('produk.nama_produk')
                    ->label('Produk'),

                Tables\Columns\TextColumn::make('produk.kategori.nama_kategori')
                    ->label('Kategori'),

                Tables\Columns\TextColumn::make('produk.status')
                    ->label('Status Produk')
                    ->badge()
                    ->colors([
                        'success' => 'baru',
                        'gray' => 'lama',
                    ]),

                Tables\Columns\BadgeColumn::make('tipe')
                    ->label('Tipe Transaksi')
                    ->colors([
                        'success' => 'masuk',
                        'danger' => 'keluar',
                    ]),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30),
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
