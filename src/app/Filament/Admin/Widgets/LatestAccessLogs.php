<?php

namespace App\Filament\Admin\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Spatie\Activitylog\Models\Activity;

class LatestAccessLogs extends TableWidget
{
    protected static ?string $heading = 'Latest Access Logs';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Activity::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('log_name')
                    ->label('Type')
                    ->badge(),

                Tables\Columns\TextColumn::make('event')
                    ->label('Event')
                    ->formatStateUsing(fn (?string $state): string => ucfirst($state ?? '-')),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Subject')
                    ->formatStateUsing(function ($record): string {
                        if (! $record->subject_type) {
                            return '-';
                        }

                        $model = class_basename($record->subject_type);

                        return $model . ' #' . ($record->subject_id ?? '-');
                    }),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('User')
                    ->default('-'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Logged At')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
