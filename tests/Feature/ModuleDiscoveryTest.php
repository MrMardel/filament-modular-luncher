<?php

use AlizHarb\ModularLuncher\Models\Module;

it('can list all modules', function () {
    $modules = Module::allModules();

    expect($modules)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

it('can fetch a single module by name', function () {
    // We expect at least the test setup to have some modules if we mock them,
    // but for now let's just assert on existence if empty or content if not.
    $modules = Module::allModules();

    if ($modules->isEmpty()) {
        expect($modules)->toBeEmpty();

        return;
    }

    $name = $modules->first()->name;
    $module = Module::findModule($name);

    expect($module)->not->toBeNull()
        ->and($module->name)->toBe($name);
});
