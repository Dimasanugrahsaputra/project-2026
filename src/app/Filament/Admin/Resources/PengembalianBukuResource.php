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

class PengembalianBukuResource extends Resource
{
    protected static ?string $model = PengembalianBuku::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Pengembalian Buku';

    protected static ?string $modelLabel = 'Pengembalian Buku';

    protected static ?string $pluralModelLabel = 'Pengembalian Buku';

    protected static ?string $slug = 'pengembalian-buku';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit($record): bool
    {
        return true;
    }

    public static function canDelete($record): bool
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
                Forms\Components\TextInput::make('kode_pengembalian')
                    ->label('Kode Pengembalian')
                    ->default(fn () => 'KMB-' . now()->format('YmdHis'))
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('peminjaman_id')
                    ->label('Peminjaman')
                    ->options(function () {
                        return Peminjaman::query()
                            ->with(['anggota.user'])
                            ->whereIn('status', ['dipinjam', 'terlambat'])
                            ->whereDoesntHave('pengembalianBuku')
                            ->latest('id')
                            ->get()
                            ->mapWithKeys(function (Peminjaman $peminjaman) {
                                $namaAnggota = $peminjaman->anggota?->user?->name ?? '-';
                                $kodePeminjaman = $peminjaman->kode_peminjaman ?? '-';
                                $tanggalJatuhTempo = $peminjaman->tanggal_jatuh_tempo
                                    ? $peminjaman->tanggal_jatuh_tempo->format('d M Y')
                                    : '-';

                                return [
                                    $peminjaman->id => "{$kodePeminjaman} - {$namaAnggota} - Jatuh Tempo: {$tanggalJatuhTempo}",
                                ];
                            })
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_pengembalian')
                    ->label('Tanggal Pengembalian')
                    ->default(now())
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'tepat waktu' => 'Tepat Waktu',
                        'terlambat' => 'Terlambat',
                    ])
                    ->default('tepat waktu')
                    ->required(),

                Forms\Components\Textarea::make('catatan')
                    ->label('Catatan')
                    ->rows(3)
                    ->columnSpanFull(),
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
                    ->default('-'),

                Tables\Columns\TextColumn::make('tanggal_pengembalian')
                    ->label('Tanggal Pengembalian')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'tepat waktu' => 'Tepat Waktu',
                        'terlambat' => 'Terlambat',
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'tepat waktu' => 'success',
                        'terlambat' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(30)
                    ->default('-'),
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
            'index' => Pages\ListPengembalianBukus::route('/'),
            'create' => Pages\CreatePengembalianBuku::route('/create'),
            'edit' => Pages\EditPengembalianBuku::route('/{record}/edit'),
        ];
    }
}
