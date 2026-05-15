<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PengembalianBukuResource\Pages;
use App\Models\Peminjaman;
use App\Models\PengembalianBuku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PengembalianBukuResource extends Resource
{
    protected static ?string $model = PengembalianBuku::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Pengembalian Buku';

    protected static ?string $modelLabel = 'Pengembalian Buku';

    protected static ?string $pluralModelLabel = 'Pengembalian Buku';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengembalian Buku')
    ->schema([
        Forms\Components\Hidden::make('petugas_id')
            ->default(fn () => Auth::id())
            ->dehydrated(),

        Forms\Components\TextInput::make('kode_pengembalian')
            ->label('Kode Pengembalian')
            ->default(fn () => 'PGB-' . now()->format('YmdHis'))
            ->required()
            ->maxLength(255),

        Forms\Components\Select::make('peminjaman_id')
            ->label('Kode Peminjaman')
            ->relationship('peminjaman', 'kode_peminjaman')
            ->searchable()
            ->preload()
            ->required(),

        Forms\Components\DatePicker::make('tanggal_kembali')
            ->label('Tanggal Pengembalian')
            ->default(now())
            ->required(),

        Forms\Components\TextInput::make('jumlah_hari_terlambat')
            ->label('Jumlah Hari Terlambat')
            ->numeric()
            ->default(0)
            ->required(),

        Forms\Components\Select::make('status')
            ->label('Status')
            ->options([
                'tepat_waktu' => 'Tepat Waktu',
                'terlambat' => 'Terlambat',
            ])
            ->default('tepat_waktu')
            ->required(),

        Forms\Components\Textarea::make('catatan')
            ->label('Catatan')
            ->columnSpanFull(),
    ])
    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_pengembalian')
                    ->label('Kode Pengembalian')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('peminjaman.kode_peminjaman')
                    ->label('Kode Peminjaman')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('peminjaman.anggota.user.name')
                    ->label('Anggota')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('petugas.name')
                    ->label('Petugas')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('tanggal_pengembalian')
                    ->label('Tanggal Pengembalian')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_hari_terlambat')
                    ->label('Terlambat')
                    ->suffix(' hari')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'tepat_waktu',
                        'danger' => 'terlambat',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'tepat_waktu' => 'Tepat Waktu',
                        'terlambat' => 'Terlambat',
                        default => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'tepat_waktu' => 'Tepat Waktu',
                        'terlambat' => 'Terlambat',
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
            'index' => Pages\ListPengembalianBukus::route('/'),
            'create' => Pages\CreatePengembalianBuku::route('/create'),
            'edit' => Pages\EditPengembalianBuku::route('/{record}/edit'),
        ];
    }
}
