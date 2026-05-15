<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PeminjamanResource\Pages;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Peminjaman';

    protected static ?string $modelLabel = 'Peminjaman';

    protected static ?string $pluralModelLabel = 'Peminjaman';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Peminjaman')
                    ->schema([
                        Forms\Components\Hidden::make('petugas_id')
                    ->default(fn () => Auth::id())
                    ->dehydrated(),

                       Forms\Components\TextInput::make('kode_peminjaman')
                    ->label('Kode Peminjaman')
                    ->required()
                    ->default(fn () => 'PMJ-' . now()->format('YmdHis') . '-' . rand(100, 999))
                    ->unique(table: 'peminjamans', column: 'kode_peminjaman', ignoreRecord: true)
                    ->maxLength(255),

                        Forms\Components\Select::make('anggota_id')
                            ->label('Anggota')
                            ->relationship('anggota', 'kode_anggota')
                            ->getOptionLabelFromRecordUsing(function ($record): string {
                                $namaUser = $record->user?->name ?? '-';

                                return "{$record->kode_anggota} - {$namaUser}";
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_pinjam')
                            ->label('Tanggal Pinjam')
                            ->default(now())
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state): void {
                            if ($state) {
                            $set('tanggal_jatuh_tempo', Carbon::parse($state)->addDays(7)->format('Y-m-d'));
                            }
                            }),

                        Forms\Components\DatePicker::make('tanggal_jatuh_tempo')
                            ->label('Tanggal Jatuh Tempo')
                            ->default(now()->addDays(7))
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'dipinjam' => 'Dipinjam',
                                'dikembalikan' => 'Dikembalikan',
                                'terlambat' => 'Terlambat',
                            ])
                            ->default('dipinjam')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Detail Buku Dipinjam')
                    ->schema([
                        Forms\Components\Repeater::make('detailPeminjaman')
                            ->label('Daftar Buku')
                            ->relationship('detailPeminjaman')
                            ->schema([
                                Forms\Components\Select::make('buku_id')
                                    ->label('Buku')
                                    ->relationship('buku', 'judul_buku')
                                    ->getOptionLabelFromRecordUsing(function ($record): string {
                                        return "{$record->kode_buku} - {$record->judul_buku}";
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->required(),

                                Forms\Components\TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(1)
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->addActionLabel('Add to daftar Buku')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_peminjaman')
                    ->label('Kode Peminjaman')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('anggota.kode_anggota')
                    ->label('Anggota')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('petugas.name')
                    ->label('Petugas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_jatuh_tempo')
                    ->label('Jatuh Tempo')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                        'terlambat' => 'Terlambat',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'dipinjam' => 'warning',
                        'dikembalikan' => 'success',
                        'terlambat' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

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
                        'dipinjam' => 'Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
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
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Hapus Data Terpilih'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamen::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }

    private static function generateKodePeminjaman(): string
    {
        return 'PMJ-' . now()->format('YmdHis') . '-' . random_int(100, 999);
    }
}
