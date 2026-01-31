<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Tests;

use AlizHarb\Modular\ModularServiceProvider;
use AlizHarb\ModularLuncher\ModularLuncherServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Panel;
use Filament\Schemas\SchemasServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $modulesPath = base_path('modules');
        if (! file_exists($modulesPath)) {
            mkdir($modulesPath, 0755, true);
        }

        // Create a mock module for testing
        $mockModulePath = $modulesPath.'/TestModule';
        if (! file_exists($mockModulePath)) {
            mkdir($mockModulePath, 0755, true);
            file_put_contents($mockModulePath.'/module.json', json_encode([
                'name' => 'TestModule',
                'namespace' => 'Modules\\TestModule\\',
                'version' => '1.0.0',
                'description' => 'A test module',
            ]));
        }

        // Force discovery
        app('modular.registry')->discoverModules();

        \Illuminate\Support\Facades\Gate::policy(\AlizHarb\ModularLuncher\Models\ModuleBackup::class, \AlizHarb\ModularLuncher\Policies\ModuleBackupPolicy::class);

        // Initialize and share a robust ViewErrorBag named class
        $errors = new \Illuminate\Support\ViewErrorBag;
        $defaultBag = new \Illuminate\Support\MessageBag;
        $errors->put('default', $defaultBag);

        // Share with view
        $this->app['view']->share('errors', $errors);

        // Push to session explicitly
        if ($this->app->bound('session')) {
            $this->app['session']->put('errors', $errors);
            $this->app['session']->save();
        }

        // Ensure the container has it too
        $this->app->instance('Illuminate\Support\ViewErrorBag', $errors);
        $this->app->instance('Illuminate\Contracts\Support\MessageBag', $defaultBag);
        $this->app->instance('view.error_bag', $errors);
    }

    #[\Override]
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            FormsServiceProvider::class,
            TablesServiceProvider::class,
            InfolistsServiceProvider::class,
            SchemasServiceProvider::class,
            ActionsServiceProvider::class,
            NotificationsServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentServiceProvider::class,
            ModularServiceProvider::class,
            ModularLuncherServiceProvider::class,
            \BladeUI\Icons\BladeIconsServiceProvider::class,
            \BladeUI\Heroicons\BladeHeroiconsServiceProvider::class,
            \Spatie\LaravelData\LaravelDataServiceProvider::class,
        ];
    }

    #[\Override]
    protected function getPackageAliases($app): array
    {
        return [
            'Modular' => \AlizHarb\Modular\Facades\Modular::class,
            'Hook' => \AlizHarb\LaravelHooks\Facades\Hook::class,
            'File' => \Illuminate\Support\Facades\File::class,
            'Config' => \Illuminate\Support\Facades\Config::class,
            'Storage' => \Illuminate\Support\Facades\Storage::class,
            'Process' => \Illuminate\Support\Facades\Process::class,
        ];
    }

    #[\Override]
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('modular.paths.modules', base_path('modules'));

        // Mocking the activator
        $app['config']->set('modular.activator', 'file');
        $app->bind(\AlizHarb\Modular\Contracts\Activator::class, \AlizHarb\Modular\Activators\FileActivator::class);

        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        // Session configuration for Livewire
        $app['config']->set('session.driver', 'array');
        $app['config']->set('session.lifetime', 120);
        $app['config']->set('session.expire_on_close', false);

        $app['view']->share('errors', new \Illuminate\Support\ViewErrorBag);

        // Register middleware
        $app['router']->aliasMiddleware('share_errors_from_session', \Illuminate\View\Middleware\ShareErrorsFromSession::class);
        $app['router']->pushMiddlewareToGroup('web', \Illuminate\Session\Middleware\StartSession::class);
        $app['router']->pushMiddlewareToGroup('web', \Illuminate\View\Middleware\ShareErrorsFromSession::class);

        $app->booting(function () {
            \Filament\Facades\Filament::registerPanel(
                Panel::make()
                    ->id('admin')
                    ->default()
                    ->path('admin')
                    ->middleware([
                        \Illuminate\Cookie\Middleware\EncryptCookies::class,
                        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                        \Illuminate\Session\Middleware\StartSession::class,
                        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                        \Illuminate\Routing\Middleware\SubstituteBindings::class,
                    ])
            );

            \Livewire\Livewire::listen('component.boot', function ($component) {
                if (method_exists($component, 'setErrorBag') && method_exists($component, 'getErrorBag')) {
                    if ($component->getErrorBag() === null) {
                        $component->setErrorBag(new \Illuminate\Support\MessageBag);
                    }
                }
            });
        });
    }
}
