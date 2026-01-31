<?php

use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Tables\ModuleTable;
use Filament\Tables\Table;

/**
 * Unit Tests for ModuleTable
 *
 * Tests table configuration and structure.
 */
describe('ModuleTable Unit Tests', function () {

    it('can configure table', function () {
        $table = \Mockery::mock(Table::class);
        $table->shouldReceive('columns')->andReturnSelf();
        $table->shouldReceive('filters')->andReturnSelf();
        $table->shouldReceive('actions')->andReturnSelf();
        $table->shouldReceive('recordActions')->andReturnSelf();
        $table->shouldReceive('bulkActions')->andReturnSelf();
        $table->shouldReceive('headerActions')->andReturnSelf();
        $table->shouldReceive('filtersFormColumns')->andReturnSelf();
        $table->shouldReceive('persistFiltersInSession')->andReturnSelf();
        $table->shouldReceive('toolbarActions')->andReturnSelf();
        $table->shouldReceive('deferLoading')->andReturnSelf();
        $table->shouldReceive('recordUrl')->andReturnSelf();
        $table->shouldReceive('striped')->andReturnSelf();
        $table->shouldReceive('defaultSort')->andReturnSelf();
        $table->shouldReceive('poll')->andReturnSelf();

        $configured = ModuleTable::configure($table);

        expect($configured)->toBeInstanceOf(Table::class);
    });

    it('validates configure method is static', function () {
        $reflection = new ReflectionMethod(ModuleTable::class, 'configure');
        expect($reflection->isStatic())->toBeTrue();
    });

    it('validates configure method returns table', function () {
        $reflection = new ReflectionMethod(ModuleTable::class, 'configure');
        $returnType = $reflection->getReturnType();

        expect($returnType)->not->toBeNull()
            ->and($returnType->getName())->toBe(Table::class);
    });

    it('has getColumns method', function () {
        expect(method_exists(ModuleTable::class, 'getColumns'))->toBeTrue();
    });

    it('has getRecordActions method', function () {
        expect(method_exists(ModuleTable::class, 'getRecordActions'))->toBeTrue();
    });

    it('has getHeaderActions method', function () {
        expect(method_exists(ModuleTable::class, 'getHeaderActions'))->toBeTrue();
    });

    it('has getFilters method', function () {
        expect(method_exists(ModuleTable::class, 'getFilters'))->toBeTrue();
    });

    it('has getBulkActions method', function () {
        expect(method_exists(ModuleTable::class, 'getBulkActions'))->toBeTrue();
    });

    it('validates all action methods exist', function () {
        $methods = [
            'toggleAction',
            'updateAction',
            'viewAction',
            'backupAction',
            'restoreAction',
            'uninstallAction',
            'installAction',
        ];

        foreach ($methods as $method) {
            expect(method_exists(ModuleTable::class, $method))
                ->toBeTrue("Method {$method} should exist");
        }
    });
});
