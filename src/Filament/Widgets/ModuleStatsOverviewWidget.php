<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Widgets;

use AlizHarb\ModularLuncher\Models\Module;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Overview statistics widget for the modular system.
 *
 * Displays high-level metrics including total installed modules,
 * active vs. inactive counts, and a computed health percentage.
 */
final class ModuleStatsOverviewWidget extends BaseWidget
{
    /** @var int|null Determine the order of the widget on the dashboard */
    protected static ?int $sort = 1;

    /**
     * Get the statistical data points for the widget.
     *
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        $modules = Module::allModules();
        $total = $modules->count();
        $enabled = $modules->where('is_enabled', true)->count();
        $disabled = $total - $enabled;

        $healthyModules = $modules->filter(function (Module $module): bool {
            return $module->has_migrations && $module->has_views;
        })->count();

        $healthPercentage = $total > 0 ? (int) round(($healthyModules / $total) * 100) : 0;

        return [
            Stat::make(__('modular-luncher::modules.widgets.stats.total_modules'), $total)
                ->description(__('modular-luncher::modules.widgets.stats.total_description'))
                ->descriptionIcon('heroicon-o-cube')
                ->color('primary')
                ->chart($this->getModuleTrendData()),

            Stat::make(__('modular-luncher::modules.widgets.stats.enabled_modules'), $enabled)
                ->description(__('modular-luncher::modules.widgets.stats.enabled_description', ['count' => $disabled]))
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ]),

            Stat::make(__('modular-luncher::modules.widgets.stats.module_health'), $healthPercentage.'%')
                ->description(__('modular-luncher::modules.widgets.stats.health_description'))
                ->descriptionIcon($healthPercentage >= 80 ? 'heroicon-o-heart' : 'heroicon-o-exclamation-triangle')
                ->color($healthPercentage >= 80 ? 'success' : ($healthPercentage >= 50 ? 'warning' : 'danger')),
        ];
    }

    /**
     * Generate simulated trend data for the module count chart.
     *
     * @return array<int, int>
     */
    protected function getModuleTrendData(): array
    {
        $modules = Module::allModules();
        $count = $modules->count();

        return [
            max(0, $count - 2),
            max(0, $count - 1),
            $count,
            $count,
            $count,
            $count,
            $count,
        ];
    }
}
