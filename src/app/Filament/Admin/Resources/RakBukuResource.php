<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RakBukuResource\Pages;
use App\Models\RakBuku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RakBukuResource extends Resource
{
    protected static ?string $model = RakBuku::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Rak Buku';

    protected static ?string $modelLabel = 'Rak Buku';

    protected static ?string $pluralModelLabel = 'Rak Buku';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Rak Buku')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Rak')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('kode_rak')
                            ->label('Kode Rak')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('lokasi')
                            ->label('Lokasi Rak')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Rak')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kode_rak')
                    ->label('Kode Rak')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            'index' => Pages\ListRakBukus::route('/'),
            'create' => Pages\CreateRakBuku::route('/create'),
            'edit' => Pages\EditRakBuku::route('/{record}/edit'),
        ];
    }
}
