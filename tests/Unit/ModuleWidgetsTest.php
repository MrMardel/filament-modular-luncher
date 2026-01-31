<?php

use AlizHarb\ModularLuncher\Filament\Widgets\ModuleStatsOverviewWidget;
use AlizHarb\ModularLuncher\Filament\Widgets\RecentModulesWidget;
use AlizHarb\ModularLuncher\Models\Module;

/**
 * Unit Tests for Module Widgets
 *
 * Tests all available premium widgets.
 */
describe('Module Widgets Unit Tests', function () {

    describe('ModuleStatsOverviewWidget', function () {

        it('can instantiate stats widget', function () {
            $widget = new ModuleStatsOverviewWidget;
            expect($widget)->toBeInstanceOf(ModuleStatsOverviewWidget::class);
        });

        it('has getStats method', function () {
            expect(method_exists(ModuleStatsOverviewWidget::class, 'getStats'))->toBeTrue();
        });

        it('can get stats array', function () {
            $widget = new ModuleStatsOverviewWidget;
            $reflection = new ReflectionMethod($widget, 'getStats');
            $reflection->setAccessible(true);

            $stats = $reflection->invoke($widget);

            expect($stats)->toBeArray()
                ->and(count($stats))->toBeGreaterThanOrEqual(3);
        });
    });

    describe('RecentModulesWidget', function () {

        it('can instantiate recent modules widget', function () {
            $widget = new RecentModulesWidget;
            expect($widget)->toBeInstanceOf(RecentModulesWidget::class);
        });

        it('has table method', function () {
            expect(method_exists(RecentModulesWidget::class, 'table'))->toBeTrue();
        });

        it('validates widget extends base widget', function () {
            $reflection = new ReflectionClass(RecentModulesWidget::class);
            $parent = $reflection->getParentClass();

            expect($parent)->not->toBeFalse()
                ->and($parent->getName())->toContain('Widget');
        });
    });

    it('validates all widgets have proper configuration', function () {
        $widgets = [
            ModuleStatsOverviewWidget::class,
            RecentModulesWidget::class,
        ];

        foreach ($widgets as $widgetClass) {
            $reflection = new ReflectionClass($widgetClass);
            expect($reflection->isFinal())->toBeTrue("Widget {$widgetClass} should be final");
        }
    });
});
