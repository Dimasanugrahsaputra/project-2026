<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DetailPeminjamanResource\Pages;
use App\Models\Buku;
use App\Models\DetailPeminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DetailPeminjamanResource extends Resource
{
    protected static ?string $model = DetailPeminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Detail Peminjaman';

    protected static ?string $modelLabel = 'Detail Peminjaman';

    protected static ?string $pluralModelLabel = 'Detail Peminjaman';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Detail Peminjaman')
                    ->schema([
                        Forms\Components\Select::make('peminjaman_id')
                            ->label('Kode Peminjaman')
                            ->relationship('peminjaman', 'kode_peminjaman')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('buku_id')
                            ->label('Buku')
                            ->relationship(
                                name: 'buku',
                                titleAttribute: 'judul_buku',
                                modifyQueryUsing: fn (Builder $query) => $query->orderBy('judul_buku')
                            )
                            ->getOptionLabelFromRecordUsing(function (Buku $record): string {
                                return "{$record->kode_buku} - {$record->judul_buku}";
                            })
                            ->searchable([
                                'kode_buku',
                                'judul_buku',
                            ])
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('peminjaman.kode_peminjaman')
                    ->label('Kode Peminjaman')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('buku.kode_buku')
                    ->label('Kode Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('buku.judul_buku')
                    ->label('Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDetailPeminjamen::route('/'),
            'create' => Pages\CreateDetailPeminjaman::route('/create'),
            'edit' => Pages\EditDetailPeminjaman::route('/{record}/edit'),
        ];
    }
}
