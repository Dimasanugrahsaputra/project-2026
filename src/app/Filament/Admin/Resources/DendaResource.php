<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DendaResource\Pages;
use App\Models\Denda;
use App\Models\PengembalianBuku;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class DendaResource extends Resource
{
    protected static ?string $model = Denda::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Denda';

    protected static ?string $modelLabel = 'Denda';

    protected static ?string $pluralModelLabel = 'Denda';

    protected static ?int $navigationSort = 5;

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
                Forms\Components\Section::make('Informasi Denda')
                    ->schema([
                        Forms\Components\TextInput::make('kode_denda')
                            ->label('Kode Denda')
                            ->default(fn () => self::generateKodeDenda())
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('pengembalian_buku_id')
                            ->label('Pengembalian Buku')
                            ->options(function (?Denda $record) {
                                return PengembalianBuku::query()
                                    ->with([
                                        'peminjaman.anggota.user',
                                    ])
                                    ->when($record, function ($query) use ($record) {
                                        $query->where(function ($query) use ($record) {
                                            $query
                                                ->whereDoesntHave('denda')
                                                ->orWhere('id', $record->pengembalian_buku_id);
                                        });
                                    }, function ($query) {
                                        $query->whereDoesntHave('denda');
                                    })
                                    ->latest()
                                    ->get()
                                    ->mapWithKeys(function (PengembalianBuku $pengembalian) {
                                        $kodePengembalian = $pengembalian->kode_pengembalian ?? '-';
                                        $kodePeminjaman = $pengembalian->peminjaman?->kode_peminjaman ?? '-';
                                        $namaAnggota = $pengembalian->peminjaman?->anggota?->user?->name ?? '-';

                                        return [
                                            $pengembalian->id => "{$kodePengembalian} - {$kodePeminjaman} - {$namaAnggota}",
                                        ];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('jumlah_denda')
                            ->label('Jumlah Denda')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required()
                            ->minValue(0),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'belum_dibayar' => 'Belum Dibayar',
                                'sudah_dibayar' => 'Sudah Dibayar',
                            ])
                            ->default('belum_dibayar')
                            ->required(),

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
                Tables\Columns\TextColumn::make('kode_denda')
                    ->label('Kode Denda')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pengembalianBuku.kode_pengembalian')
                    ->label('Kode Pengembalian')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pengembalianBuku.peminjaman.kode_peminjaman')
                    ->label('Kode Peminjaman')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pengembalianBuku.peminjaman.anggota.user.name')
                    ->label('Anggota')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_denda')
                    ->label('Jumlah Denda')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'belum_dibayar' => 'Belum Dibayar',
                        'sudah_dibayar' => 'Sudah Dibayar',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'belum_dibayar' => 'danger',
                        'sudah_dibayar' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'belum_dibayar' => 'Belum Dibayar',
                        'sudah_dibayar' => 'Sudah Dibayar',
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDendas::route('/'),
            'create' => Pages\CreateDenda::route('/create'),
            'view' => Pages\ViewDenda::route('/{record}'),
            'edit' => Pages\EditDenda::route('/{record}/edit'),
        ];
    }

    private static function generateKodeDenda(): string
    {
        return 'DND-' . now()->format('YmdHis');
    }
}
