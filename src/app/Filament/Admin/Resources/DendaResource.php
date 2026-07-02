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
use Illuminate\Support\Carbon;

class DendaResource extends Resource
{
    protected static ?string $model = Denda::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Denda';

    protected static ?string $modelLabel = 'Denda';

    protected static ?string $pluralModelLabel = 'Denda';

    protected static ?string $slug = 'dendas';

    protected static ?int $navigationSort = 5;

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
                Forms\Components\Section::make('Informasi Denda')
                    ->schema([
                        Forms\Components\TextInput::make('kode_denda')
                            ->label('Kode Denda')
                            ->default(fn () => 'DND-' . now()->format('YmdHis'))
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('pengembalian_buku_id')
                            ->label('Pengembalian Buku')
                            ->options(function () {
                                return PengembalianBuku::query()
                                    ->with(['peminjaman.anggota.user'])
                                    ->latest('id')
                                    ->get()
                                    ->mapWithKeys(function (PengembalianBuku $pengembalian) {
                                        $kodePengembalian = $pengembalian->kode_pengembalian ?? '-';
                                        $kodePeminjaman = $pengembalian->peminjaman?->kode_peminjaman ?? '-';
                                        $namaAnggota = $pengembalian->peminjaman?->anggota?->user?->name ?? '-';

                                        return [
                                            $pengembalian->id => "{$kodePengembalian} - {$kodePeminjaman} - {$namaAnggota}",
                                        ];
                                    })
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('jumlah_denda')
                            ->label('Jumlah Denda')
                            ->prefix('Rp')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        Forms\Components\TextInput::make('jumlah_dibayar')
                            ->label('Jumlah Dibayar')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->minValue(0)
                            ->helperText('Isi sesuai nominal pembayaran. Jika sama dengan jumlah denda, status akan menjadi lunas.'),

                        Forms\Components\DatePicker::make('tanggal_pembayaran')
                            ->label('Tanggal Pembayaran')
                            ->helperText('Boleh dikosongkan. Jika jumlah dibayar lebih dari 0, sistem akan mengisi otomatis.'),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'belum_dibayar' => 'Belum Dibayar',
                                'sudah_dibayar' => 'Sudah Dibayar',
                            ])
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Status diatur otomatis berdasarkan jumlah dibayar.'),

                        Forms\Components\Select::make('status_pembayaran')
                            ->label('Status Pembayaran')
                            ->options([
                                'belum_lunas' => 'Belum Lunas',
                                'lunas' => 'Lunas',
                            ])
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Status pembayaran diatur otomatis berdasarkan jumlah denda dan jumlah dibayar.'),

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
                    ->sortable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('pengembalianBuku.peminjaman.kode_peminjaman')
                    ->label('Kode Peminjaman')
                    ->searchable()
                    ->sortable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('pengembalianBuku.peminjaman.anggota.user.name')
                    ->label('Anggota')
                    ->searchable()
                    ->default('-'),

                Tables\Columns\TextColumn::make('jumlah_denda')
                    ->label('Jumlah Denda')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_dibayar')
                    ->label('Jumlah Dibayar')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'belum_dibayar' => 'Belum Dibayar',
                        'sudah_dibayar' => 'Sudah Dibayar',
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'belum_dibayar' => 'danger',
                        'sudah_dibayar' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'belum_lunas' => 'Belum Lunas',
                        'lunas' => 'Lunas',
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'belum_lunas' => 'warning',
                        'lunas' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('tanggal_pembayaran')
                    ->label('Tanggal Bayar')
                    ->formatStateUsing(function ($state): string {
                        if (blank($state) || $state === '-') {
                            return '-';
                        }

                        return Carbon::parse($state)->format('d M Y');
                    })
                    ->sortable(),
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
            'index' => Pages\ListDendas::route('/'),
            'create' => Pages\CreateDenda::route('/create'),
            'edit' => Pages\EditDenda::route('/{record}/edit'),
        ];
    }
}
