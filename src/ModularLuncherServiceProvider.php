<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher;

use AlizHarb\ModularLuncher\Services\ModuleService;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the Filament Modular Luncher package.
 *
 * Responsible for registering services, merging configuration,
 * and bootstrapping package resources like translations and views.
 */
final class ModularLuncherServiceProvider extends ServiceProvider
{
    /**
     * Register the package services and merge configuration.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/modular-luncher.php', 'modular-luncher');

        $this->app->singleton(ModuleService::class, fn () => new ModuleService);
    }

    /**
     * Bootstrap the package resources.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'modular-luncher');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/modular-luncher.php' => config_path('modular-luncher.php'),
            ], 'modular-luncher-config');

            $this->publishes([
                __DIR__.'/../lang' => lang_path('vendor/modular-luncher'),
            ], 'modular-luncher-translations');
        }
    }
}
