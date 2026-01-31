<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\RelationManagers;

use AlizHarb\ModularLuncher\Exceptions\ModuleOperationException;
use AlizHarb\ModularLuncher\Models\ModuleBackup;
use AlizHarb\ModularLuncher\Services\ModuleService;
use Exception;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Relation manager for module backup files.
 *
 * Provides a dedicated table for managing backups of a specific module,
 * allowing for restoration and deletion of individual or bulk backup records.
 */
class ModuleBackupsRelationManager extends RelationManager
{
    /** @var string The name of the relationship on the owner record */
    protected static string $relationship = 'backups';



    /**
     * Get the localized title for the relation manager.
     */
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __(config('modular-luncher.backups.relation_manager.title', 'modular-luncher::modules.backups.title'));
    }

    /**
     * Get the navigation icon for the relation manager.
     */
    public static function getIcon(Model $ownerRecord, string $pageClass): string
    {
        return (string) config('modular-luncher.backups.relation_manager.icon', 'heroicon-o-archive-box');
    }

    /**
     * Determine if the relation manager can be viewed for the given record.
     */
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return (bool) config('modular-luncher.backups.relation_manager.enabled', true);
    }

    /**
     * Configure the table for the relation manager.
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('filename')
            ->columns([
                TextColumn::make('filename')
                    ->label(__('modular-luncher::modules.backups.fields.filename'))
                    ->searchable()
                    ->fontFamily('mono')
                    ->size('xs')
                    ->copyable()
                    ->tooltip(fn (ModuleBackup $record): string => $record->filename),
                TextColumn::make('size')
                    ->label(__('modular-luncher::modules.backups.fields.size'))
                    ->formatStateUsing(fn (int $state): string => number_format($state / 1024 / 1024, 2).' MB')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-o-document'),
                TextColumn::make('created_at')
                    ->label(__('modular-luncher::modules.backups.fields.date'))
                    ->dateTime()
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->color('primary'),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('restore')
                        ->label(__('modular-luncher::modules.backups.actions.restore.label'))
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading(__('modular-luncher::modules.backups.actions.restore.confirm_heading'))
                        ->modalDescription(__('modular-luncher::modules.backups.actions.restore.confirm_description'))
                        ->modalSubmitActionLabel(__('modular-luncher::modules.backups.actions.restore.confirm_button'))
                        ->action(function (ModuleBackup $record, ModuleService $service): void {
                            try {
                                $service->restore($record->module_name, $record->filename);

                                Notification::make()
                                    ->title(__('modular-luncher::modules.notifications.restored'))
                                    ->success()
                                    ->send();
                            } catch (ModuleOperationException $e) {
                                Notification::make()
                                    ->title(__('modular-luncher::modules.errors.unexpected_error'))
                                    ->body($e->getMessage())
                                    ->danger()
                                    ->send();
                            } catch (Exception $e) {
                                Notification::make()
                                    ->title(__('modular-luncher::modules.errors.unexpected_error'))
                                    ->body($e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }),
                    Action::make('delete')
                        ->label(__('modular-luncher::modules.backups.actions.delete.label'))
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading(__('modular-luncher::modules.backups.actions.delete.confirm_heading'))
                        ->modalDescription(__('modular-luncher::modules.backups.actions.delete.confirm_description'))
                        ->modalSubmitActionLabel(__('modular-luncher::modules.backups.actions.delete.confirm_button'))
                        ->action(function (ModuleBackup $record): void {
                            $backupDisk = (string) config('modular-luncher.backups.disk', 'local');
                            $backupDir = (string) config('modular-luncher.backups.storage_path', 'module-backups');
                            $disk = Storage::disk($backupDisk);
                            $path = $backupDir.DIRECTORY_SEPARATOR.$record->filename;

                            if ($disk->exists($path)) {
                                $disk->delete($path);
                            }
                            
                            Notification::make()
                                ->title(__('modular-luncher::modules.backups.notifications.deleted'))
                                ->success()
                                ->send();
                        }),
                ])->icon('heroicon-m-ellipsis-vertical'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make()
                    ->label(__('modular-luncher::modules.backups.actions.delete_bulk.label'))
                    ->modalHeading(__('modular-luncher::modules.backups.actions.delete_bulk.confirm_heading'))
                    ->modalDescription(__('modular-luncher::modules.backups.actions.delete_bulk.confirm_description'))
                    ->modalSubmitActionLabel(__('modular-luncher::modules.backups.actions.delete_bulk.confirm_button'))
                    ->action(function (Collection $records): void {
                        /** @var Collection<int, ModuleBackup> $records */
                        $backupDisk = (string) config('modular-luncher.backups.disk', 'local');
                        $backupDir = (string) config('modular-luncher.backups.storage_path', 'module-backups');
                        $disk = Storage::disk($backupDisk);

                        $records->each(function (ModuleBackup $record) use ($disk, $backupDir): void {
                            $path = $backupDir.DIRECTORY_SEPARATOR.$record->filename;
                            if ($disk->exists($path)) {
                                $disk->delete($path);
                            }
                        });

                        Notification::make()
                            ->title(__('modular-luncher::modules.backups.notifications.bulk_deleted'))
                            ->success()
                            ->send();
                    }),
            ])
            ->emptyStateIcon('heroicon-o-archive-box-x-mark')
            ->emptyStateHeading(__('modular-luncher::modules.backups.empty.heading'))
            ->emptyStateDescription(__('modular-luncher::modules.backups.empty.description'));
    }
}
