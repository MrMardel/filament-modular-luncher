<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Resources;

use AlizHarb\ModularLuncher\Filament\Plugins\ModularLuncherPlugin;
use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Pages\ListModules;
use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Pages\ViewModule;
use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\RelationManagers\ModuleBackupsRelationManager;
use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Schemas\ModuleInfolist;
use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Tables\ModuleTable;
use AlizHarb\ModularLuncher\Models\Module;
use AlizHarb\ModularLuncher\Policies\ModulePolicy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

/**
 * Resource for managing system modules within Filament.
 *
 * Provides a comprehensive interface for listing, viewing, and managing
 * modules, including backup management and status toggling.
 */
class ModuleResource extends Resource
{
    /** @var class-string<Model>|null The Eloquent model associated with the resource */
    protected static ?string $model = Module::class;

    /** @var string|null The policy class for authorizing actions */
    protected static ?string $policy = ModulePolicy::class;

    /**
     * Get the localized model label.
     */
    public static function getModelLabel(): string
    {
        try {
            return ModularLuncherPlugin::get()->getLabel();
        } catch (\Throwable $e) {
            return (string) __(config('modular-luncher.resource.label'));
        }
    }

    /**
     * Get the localized plural model label.
     */
    public static function getPluralModelLabel(): string
    {
        try {
            return ModularLuncherPlugin::get()->getPluralLabel();
        } catch (\Throwable $e) {
            return (string) __(config('modular-luncher.resource.plural_label'));
        }
    }

    /**
     * Get the navigation icon for the resource.
     */
    public static function getNavigationIcon(): string|BackedEnum|null
    {
        try {
            return ModularLuncherPlugin::get()->getNavigationIcon() ?? parent::getNavigationIcon();
        } catch (\Throwable $e) {
            return config('modular-luncher.resource.navigation_icon', 'heroicon-o-cpu-chip');
        }
    }

    /**
     * Get the localized navigation label.
     */
    public static function getNavigationLabel(): string
    {
        try {
            return ModularLuncherPlugin::get()->getLabel();
        } catch (\Throwable $e) {
            return (string) __(config('modular-luncher.resource.navigation_label'));
        }
    }

    /**
     * Get the localized navigation group.
     */
    public static function getNavigationGroup(): ?string
    {
        try {
            $group = ModularLuncherPlugin::get()->getNavigationGroup();
            if ($group instanceof UnitEnum) {
                return $group->name;
            }
            return (string) $group;
        } catch (\Throwable $e) {
            $key = config('modular-luncher.resource.navigation_group');
            return (bool) $key ? (string) __($key) : null;
        }
    }

    /**
     * Get the navigation sort order.
     */
    public static function getNavigationSort(): ?int
    {
        try {
            return ModularLuncherPlugin::get()->getNavigationSort();
        } catch (\Throwable $e) {
            return (int) config('modular-luncher.resource.navigation_sort');
        }
    }

    /**
     * Get the navigation badge for the resource.
     */
    public static function getNavigationBadge(): ?string
    {
        try {
            return ModularLuncherPlugin::get()->getNavigationCountBadge();
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Configure the table for the resource.
     */
    public static function table(Table $table): Table
    {
        return ModuleTable::configure($table);
    }

    /**
     * Configure the infolist for the resource.
     */
    public static function infolist(Schema $schema): Schema
    {
        return ModuleInfolist::configure($schema);
    }

    /**
     * Determine if the user can view any records.
     */
    public static function canViewAny(): bool
    {
        if (! (bool) config('modular-luncher.resource.authorize', true)) {
            return true;
        }

        return parent::canViewAny();
    }

    /**
     * Determine if the user can view a specific record.
     */
    public static function canView(Model $record): bool
    {
        if (! (bool) config('modular-luncher.resource.authorize', true)) {
            return true;
        }

        return parent::canView($record);
    }

    /**
     * Get the relations for the resource.
     *
     * @return array<class-string<\Filament\Resources\RelationManagers\RelationManager>|\Filament\Resources\RelationManagers\RelationGroup|\Filament\Resources\RelationManagers\RelationManagerConfiguration>
     */
    public static function getRelations(): array
    {
        return [
            ModuleBackupsRelationManager::class,
        ];
    }

    /**
     * Get the pages for the resource.
     *
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListModules::route('/'),
            'view' => ViewModule::route('/{record}'),
        ];
    }
}
