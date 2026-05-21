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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PengembalianBukuResource extends Resource
{
    protected static ?string $model = PengembalianBuku::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Pengembalian Buku';

    protected static ?string $modelLabel = 'Pengembalian Buku';

    protected static ?string $pluralModelLabel = 'Pengembalian Buku';

    protected static ?string $slug = 'pengembalian-buku';

    protected static ?int $navigationSort = 4;

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
                Forms\Components\Section::make('Informasi Pengembalian Buku')
                    ->schema([
                        Forms\Components\TextInput::make('kode_pengembalian')
                            ->label('Kode Pengembalian')
                            ->default(fn () => 'PGB-' . now()->format('YmdHis'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\Select::make('peminjaman_id')
                            ->label('Peminjaman')
                            ->options(function (?PengembalianBuku $record): array {
                                return Peminjaman::query()
                                    ->with(['anggota.user'])
                                    ->when(
                                        $record?->peminjaman_id,
                                        function (Builder $query) use ($record) {
                                            $query->where(function (Builder $query) use ($record) {
                                                $query
                                                    ->where(function (Builder $query) {
                                                        $query
                                                            ->whereIn('status', ['dipinjam', 'terlambat'])
                                                            ->whereDoesntHave('pengembalianBuku');
                                                    })
                                                    ->orWhere('id', $record->peminjaman_id);
                                            });
                                        },
                                        function (Builder $query) {
                                            $query
                                                ->whereIn('status', ['dipinjam', 'terlambat'])
                                                ->whereDoesntHave('pengembalianBuku');
                                        }
                                    )
                                    ->latest('id')
                                    ->get()
                                    ->mapWithKeys(function (Peminjaman $peminjaman): array {
                                        $namaAnggota = $peminjaman->anggota?->user?->name ?? '-';
                                        $kodePeminjaman = $peminjaman->kode_peminjaman ?? '-';
                                        $tanggalJatuhTempo = $peminjaman->tanggal_jatuh_tempo ?? '-';

                                        return [
                                            $peminjaman->id => "{$kodePeminjaman} - {$namaAnggota} - Jatuh Tempo: {$tanggalJatuhTempo}",
                                        ];
                                    })
                                    ->toArray();
                            })
                            ->getOptionLabelUsing(function ($value): ?string {
                                $peminjaman = Peminjaman::query()
                                    ->with(['anggota.user'])
                                    ->find($value);

                                if (! $peminjaman) {
                                    return null;
                                }

                                $namaAnggota = $peminjaman->anggota?->user?->name ?? '-';
                                $kodePeminjaman = $peminjaman->kode_peminjaman ?? '-';
                                $tanggalJatuhTempo = $peminjaman->tanggal_jatuh_tempo ?? '-';

                                return "{$kodePeminjaman} - {$namaAnggota} - Jatuh Tempo: {$tanggalJatuhTempo}";
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_pengembalian')
                            ->label('Tanggal Pengembalian')
                            ->default(now())
                            ->native(false)
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
                            ->rows(4)
                            ->columnSpanFull()
                            ->nullable(),
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

                Tables\Columns\TextColumn::make('tanggal_pengembalian')
                    ->label('Tanggal Pengembalian')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'tepat_waktu' => 'Tepat Waktu',
                        'terlambat' => 'Terlambat',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'tepat_waktu' => 'success',
                        'terlambat' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(40)
                    ->toggleable(),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengembalianBukus::route('/'),
            'create' => Pages\CreatePengembalianBuku::route('/create'),
            'view' => Pages\ViewPengembalianBuku::route('/{record}'),
            'edit' => Pages\EditPengembalianBuku::route('/{record}/edit'),
        ];
    }
}
