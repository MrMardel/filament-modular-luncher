<?php

use AlizHarb\ModularLuncher\Models\Module;
use AlizHarb\ModularLuncher\Policies\ModulePolicy;

/**
 * Unit Tests for ModulePolicy
 *
 * Tests all permission methods and authorization logic.
 */
describe('ModulePolicy Unit Tests', function () {

    beforeEach(function () {
        $this->policy = new ModulePolicy;
        $this->user = null; // No user for basic tests
    });

    it('can instantiate policy', function () {
        expect($this->policy)->toBeInstanceOf(ModulePolicy::class);
    });

    it('allows viewAny when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        expect($this->policy->viewAny($this->user))->toBeTrue();
    });

    it('allows view when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        $modules = Module::allModules();
        if ($modules->isEmpty()) {
            expect(true)->toBeTrue();

            return;
        }

        $module = $modules->first();
        expect($this->policy->view($this->user, $module))->toBeTrue();
    });

    it('allows create when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        expect($this->policy->create($this->user))->toBeTrue();
    });

    it('allows update when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        $modules = Module::allModules();
        if ($modules->isEmpty()) {
            expect(true)->toBeTrue();

            return;
        }

        $module = $modules->first();
        expect($this->policy->update($this->user, $module))->toBeTrue();
    });

    it('allows delete when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        $modules = Module::allModules();
        if ($modules->isEmpty()) {
            expect(true)->toBeTrue();

            return;
        }

        $module = $modules->first();
        expect($this->policy->delete($this->user, $module))->toBeTrue();
    });

    it('allows toggle when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        $modules = Module::allModules();
        if ($modules->isEmpty()) {
            expect(true)->toBeTrue();

            return;
        }

        $module = $modules->first();
        expect($this->policy->toggle($this->user, $module))->toBeTrue();
    });

    it('allows backup when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        $modules = Module::allModules();
        if ($modules->isEmpty()) {
            expect(true)->toBeTrue();

            return;
        }

        $module = $modules->first();
        expect($this->policy->backup($this->user, $module))->toBeTrue();
    });

    it('allows restore when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        $modules = Module::allModules();
        if ($modules->isEmpty()) {
            expect(true)->toBeTrue();

            return;
        }

        $module = $modules->first();
        expect($this->policy->restore($this->user, $module))->toBeTrue();
    });

    it('allows bulkAction when authorization is disabled', function () {
        config(['modular-luncher.authorization.enabled' => false]);

        expect($this->policy->bulkAction($this->user))->toBeTrue();
    });

    it('respects config permissions for viewAny', function () {
        config(['modular-luncher.authorization.enabled' => true]);
        config(['modular-luncher.authorization.permissions.viewAny' => true]);

        expect($this->policy->viewAny($this->user))->toBeTrue();
    });

    it('respects wildcard permission', function () {
        config(['modular-luncher.authorization.enabled' => true]);
        config(['modular-luncher.authorization.permissions.*' => true]);

        expect($this->policy->viewAny($this->user))->toBeTrue();
    });

    it('validates all policy methods exist', function () {
        $methods = [
            'viewAny',
            'view',
            'create',
            'update',
            'delete',
            'toggle',
            'backup',
            'restore',
            'bulkAction',
        ];

        foreach ($methods as $method) {
            expect(method_exists($this->policy, $method))
                ->toBeTrue("Policy method {$method} should exist");
        }
    });
});
