<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BukuResource\Pages;
use App\Models\Buku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BukuResource extends Resource
{
    protected static ?string $model = Buku::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Buku';

    protected static ?string $modelLabel = 'Buku';

    protected static ?string $pluralModelLabel = 'Buku';

    protected static ?string $slug = 'bukus';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canView(Model $record): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit(Model $record): bool
    {
        return true;
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }

    public static function canDeleteAny(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Buku')
                    ->schema([
                        Forms\Components\TextInput::make('kode_buku')
                            ->label('Kode Buku')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('Contoh: BK001'),

                        Forms\Components\TextInput::make('judul_buku')
                            ->label('Judul Buku')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Belajar Laravel'),

                        Forms\Components\TextInput::make('penulis')
                            ->label('Penulis')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Dimas'),

                        Forms\Components\TextInput::make('penerbit')
                            ->label('Penerbit')
                            ->maxLength(255)
                            ->placeholder('Contoh: Gramedia'),

                        Forms\Components\TextInput::make('tahun_terbit')
                            ->label('Tahun Terbit')
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue((int) date('Y'))
                            ->placeholder('Contoh: 2024'),

                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->maxLength(255)
                            ->placeholder('Contoh: 978-602-1234-56-7'),

                        Forms\Components\TextInput::make('stok')
                            ->label('Stok')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->minValue(0),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Kategori dan Lokasi')
                    ->schema([
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
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Cover dan Deskripsi')
                    ->schema([
                        Forms\Components\TextInput::make('cover')
                            ->label('URL Cover Buku')
                            ->url()
                            ->maxLength(1000)
                            ->placeholder('https://contoh.com/cover-buku.jpg'),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
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

                Tables\Columns\TextColumn::make('judul_buku')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable()
                    ->limit(35),

                Tables\Columns\TextColumn::make('penulis')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategoriBuku.nama_kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('rakBuku.nama_rak')
                    ->label('Rak')
                    ->searchable()
                    ->sortable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('tahun_terbit')
                    ->label('Tahun')
                    ->sortable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->badge()
                    ->sortable()
                    ->color(fn ($state): string => (int) $state > 0 ? 'success' : 'danger'),

                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_buku_id')
                    ->label('Kategori')
                    ->relationship('kategoriBuku', 'nama_kategori'),

                Tables\Filters\SelectFilter::make('rak_buku_id')
                    ->label('Rak')
                    ->relationship('rakBuku', 'nama_rak'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),

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
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBukus::route('/'),
            'create' => Pages\CreateBuku::route('/create'),
            'view' => Pages\ViewBuku::route('/{record}'),
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }
}
