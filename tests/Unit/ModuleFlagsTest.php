<?php

namespace AlizHarb\ModularLuncher\Tests\Unit;

use AlizHarb\ModularLuncher\Data\ModuleData;
use AlizHarb\ModularLuncher\Services\ModuleService;
use Exception;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    // Mock the Activator
    $activator = \Mockery::mock('AlizHarb\Modular\Contracts\Activator');
    $activator->shouldReceive('isEnabled')->andReturn(true);
    $activator->shouldReceive('delete')->byDefault();
    $activator->shouldReceive('setStatus')->byDefault();

    // Mock the Registry since it's a final class
    $registry = \Mockery::mock();
    $registry->shouldReceive('getActivator')->andReturn($activator);
    $registry->shouldReceive('getPath')->andReturn('/fake/path');
    $registry->shouldReceive('clearCache')->byDefault();

    // Swap the instance in the container
    app()->instance('modular.registry', $registry);
});

it('prevents uninstallation when module is not removeable', function () {
    $registry = app('modular.registry');
    $registry->shouldReceive('getModule')->with('CoreModule')->andReturn([
        'name' => 'CoreModule',
        'path' => '/fake/path/CoreModule',
        'version' => '1.0.0',
        'removeable' => false,
    ]);

    $service = new ModuleService;

    expect(fn () => $service->uninstall('CoreModule'))
        ->toThrow(Exception::class);
});

it('allows uninstallation when module is removeable', function () {
    $registry = app('modular.registry');
    $registry->shouldReceive('getModule')->with('ExtraModule')->andReturn([
        'name' => 'ExtraModule',
        'path' => '/fake/path/ExtraModule',
        'version' => '1.0.0',
        'removeable' => true,
    ]);

    File::shouldReceive('deleteDirectory')->once();

    $service = new ModuleService;
    $service->uninstall('ExtraModule');
    
});

it('correctly maps flags in ModuleData', function () {
    $data = ModuleData::from([
        'name' => 'Test',
        'version' => '1.0',
        'path' => 'path',
        'namespace' => 'ns',
        'description' => 'desc',
        'authors' => [],
        'providers' => [],
        'files' => [],
        'requires' => [],
        'is_enabled' => true,
        'has_views' => false,
        'has_migrations' => false,
        'has_translations' => false,
        'is_removeable' => false,
        'is_disableable' => true,
    ]);

    expect($data->is_removeable)->toBeFalse()
        ->and($data->is_disableable)->toBeTrue();
});
