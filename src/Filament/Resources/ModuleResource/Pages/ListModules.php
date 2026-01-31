<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Pages;

use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource;
use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Tables\ModuleTable;
use AlizHarb\ModularLuncher\Filament\Widgets\ModuleStatsOverviewWidget;
use AlizHarb\ModularLuncher\Models\Module;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

/**
 * Page class for listing and managing modules.
 *
 * Provides a tabbed interface for filtering modules by their status
 * and displays aggregate statistics via header widgets.
 */
class ListModules extends ListRecords
{
    /** @var string The resource associated with the page */
    protected static string $resource = ModuleResource::class;



    /**
     * Get the header actions for the page.
     *
     * @return array<int, \Filament\Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            ModuleTable::installAction(),
        ];
    }

    /**
     * Get the header widgets for the page.
     *
     * @return array<class-string<\Filament\Widgets\Widget>|\Filament\Widgets\WidgetConfiguration>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            ModuleStatsOverviewWidget::class,
        ];
    }

    /**
     * Get the tabbed navigation for filtering records.
     *
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        $modules = Module::all();

        return [
            'all' => Tab::make(__('modular-luncher::modules.resource.plural_label'))
                ->icon('heroicon-m-list-bullet')
                ->badge($modules->count()),
            'active' => Tab::make(__('modular-luncher::modules.filters.status.enabled'))
                ->icon('heroicon-m-check-circle')
                ->badge($modules->where('is_enabled', true)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn ($query) => $query->where('is_enabled', true)),
            'disabled' => Tab::make(__('modular-luncher::modules.filters.status.disabled'))
                ->icon('heroicon-m-x-circle')
                ->badge($modules->where('is_enabled', false)->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn ($query) => $query->where('is_enabled', false)),
        ];
    }
}
