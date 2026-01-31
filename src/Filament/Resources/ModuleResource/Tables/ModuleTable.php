<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Tables;

use AlizHarb\Modular\Facades\Modular;
use AlizHarb\ModularLuncher\Data\InstallModuleData;
use AlizHarb\ModularLuncher\Exceptions\ModuleInstallationException;
use AlizHarb\ModularLuncher\Exceptions\ModuleOperationException;
use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource;
use AlizHarb\ModularLuncher\Models\Module;
use AlizHarb\ModularLuncher\Services\ModuleService;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Static schema configuration for the module management table.
 *
 * Implements the "Professional Elite" pattern by isolating table
 * logic from the resource and providing grouped, searchable, and
 * actionable columns.
 */
final class ModuleTable
{
    /**
     * Configure the provided Filament table with columns, actions, and filters.
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(self::getColumns())
            ->recordActions(self::getRecordActions())
            ->headerActions(self::getHeaderActions())
            ->filters(self::getFilters())
            ->filtersFormColumns(2)
            ->persistFiltersInSession()
            ->toolbarActions(self::getBulkActions())
            ->deferLoading();
    }

    /**
     * Get the column definitions for the module table.
     *
     * @return array<int, \Filament\Tables\Columns\Column>
     */
    protected static function getColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label(__('modular-luncher::modules.fields.name.label'))
                ->searchable()
                ->sortable()
                ->weight('bold'),

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

            TextColumn::make('authors')
                ->label(__('modular-luncher::modules.fields.authors.label'))
                ->formatStateUsing(function (mixed $state): string {
                    return collect((array) $state)
                        ->map(function (mixed $author): ?string {
                            if (is_array($author)) {
                                return $author['name'] ?? null;
                            }
                            if (is_string($author) && preg_match('/^([^,<]+)/', $author, $matches)) {
                                return trim($matches[1]);
                            }

                            return is_string($author) ? $author : null;
                        })
                        ->filter()
                        ->join(', ');
                })
                ->tooltip(function (Module $record): string {
                    return collect($record->authors)
                        ->map(function (mixed $author): string {
                            if (is_array($author)) {
                                $name = $author['name'] ?? 'Unknown';
                                $email = $author['email'] ?? null;

                                return $name.($email ? " <{$email}>" : '');
                            }

                            return (string) $author;
                        })
                        ->join("\n");
                })
                ->default(__('modular-luncher::modules.errors.unknown_author'))
                ->limit(30)
                ->toggleable(),

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
                ->color('gray')
                ->tooltip(fn (mixed $state): string => collect((array) $state)->filter()->keys()->join(', '))
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('namespace')
                ->label(__('modular-luncher::modules.fields.namespace.label'))
                ->fontFamily('mono')
                ->size('xs')
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Get the actions available for each module record.
     *
     * @return array<int, ActionGroup>
     */
    protected static function getRecordActions(): array
    {
        return [
            ActionGroup::make([
                self::toggleAction(),
                self::updateAction(),
                self::viewAction(),
                self::backupAction(),
                self::restoreAction(),
                self::uninstallAction(),
            ])->icon('heroicon-m-ellipsis-vertical'),
        ];
    }

    /**
     * Get the header actions for the table.
     *
     * @return array<int, Action>
     */
    protected static function getHeaderActions(): array
    {
        return [
            self::installAction(),
        ];
    }

    /**
     * Create the module enable/disable toggle action.
     */
    protected static function toggleAction(): Action
    {
        return Action::make('toggle')
            ->label(fn (Module $record): string => $record->is_enabled
                ? __('modular-luncher::modules.actions.toggle.disable')
                : __('modular-luncher::modules.actions.toggle.enable'))
            ->icon(fn (Module $record): string => $record->is_enabled
                ? 'heroicon-o-pause-circle'
                : 'heroicon-o-play-circle')
            ->color(fn (Module $record): string => $record->is_enabled
                ? 'warning'
                : 'success')
            ->authorize('toggle')
            ->action(function (Module $record): void {
                if (! $record->is_disableable) {
                    Notification::make()
                        ->title(__('modular-luncher::modules.errors.not_disableable', ['name' => $record->name]))
                        ->danger()
                        ->send();

                    return;
                }

                $newStatus = ! $record->is_enabled;
                Modular::getActivator()->setStatus($record->name, $newStatus);
                Modular::clearCache();

                Notification::make()
                    ->title(__('modular-luncher::modules.notifications.status_updated'))
                    ->success()
                    ->send();
            })
            ->disabled(fn (Module $record): bool => ! $record->is_disableable);
    }

    /**
     * Create the module update action.
     */
    protected static function updateAction(): Action
    {
        return Action::make('update')
            ->label(__('modular-luncher::modules.actions.update.label'))
            ->icon('heroicon-o-arrow-path')
            ->color('info')
            ->authorize('update')
            ->action(function (Module $record, ModuleService $service): void {
                try {
                    $service->update($record->name);
                    Notification::make()
                        ->title(__('modular-luncher::modules.notifications.updated'))
                        ->success()
                        ->send();
                } catch (ModuleOperationException|ModuleInstallationException $e) {
                    Notification::make()
                        ->title(__('modular-luncher::modules.errors.unexpected_error'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->visible(fn (): bool => (bool) config('modular-luncher.updates.enabled', true));
    }

    /**
     * Create the view module details action.
     */
    protected static function viewAction(): Action
    {
        return Action::make('view')
            ->label(__('modular-luncher::modules.actions.view.label'))
            ->icon('heroicon-o-eye')
            ->authorize('view')
            ->url(fn (Module $record): string => ModuleResource::getUrl('view', ['record' => $record->name]));
    }

    /**
     * Create the module backup action.
     */
    protected static function backupAction(): Action
    {
        return Action::make('backup')
            ->label(__('modular-luncher::modules.actions.backup.label'))
            ->icon('heroicon-o-archive-box')
            ->color('gray')
            ->authorize('backup')
            ->action(function (Module $record, ModuleService $service): void {
                try {
                    $service->backup($record->name);
                    Notification::make()
                        ->title(__('modular-luncher::modules.notifications.backed_up'))
                        ->success()
                        ->send();
                } catch (ModuleOperationException $e) {
                    Notification::make()
                        ->title(__('modular-luncher::modules.errors.unexpected_error'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->visible(fn (): bool => (bool) config('modular-luncher.backups.enabled', true));
    }

    /**
     * Create the recursive module restore action.
     */
    protected static function restoreAction(): Action
    {
        return Action::make('restore')
            ->label(__('modular-luncher::modules.actions.restore.label'))
            ->icon('heroicon-o-arrow-uturn-left')
            ->color('warning')
            ->authorize('restore')
            ->action(function (Module $record, ModuleService $service): void {
                try {
                    $service->restore($record->name);
                    Notification::make()
                        ->title(__('modular-luncher::modules.notifications.restored'))
                        ->success()
                        ->send();
                } catch (ModuleOperationException|ModuleInstallationException $e) {
                    Notification::make()
                        ->title(__('modular-luncher::modules.errors.unexpected_error'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->visible(fn (): bool => (bool) config('modular-luncher.backups.enabled', true));
    }

    /**
     * Create the module uninstallation action with confirmation.
     */
    protected static function uninstallAction(): Action
    {
        return Action::make('uninstall')
            ->label(__('modular-luncher::modules.actions.uninstall.label'))
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading(__('modular-luncher::modules.actions.uninstall.confirm_heading'))
            ->modalDescription(__('modular-luncher::modules.actions.uninstall.confirm_description'))
            ->modalSubmitActionLabel(__('modular-luncher::modules.actions.uninstall.confirm_button'))
            ->modalIcon('heroicon-o-exclamation-triangle')
            ->authorize('delete')
            ->visible(fn (Module $record): bool => (bool) $record->is_removeable)
            ->action(function (Module $record, ModuleService $service): void {
                try {
                    $service->uninstall($record->name);

                    Notification::make()
                        ->title(__('modular-luncher::modules.notifications.uninstalled'))
                        ->success()
                        ->send();
                } catch (ModuleOperationException $e) {
                    Notification::make()
                        ->title(__('modular-luncher::modules.errors.unexpected_error'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    /**
     * Create the module installation action as a header action.
     */
    public static function installAction(): Action
    {
        return Action::make('install')
            ->label(__('modular-luncher::modules.actions.install.label'))
            ->icon('heroicon-o-plus-circle')
            ->color('success')
            ->schema([
                Select::make('source_type')
                    ->label(__('modular-luncher::modules.fields.source_type.label'))
                    ->options([
                        'zip' => __('modular-luncher::modules.options.sources.zip'),
                        'url' => __('modular-luncher::modules.options.sources.url'),
                        'composer' => __('modular-luncher::modules.options.sources.composer'),
                    ])
                    ->required()
                    ->live(),
                FileUpload::make('file_path')
                    ->label(__('modular-luncher::modules.fields.file.label'))
                    ->disk((string) config('modular-luncher.installation.disk', 'local'))
                    ->directory('modules/uploads')
                    ->acceptedFileTypes(['application/zip'])
                    ->visible(fn (callable $get): bool => $get('source_type') === 'zip')
                    ->required(fn (callable $get): bool => $get('source_type') === 'zip'),
                TextInput::make('url')
                    ->label(__('modular-luncher::modules.fields.url.label'))
                    ->placeholder('https://github.com/user/repo or https://example.com/module.zip')
                    ->url()
                    ->visible(fn (callable $get): bool => $get('source_type') === 'url')
                    ->required(fn (callable $get): bool => $get('source_type') === 'url'),
                TextInput::make('composer_package')
                    ->label(__('modular-luncher::modules.fields.composer_package.label'))
                    ->placeholder('vendor/package')
                    ->visible(fn (callable $get): bool => $get('source_type') === 'composer')
                    ->required(fn (callable $get): bool => $get('source_type') === 'composer'),
                Toggle::make('enable_after_install')
                    ->label(__('modular-luncher::modules.fields.enable_after_install.label'))
                    ->default(true),
            ])
            ->authorize('create')
            ->action(function (array $data, ModuleService $service): void {
                try {
                    if ($data['source_type'] === 'zip' && isset($data['file_path'])) {
                        $disk = (string) config('modular-luncher.installation.disk', 'local');
                        $data['file_path'] = Storage::disk($disk)->path((string) $data['file_path']);
                    }

                    $installData = InstallModuleData::from($data);
                    $service->install($installData);

                    Notification::make()
                        ->title(__('modular-luncher::modules.notifications.installed'))
                        ->success()
                        ->send();
                } catch (ModuleInstallationException $e) {
                    Notification::make()
                        ->title(__('modular-luncher::modules.errors.installation_failed'))
                        ->body($e->getMessage())
                        ->danger()
                        ->persistent()
                        ->send();
                } catch (Exception $e) {
                    Notification::make()
                        ->title(__('modular-luncher::modules.errors.unexpected_error'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->visible(fn (): bool => (bool) config('modular-luncher.installation.enabled', true));
    }

    /**
     * Get the filter definitions for the table.
     *
     * @return array<int, \Filament\Tables\Filters\BaseFilter>
     */
    protected static function getFilters(): array
    {
        return [
            SelectFilter::make('is_enabled')
                ->label(__('modular-luncher::modules.filters.status.label'))
                ->options([
                    '1' => __('modular-luncher::modules.filters.status.enabled'),
                    '0' => __('modular-luncher::modules.filters.status.disabled'),
                ])
                ->placeholder(__('modular-luncher::modules.filters.status.all'))
                ->query(function (Builder $query, array $data): Builder {
                    if (($data['value'] ?? null) === null) {
                        return $query;
                    }

                    return $query->where('is_enabled', (bool) $data['value']);
                }),

            Filter::make('has_views')
                ->label(__('modular-luncher::modules.filters.has_views'))
                ->query(fn (Builder $query): Builder => $query->where('has_views', true))
                ->toggle(),

            Filter::make('has_migrations')
                ->label(__('modular-luncher::modules.filters.has_migrations'))
                ->query(fn (Builder $query): Builder => $query->where('has_migrations', true))
                ->toggle(),

            Filter::make('has_translations')
                ->label(__('modular-luncher::modules.filters.has_translations'))
                ->query(fn (Builder $query): Builder => $query->where('has_translations', true))
                ->toggle(),
        ];
    }

    /**
     * Create the bulk actions for managing multiple modules.
     *
     * @return array<int, BulkAction>
     */
    protected static function getBulkActions(): array
    {
        return [
            BulkAction::make('enable')
                ->label(__('modular-luncher::modules.bulk_actions.enable'))
                ->icon('heroicon-o-play-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading(__('modular-luncher::modules.bulk_actions.enable_confirm'))
                ->modalDescription(fn (Collection $records): string => (string) __('modular-luncher::modules.bulk_actions.enable_description', ['count' => $records->count()]))
                ->deselectRecordsAfterCompletion()
                ->action(function (Collection $records): void {
                    $count = 0;
                    foreach ($records as $record) {
                        /** @var Module $record */
                        if (! $record->is_disableable) {
                            continue;
                        }

                        Modular::getActivator()->setStatus($record->name, true);
                        $count++;
                    }
                    if ($count > 0) {
                        Modular::clearCache();
                    }

                    Notification::make()
                        ->title(__('modular-luncher::modules.notifications.bulk_enabled', ['count' => $count]))
                        ->success()
                        ->send();
                }),

            BulkAction::make('disable')
                ->label(__('modular-luncher::modules.bulk_actions.disable'))
                ->icon('heroicon-o-pause-circle')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading(__('modular-luncher::modules.bulk_actions.disable_confirm'))
                ->modalDescription(fn (Collection $records): string => (string) __('modular-luncher::modules.bulk_actions.disable_description', ['count' => $records->count()]))
                ->deselectRecordsAfterCompletion()
                ->action(function (Collection $records): void {
                    $count = 0;
                    foreach ($records as $record) {
                        /** @var Module $record */
                        if (! $record->is_disableable) {
                            continue;
                        }

                        Modular::getActivator()->setStatus($record->name, false);
                        $count++;
                    }
                    if ($count > 0) {
                        Modular::clearCache();
                    }

                    Notification::make()
                        ->title(__('modular-luncher::modules.notifications.bulk_disabled', ['count' => $count]))
                        ->success()
                        ->send();
                }),

            BulkAction::make('uninstall')
                ->label(__('modular-luncher::modules.bulk_actions.uninstall'))
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading(__('modular-luncher::modules.bulk_actions.uninstall_confirm'))
                ->modalDescription(fn (Collection $records): string => (string) __('modular-luncher::modules.bulk_actions.uninstall_description', ['count' => $records->count()]))
                ->modalIcon('heroicon-o-exclamation-triangle')
                ->modalSubmitActionLabel(__('modular-luncher::modules.bulk_actions.uninstall_button'))
                ->deselectRecordsAfterCompletion()
                ->action(function (Collection $records, ModuleService $service): void {
                    $count = 0;
                    $errors = [];

                    foreach ($records as $record) {
                        /** @var Module $record */
                        if (! $record->is_removeable) {
                            $errors[] = $record->name.': '.__('modular-luncher::modules.errors.not_removeable', ['name' => $record->name]);

                            continue;
                        }

                        try {
                            $service->uninstall($record->name);
                            $count++;
                        } catch (ModuleOperationException $e) {
                            $errors[] = $record->name.': '.$e->getMessage();
                        }
                    }

                    if ($count > 0) {
                        Notification::make()
                            ->title(__('modular-luncher::modules.notifications.bulk_uninstalled', ['count' => $count]))
                            ->success()
                            ->send();
                    }

                    if ($errors !== []) {
                        Notification::make()
                            ->title(__('modular-luncher::modules.errors.bulk_uninstall_errors'))
                            ->body(implode("\n", $errors))
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
