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

    protected static bool $shouldRegisterNavigation = true;

    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        return auth()->check();
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->check();
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->check();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Buku')
                    ->schema([
                        Forms\Components\FileUpload::make('cover')
                            ->label('Cover Buku')
                            ->image()
                            ->disk('public')
                            ->directory('covers/buku')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('kode_buku')
                            ->label('Kode Buku')
                            ->default(fn () => 'BK' . now()->format('YmdHis'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

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
                            ->maxValue((int) now()->format('Y')),

                        Forms\Components\TextInput::make('stok')
                            ->label('Stok')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->label('Cover')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(url('/images/default-book.png')),

                Tables\Columns\TextColumn::make('kode_buku')
                    ->label('Kode Buku')
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
                    ->searchable(),

                Tables\Columns\TextColumn::make('penerbit')
                    ->label('Penerbit')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tahun_terbit')
                    ->label('Tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stok')
                    ->label('Stok')
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger')
                    ->sortable(),

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
            'edit' => Pages\EditBuku::route('/{record}/edit'),
        ];
    }
}
