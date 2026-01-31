<?php

use AlizHarb\ModularLuncher\Models\Module;
use Illuminate\Support\Collection;

it('can get all modules as collection', function () {
    $modules = Module::allModules();

    expect($modules)
        ->toBeInstanceOf(Collection::class);
});

it('can find a specific module by name', function () {
    $modules = Module::allModules();

    if ($modules->isEmpty()) {
        expect($modules)->toBeEmpty();

        return;
    }

    $firstModuleName = $modules->first()->name;
    $module = Module::findModule($firstModuleName);

    expect($module)
        ->not->toBeNull()
        ->and($module->name)->toBe($firstModuleName);
});

it('returns null for non-existent module', function () {
    $module = Module::findModule('NonExistentModule');

    expect($module)->toBeNull();
});

it('module has correct attributes', function () {
    $modules = Module::allModules();

    if ($modules->isEmpty()) {
        expect($modules)->toBeEmpty();

        return;
    }

    $module = $modules->first();

    expect($module->name)->toBeString()
        ->and($module->version)->toBeString()
        ->and($module->is_enabled)->toBeBool()
        ->and($module->path)->toBeString()
        ->and($module->namespace)->toBeString();
});

it('module primary key is name', function () {
    $module = new Module;

    expect($module->getKeyName())->toBe('name')
        ->and($module->getKeyType())->toBe('string')
        ->and($module->getIncrementing())->toBeFalse();
});

it('module exists property is true for existing modules', function () {
    $modules = Module::allModules();

    if ($modules->isEmpty()) {
        expect($modules)->toBeEmpty();

        return;
    }

    $module = $modules->first();
    expect($module->exists)->toBeTrue();
});

it('filters excluded modules from config', function () {
    config(['modular-luncher.exclude' => ['TestModule']]);

    $modules = Module::allModules();

    expect($modules->has('TestModule'))->toBeFalse();
});
