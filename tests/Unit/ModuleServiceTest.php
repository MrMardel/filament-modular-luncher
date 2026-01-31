<?php

use AlizHarb\ModularLuncher\Data\InstallModuleData;
use AlizHarb\ModularLuncher\Exceptions\ModuleInstallationException;
use AlizHarb\ModularLuncher\Services\ModuleService;

/**
 * Unit Tests for ModuleService
 *
 * Tests core service methods for module management.
 */
describe('ModuleService Unit Tests', function () {

    beforeEach(function () {
        $this->service = app(ModuleService::class);
    });

    it('can instantiate module service', function () {
        expect($this->service)->toBeInstanceOf(ModuleService::class);
    });

    it('validates install data structure', function () {
        $data = InstallModuleData::from([
            'sourceType' => 'zip',
            'filePath' => '/tmp/test.zip',
            'enableAfterInstall' => true,
        ]);

        expect($data->sourceType)->toBe('zip')
            ->and($data->filePath)->toBe('/tmp/test.zip')
            ->and($data->enableAfterInstall)->toBeTrue();
    });

    it('throws exception for unsupported source type', function () {
        $data = InstallModuleData::from([
            'sourceType' => 'invalid',
            'filePath' => '/tmp/test.zip',
        ]);

        expect(fn () => $this->service->install($data))
            ->toThrow(ModuleInstallationException::class);
    });

    it('validates backup method exists', function () {
        expect(method_exists($this->service, 'backup'))->toBeTrue();
    });

    it('validates restore method exists', function () {
        expect(method_exists($this->service, 'restore'))->toBeTrue();
    });

    it('validates update method exists', function () {
        expect(method_exists($this->service, 'update'))->toBeTrue();
    });

    it('validates uninstall method exists', function () {
        expect(method_exists($this->service, 'uninstall'))->toBeTrue();
    });
});
