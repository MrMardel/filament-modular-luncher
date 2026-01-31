<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Widgets;

use AlizHarb\ModularLuncher\Models\Module;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

/**
 * Dashboard widget displaying recently processed modules.
 *
 * Provides a snapshot of the installed modules with their
 * current versions, status, and asset discovery status.
 */
final class RecentModulesWidget extends BaseWidget
{
    /** @var int|null Determine the order of the widget on the dashboard */
    protected static ?int $sort = 3;

    /** @var int|string|array<string, int|null> Set the column span of the widget */
    protected int|string|array $columnSpan = 'full';

    /** @var string|null Override the default heading */
    protected static ?string $heading = null;

    /**
     * Get the localized heading for the widget.
     */
    public function getHeading(): string
    {
        return (string) __('modular-luncher::modules.widgets.recent.heading');
    }

    /**
     * Configure the table for the widget.
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(Module::query()->take(10))
            ->columns([
                TextColumn::make('name')
                    ->label(__('modular-luncher::modules.fields.name.label'))
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('version')
                    ->label(__('modular-luncher::modules.fields.version.label'))
                    ->badge()
                    ->color('info'),

                IconColumn::make('is_enabled')
                    ->label(__('modular-luncher::modules.fields.status.label'))
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),

                IconColumn::make('assets')
                    ->label(__('modular-luncher::modules.fields.assets.label'))
                    ->state(fn (Module $record): array => [
                        'views' => $record->has_views,
                        'translations' => $record->has_translations,
                        'migrations' => $record->has_migrations,
                    ])
                    ->icons([
                        'heroicon-o-eye' => fn (mixed $state): bool => (bool) ($state['views'] ?? false),
                        'heroicon-o-language' => fn (mixed $state): bool => (bool) ($state['translations'] ?? false),
                        'heroicon-o-circle-stack' => fn (mixed $state): bool => (bool) ($state['migrations'] ?? false),
                    ])
                    ->color('gray'),
            ])
            ->paginated(false);
    }
}
