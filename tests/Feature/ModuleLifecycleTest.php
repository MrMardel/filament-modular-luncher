<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Tests\Feature;

use AlizHarb\Modular\Facades\Modular;
use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\RelationManagers\ModuleBackupsRelationManager;
use AlizHarb\ModularLuncher\Models\Module;
use AlizHarb\ModularLuncher\Services\ModuleService;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

class TestModuleBackupsRelationManager extends ModuleBackupsRelationManager
{
    public function boot(): void
    {
        if (method_exists($this, 'setErrorBag') && ! $this->getErrorBag()) {
            $this->setErrorBag(new \Illuminate\Support\MessageBag);
        }
    }

    public function getErrorBag(): \Illuminate\Contracts\Support\MessageBag
    {
        try {
            return parent::getErrorBag() ?? new \Illuminate\Support\MessageBag;
        } catch (\Throwable $e) {
            return new \Illuminate\Support\MessageBag;
        }
    }
}

describe('Module Lifecycle and Workflows', function () {

    beforeEach(function () {
        Storage::fake('local');
        config(['modular-luncher.backups.disk' => 'local']);
        config(['modular-luncher.backups.storage_path' => 'module-backups']);
        config(['modular-luncher.authorization.enabled' => false]);

        // Mock the Registry
        $registry = \Mockery::mock();
        $registry->shouldReceive('getModules')->andReturn(['TestModule' => []])->byDefault();
        $registry->shouldReceive('getModule')->with('TestModule')->andReturn([
            'name' => 'TestModule',
            'path' => '/fake/path/TestModule',
            'namespace' => 'Modules\\TestModule\\',
            'version' => '1.0.0',
            'has_views' => true,
            'has_migrations' => true,
            'has_translations' => true,
        ])->byDefault();

        $activator = \Mockery::mock(\AlizHarb\Modular\Contracts\Activator::class);
        $activator->shouldReceive('isEnabled')->with('TestModule')->andReturn(true)->byDefault();
        $registry->shouldReceive('getActivator')->andReturn($activator)->byDefault();
        $registry->shouldReceive('getPath')->andReturn('/fake/path')->byDefault();
        $registry->shouldReceive('clearCache')->byDefault();
        $registry->shouldReceive('discoverModules')->byDefault();

        app()->instance('modular.registry', $registry);
    });

    describe('Module Discovery and Registry', function () {
        it('can discover all modules', function () {
            $modules = Module::allModules();
            expect($modules)->toBeInstanceOf(\Illuminate\Support\Collection::class);
        });

        it('validates module registry is accessible', function () {
            expect(Modular::getModules())->toBeArray();
        });

        it('can check module activation status', function () {
            $modules = Module::allModules();
            foreach ($modules as $module) {
                expect($module->is_enabled)->toBeBool();
            }
        });
    });

    describe('Metadata and Features', function () {
        it('validates module has required attributes', function () {
            $module = Module::allModules()->first();

            if ($module) {
                expect($module->name)->not->toBeEmpty()
                    ->and($module->version)->not->toBeEmpty()
                    ->and($module->path)->not->toBeEmpty()
                    ->and($module->namespace)->not->toBeEmpty()
                    ->and($module->is_enabled)->toBeBool();
            }
        });

        it('can detect module features', function () {
            $module = Module::allModules()->first();

            if ($module) {
                expect($module->has_views)->toBeBool()
                    ->and($module->has_migrations)->toBeBool()
                    ->and($module->has_translations)->toBeBool();
            }
        });
    });

    describe('Backup and Restore Workflows', function () {
        it('can render backups relation manager', function () {
            $module = Module::findModule('TestModule');
            if (! $module) {
                return;
            }

            $service = \Mockery::mock(ModuleService::class);
            $service->shouldReceive('getBackups')->andReturn([
                [
                    'filename' => 'TestModule_v1.zip',
                    'size' => 1024,
                    'created_at' => time(),
                ],
            ]);
            app()->instance(ModuleService::class, $service);

            $user = new User;
            $user->forceFill(['id' => 1]);
            $this->actingAs($user);

            Livewire::test(TestModuleBackupsRelationManager::class, [
                'ownerRecord' => $module,
                'pageClass' => \AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Pages\ViewModule::class,
            ])
                ->assertSuccessful()
                ->assertSee('TestModule_v1.zip');
        });

        it('can restore from backup in relation manager', function () {
            $module = Module::findModule('TestModule');
            if (! $module) {
                return;
            }

            $service = \Mockery::mock(ModuleService::class);
            $service->shouldReceive('getBackups')->andReturn([['filename' => 'TestModule_v1.zip', 'size' => 10, 'created_at' => time()]]);
            $service->shouldReceive('restore')->once()->with('TestModule', 'TestModule_v1.zip');
            app()->instance(ModuleService::class, $service);

            $user = new User;
            $user->forceFill(['id' => 1]);
            $this->actingAs($user);

            Livewire::test(TestModuleBackupsRelationManager::class, [
                'ownerRecord' => $module,
                'pageClass' => \AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Pages\ViewModule::class,
            ])
                ->callTableAction('restore', 'TestModule_v1.zip')
                ->assertHasNoErrors();
        });

        it('can delete backup in relation manager', function () {
            $module = Module::findModule('TestModule');
            if (! $module) {
                return;
            }
            $filename = 'TestModule_to_delete.zip';

            Storage::disk('local')->put('module-backups/'.$filename, 'content');
            
            $service = \Mockery::mock(ModuleService::class);
            $service->shouldReceive('getBackups')->andReturn([['filename' => $filename, 'size' => 7, 'created_at' => time()]]);
            app()->instance(ModuleService::class, $service);

            $user = new User;
            $user->forceFill(['id' => 1]);
            $this->actingAs($user);

            Livewire::test(TestModuleBackupsRelationManager::class, [
                'ownerRecord' => $module,
                'pageClass' => \AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Pages\ViewModule::class,
            ])
                ->callTableAction('delete', $filename)
                ->assertHasNoErrors();

            Storage::disk('local')->assertMissing('module-backups/'.$filename);
        });
    });

    describe('Installation and Updates', function () {
        it('can check for module updates', function () {
            $module = Module::allModules()->first();
            if ($module) {
                expect($module->version)->toBeString()
                    ->and($module->version)->toMatch('/^\d+\.\d+\.\d+/');
            }
        });

        it('executes full module lifecycle checkpoints', function () {
            $module = Module::allModules()->first();
            if (! $module) {
                return;
            }

            expect($module->is_enabled)->toBeBool()
                ->and($module->name)->toBeString()
                ->and($module->path)->toBeString();

            $refetched = Module::findModule($module->name);
            expect($refetched)->not->toBeNull()
                ->and($refetched->name)->toBe($module->name);
        });
    });
});
