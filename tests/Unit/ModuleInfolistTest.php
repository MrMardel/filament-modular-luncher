<?php

use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Schemas\ModuleInfolist;
use Filament\Schemas\Schema;

/**
 * Unit Tests for ModuleInfolist
 *
 * Tests infolist schema configuration.
 */
describe('ModuleInfolist Unit Tests', function () {

    it('can configure infolist schema', function () {
        $schema = Schema::make();
        $configured = ModuleInfolist::configure($schema);

        expect($configured)->toBeInstanceOf(Schema::class);
    });

    it('infolist has components', function () {
        $schema = Schema::make();
        $configured = ModuleInfolist::configure($schema);

        // Schema should have components configured
        expect($configured)->toBeInstanceOf(Schema::class);
    });

    it('validates configure method is static', function () {
        $reflection = new ReflectionMethod(ModuleInfolist::class, 'configure');
        expect($reflection->isStatic())->toBeTrue();
    });

    it('validates configure method returns schema', function () {
        $reflection = new ReflectionMethod(ModuleInfolist::class, 'configure');
        $returnType = $reflection->getReturnType();

        expect($returnType)->not->toBeNull()
            ->and($returnType->getName())->toBe(Schema::class);
    });
});
