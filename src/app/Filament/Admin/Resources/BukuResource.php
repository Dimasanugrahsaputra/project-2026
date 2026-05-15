<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BukuResource\Pages;
use App\Models\Buku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Buku';

    protected static ?string $modelLabel = 'Buku';

    protected static ?string $pluralModelLabel = 'Buku';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Buku')
                    ->schema([
                        Forms\Components\TextInput::make('kode_buku')
                            ->label('Kode Buku')
                            ->default(fn () => 'BK-' . now()->format('YmdHis'))
                            ->required()
                            ->unique(
                                table: 'bukus',
                                column: 'kode_buku',
                                ignoreRecord: true
                            )
                            ->maxLength(255),

                        Forms\Components\TextInput::make('judul')
                            ->label('Judul Buku')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('kategori_buku_id')
                            ->label('Kategori Buku')
                            ->relationship('kategoriBuku', 'nama_kategori')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('rak_buku_id')
                            ->label('Rak Buku')
                            ->relationship('rakBuku', 'nama_rak')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('penulis')
                            ->label('Penulis')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('penerbit')
                            ->label('Penerbit')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('tahun_terbit')
                            ->label('Tahun Terbit')
                            ->numeric()
                            ->required()
                            ->minValue(1900)
                            ->maxValue((int) now()->year),

                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->unique(
                                table: 'bukus',
                                column: 'isbn',
                                ignoreRecord: true
                            )
                            ->maxLength(255),

                        Forms\Components\TextInput::make('stok')
                            ->label('Stok')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->minValue(0),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
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
                Tables\Columns\TextColumn::make('kode_buku')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategoriBuku.nama_kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('rakBuku.nama_rak')
                    ->label('Rak')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('penulis')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
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
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }
}
