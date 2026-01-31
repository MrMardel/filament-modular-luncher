<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Tests\Unit;

use AlizHarb\ModularLuncher\Models\ModuleBackup;
use AlizHarb\ModularLuncher\Services\ModuleService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

describe('Module Backup Model and Service', function () {

    beforeEach(function () {
        Storage::fake('local');
        config(['modular-luncher.backups.disk' => 'local']);
        config(['modular-luncher.backups.storage_path' => 'module-backups']);

        // Mock the Registry
        $registry = \Mockery::mock();
        $registry->shouldReceive('getModules')->andReturn(['TestModule' => []]);
        $registry->shouldReceive('getPath')->andReturn('/fake/path');
        $registry->shouldReceive('clearCache')->byDefault();

        app()->instance('modular.registry', $registry);
    });

    it('can list backups via service', function () {
        $disk = Storage::disk('local');
        $filename = 'TestModule_2024-01-01_120000.zip';
        $disk->put('module-backups/'.$filename, 'fake content');

        $service = new ModuleService;
        $backups = $service->getBackups('TestModule');

        expect($backups)->toHaveCount(1);
        expect($backups[0]['filename'])->toBe($filename);
    });

    it('populates sushi rows from mocked service', function () {
        $service = \Mockery::mock(ModuleService::class);
        $service->shouldReceive('getBackups')->with('TestModule')->andReturn([
            [
                'filename' => 'TestModule_Sushi.zip',
                'size' => 500,
                'created_at' => time(),
            ],
        ]);

        app()->instance(ModuleService::class, $service);

        // Sushi models in tests can be tricky with static cache.
        // We use a fresh model and hope getRows() is called as expected.
        $model = new ModuleBackup;
        $rows = $model->getRows();

        expect($rows)->toHaveCount(1);
        expect($rows[0]['module_name'])->toBe('TestModule');
        expect($rows[0]['filename'])->toBe('TestModule_Sushi.zip');
    });

    it('can restore from specific backup file', function () {
        $disk = Storage::disk('local');
        $backupFile = 'TestModule_specific.zip';
        $disk->put('module-backups/'.$backupFile, 'fake content');
        $backupPath = $disk->path('module-backups/'.$backupFile);

        // Use an anonymous class to reliably mock the protected extractAndProcess method
        $service = new class extends ModuleService
        {
            public bool $extractCalled = false;

            #[\Override]
            protected function extractAndProcess(string $backupPath, string $targetPath, bool $force = false): void
            {
                $this->extractCalled = true;
                // No-op for test
            }
        };

        File::partialMock();
        File::shouldReceive('exists')->with('/fake/path/TestModule')->andReturn(true);
        File::shouldReceive('deleteDirectory')->once();

        $service->restore('TestModule', $backupFile);

        expect($service->extractCalled)->toBeTrue();
    });
});
