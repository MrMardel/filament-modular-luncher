<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Widgets;

use AlizHarb\ModularLuncher\Models\Module;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Basic statistics widget for displaying module counts.
 *
 * Provides simple data points for total modules and counts
 * filtered by their enabled/disabled status.
 */
class ModuleStatsWidget extends BaseWidget
{

    /**
     * Get the statistical data points for the widget.
     *
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        $modules = Module::allModules();
        $enabledCount = $modules->where('is_enabled', true)->count();
        $disabledCount = $modules->where('is_enabled', false)->count();

        return [
            Stat::make(__('modular-luncher::modules.widgets.distribution.label'), (string) $modules->count())
                ->description(__('modular-luncher::modules.widgets.stats.total_description'))
                ->descriptionIcon('heroicon-m-cpu-chip')
                ->color('gray'),

            Stat::make(__('modular-luncher::modules.widgets.distribution.enabled'), (string) $enabledCount)
                ->description(__('modular-luncher::modules.widgets.stats.enabled_description', ['count' => $disabledCount]))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(__('modular-luncher::modules.widgets.distribution.disabled'), (string) $disabledCount)
                ->description(__('modular-luncher::modules.widgets.stats.enabled_description', ['count' => $enabledCount]))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
