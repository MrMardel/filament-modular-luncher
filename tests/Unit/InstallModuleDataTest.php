<?php

use AlizHarb\ModularLuncher\Data\InstallModuleData;

it('can create install module data from array', function () {
    $data = InstallModuleData::from([
        'source_type' => 'zip',
        'file_path' => '/path/to/module.zip',
    ]);

    expect($data)
        ->toBeInstanceOf(InstallModuleData::class)
        ->and($data->sourceType)->toBe('zip')
        ->and($data->filePath)->toBe('/path/to/module.zip');
});

it('validates source type for url', function () {
    $data = InstallModuleData::from([
        'source_type' => 'url',
        'url' => 'https://github.com/owner/repo/archive/main.zip',
    ]);

    expect($data->sourceType)->toBe('url')
        ->and($data->url)->toBe('https://github.com/owner/repo/archive/main.zip');
});

it('handles composer source', function () {
    $data = InstallModuleData::from([
        'source_type' => 'composer',
        'composer_package' => 'vendor/package',
    ]);

    expect($data->sourceType)->toBe('composer')
        ->and($data->composerPackage)->toBe('vendor/package');
});

it('handles url with enable after install flag', function () {
    $data = InstallModuleData::from([
        'source_type' => 'url',
        'url' => 'https://example.com/module.zip',
        'enable_after_install' => false,
    ]);

    expect($data->sourceType)->toBe('url')
        ->and($data->url)->toBe('https://example.com/module.zip')
        ->and($data->enableAfterInstall)->toBeFalse();
});

it('defaults enable after install to true', function () {
    $data = InstallModuleData::from([
        'source_type' => 'zip',
        'file_path' => '/tmp/module.zip',
    ]);

    expect($data->enableAfterInstall)->toBeTrue();
});

it('can convert to array', function () {
    $data = InstallModuleData::from([
        'source_type' => 'url',
        'url' => 'https://example.com/module.zip',
    ]);

    $array = $data->toArray();

    expect($array)
        ->toBeArray()
        ->toHaveKey('source_type')
        ->toHaveKey('url');
});
