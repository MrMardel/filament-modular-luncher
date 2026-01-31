<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Schemas;

use AlizHarb\ModularLuncher\Models\Module;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Static schema configuration for the module information display.
 *
 * Provides a structured, readable infolist for viewing module details,
 * categorized into logical sections like identity, architecture, and discovery.
 */
final class ModuleInfolist
{
    /**
     * Configure the provided schema with infolist components.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('modular-luncher::modules.sections.identity.label'))
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('name')
                                ->label(__('modular-luncher::modules.fields.name.label'))
                                ->weight('bold'),
                            TextEntry::make('version')
                                ->label(__('modular-luncher::modules.fields.version.label'))
                                ->badge()
                                ->color('gray'),
                            TextEntry::make('namespace')
                                ->label(__('modular-luncher::modules.fields.namespace.label'))
                                ->fontFamily('mono'),
                        ]),
                        Grid::make(2)->schema([
                            TextEntry::make('is_removeable')
                                ->label(__('modular-luncher::modules.flags.removeable'))
                                ->badge()
                                ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                                ->formatStateUsing(fn (bool $state): string => $state
                                    ? __('modular-luncher::modules.options.yes')
                                    : __('modular-luncher::modules.options.no')),
                            TextEntry::make('is_disableable')
                                ->label(__('modular-luncher::modules.flags.disableable'))
                                ->badge()
                                ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                                ->formatStateUsing(fn (bool $state): string => $state
                                    ? __('modular-luncher::modules.options.yes')
                                    : __('modular-luncher::modules.options.no')),
                        ]),
                        TextEntry::make('path')
                            ->label(__('modular-luncher::modules.fields.path.label'))
                            ->fontFamily('mono')
                            ->size('xs'),
                    ]),

                Section::make(__('modular-luncher::modules.fields.authors.label'))
                    ->icon('heroicon-o-users')
                    ->schema([
                        TextEntry::make('authors')
                            ->hiddenLabel()
                            ->html()
                            ->formatStateUsing(function (mixed $state): string {
                                $authors = collect((array) $state)->map(function (mixed $author): string {
                                    $name = is_string($author) ? $author : ($author['name'] ?? 'Unknown');
                                    $email = is_array($author) ? ($author['email'] ?? null) : null;
                                    $role = is_array($author) ? ($author['role'] ?? 'Developer') : 'Developer';

                                    if (is_string($author) && preg_match('/^([^<]+)\s*<([^>]+)>/', $author, $matches)) {
                                        $name = trim($matches[1]);
                                        $email = trim($matches[2]);
                                    }

                                    return "
                                        <div class='flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm'>
                                            <div class='flex-1'>
                                                <div class='font-medium text-gray-900 dark:text-gray-100'>{$name}</div>
                                                ".($email !== null ? "<div class='text-xs text-gray-500 dark:text-gray-400'>{$email}</div>" : '')."
                                            </div>
                                            <div class='text-xs font-mono px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300'>
                                                {$role}
                                            </div>
                                        </div>
                                    ";
                                })->join('');

                                return "<div class='grid grid-cols-1 md:grid-cols-2 gap-4'>{$authors}</div>";
                            }),
                    ]),

                Section::make(__('modular-luncher::modules.sections.architecture.label'))
                    ->icon('heroicon-o-cpu-chip')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('providers')
                                ->label(__('modular-luncher::modules.fields.providers.label'))
                                ->listWithLineBreaks()
                                ->bulleted()
                                ->fontFamily('mono')
                                ->size('xs'),
                            TextEntry::make('middleware')
                                ->label(__('modular-luncher::modules.fields.middleware.label'))
                                ->listWithLineBreaks()
                                ->bulleted()
                                ->fontFamily('mono')
                                ->size('xs'),
                            TextEntry::make('requires')
                                ->label(__('modular-luncher::modules.fields.requires.label'))
                                ->listWithLineBreaks()
                                ->bulleted()
                                ->fontFamily('mono')
                                ->size('xs'),
                        ]),
                    ]),

                Section::make(__('modular-luncher::modules.sections.discovery.label'))
                    ->icon('heroicon-o-magnifying-glass')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('policies')
                                ->label(__('modular-luncher::modules.fields.policies.label'))
                                ->placeholder(__('modular-luncher::modules.errors.no_policies'))
                                ->listWithLineBreaks()
                                ->bulleted()
                                ->fontFamily('mono')
                                ->size('xs'),
                            TextEntry::make('events')
                                ->label(__('modular-luncher::modules.fields.events.label'))
                                ->placeholder(__('modular-luncher::modules.errors.no_events'))
                                ->listWithLineBreaks()
                                ->bulleted()
                                ->fontFamily('mono')
                                ->size('xs'),
                        ]),
                    ]),
            ]);
    }
}
