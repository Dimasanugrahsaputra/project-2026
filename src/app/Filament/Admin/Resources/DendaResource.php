<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DendaResource\Pages;
use App\Models\Denda;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DendaResource extends Resource
{
    protected static ?string $model = Denda::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Denda';

    protected static ?string $modelLabel = 'Denda';

    protected static ?string $pluralModelLabel = 'Denda';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Denda')
                    ->schema([
                        Forms\Components\Select::make('pengembalian_buku_id')
                            ->label('Pengembalian Buku')
                            ->relationship('pengembalianBuku', 'kode_pengembalian')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('jumlah_denda')
                            ->label('Jumlah Denda')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\TextInput::make('jumlah_dibayar')
                            ->label('Jumlah Dibayar')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\Select::make('status_pembayaran')
                            ->label('Status Pembayaran')
                            ->options([
                                'belum_lunas' => 'Belum Lunas',
                                'lunas' => 'Lunas',
                            ])
                            ->required()
                            ->default('belum_lunas'),

                        Forms\Components\DatePicker::make('tanggal_pembayaran')
                            ->label('Tanggal Pembayaran')
                            ->nullable(),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pengembalianBuku.kode_pengembalian')
                    ->label('Kode Pengembalian')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_denda')
                    ->label('Jumlah Denda')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_dibayar')
                    ->label('Jumlah Dibayar')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status_pembayaran')
                    ->label('Status')
                    ->colors([
                        'danger' => 'belum_lunas',
                        'success' => 'lunas',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'belum_lunas' => 'Belum Lunas',
                        'lunas' => 'Lunas',
                        default => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('tanggal_pembayaran')
                    ->label('Tanggal Pembayaran')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->options([
                        'belum_lunas' => 'Belum Lunas',
                        'lunas' => 'Lunas',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Hapus Data Terpilih'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDendas::route('/'),
            'create' => Pages\CreateDenda::route('/create'),
            'edit' => Pages\EditDenda::route('/{record}/edit'),
        ];
    }
}
