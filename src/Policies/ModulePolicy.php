<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Policies;

use AlizHarb\ModularLuncher\Models\Module;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Gate;

/**
 * Premium Module Policy with full config-based customization.
 *
 * All permissions are configurable via config/modular-luncher.php
 * and extendable via Laravel Gates and Hooks.
 */
final class ModulePolicy
{
    /**
     * Determine if the user can view any modules.
     */
    public function viewAny(?Authenticatable $user): bool
    {
        // Check if authorization is disabled globally
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        // Check specific permission
        if ($this->hasConfigPermission('viewAny')) {
            return true;
        }

        // Check via Gate if defined
        if (Gate::has('module:viewAny')) {
            return Gate::allows('module:viewAny', $user);
        }

        // Check user ability if user exists
        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:viewAny') || (bool) $user->can('viewAny:Module');
        }

        return (bool) config('modular-luncher.authorization.default_deny', false);
    }

    /**
     * Determine if the user can view a specific module.
     */
    public function view(?Authenticatable $user, Module $module): bool
    {
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        if ($this->hasConfigPermission('view')) {
            return true;
        }

        if (Gate::has('module:view')) {
            return Gate::allows('module:view', [$user, $module]);
        }

        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:view') || (bool) $user->can('view:Module');
        }

        return (bool) config('modular-luncher.authorization.default_deny', false);
    }

    /**
     * Determine if the user can create modules.
     */
    public function create(?Authenticatable $user): bool
    {
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        if ($this->hasConfigPermission('create')) {
            return true;
        }

        if (Gate::has('module:create')) {
            return Gate::allows('module:create', $user);
        }

        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:create') || (bool) $user->can('create:Module');
        }

        return (bool) config('modular-luncher.authorization.default_deny', false);
    }

    /**
     * Determine if the user can update modules.
     */
    public function update(?Authenticatable $user, Module $module): bool
    {
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        if ($this->hasConfigPermission('update')) {
            return true;
        }

        if (Gate::has('module:update')) {
            return Gate::allows('module:update', [$user, $module]);
        }

        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:update') || (bool) $user->can('update:Module');
        }

        return (bool) config('modular-luncher.authorization.default_deny', false);
    }

    /**
     * Determine if the user can delete modules.
     */
    public function delete(?Authenticatable $user, Module $module): bool
    {
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        if ($this->hasConfigPermission('delete')) {
            return true;
        }

        if (Gate::has('module:delete')) {
            return Gate::allows('module:delete', [$user, $module]);
        }

        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:delete') || (bool) $user->can('delete:Module');
        }

        return (bool) config('modular-luncher.authorization.default_deny', false);
    }

    /**
     * Determine if the user can enable/disable modules.
     */
    public function toggle(?Authenticatable $user, Module $module): bool
    {
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        if ($this->hasConfigPermission('toggle')) {
            return true;
        }

        if (Gate::has('module:toggle')) {
            return Gate::allows('module:toggle', [$user, $module]);
        }

        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:toggle') || (bool) $user->can('toggle:Module');
        }

        // Fallback to update permission
        return $this->update($user, $module);
    }

    /**
     * Determine if the user can backup modules.
     */
    public function backup(?Authenticatable $user, Module $module): bool
    {
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        if ($this->hasConfigPermission('backup')) {
            return true;
        }

        if (Gate::has('module:backup')) {
            return Gate::allows('module:backup', [$user, $module]);
        }

        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:backup') || (bool) $user->can('backup:Module');
        }

        // Fallback to update permission
        return $this->update($user, $module);
    }

    /**
     * Determine if the user can restore modules.
     */
    public function restore(?Authenticatable $user, Module $module): bool
    {
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        if ($this->hasConfigPermission('restore')) {
            return true;
        }

        if (Gate::has('module:restore')) {
            return Gate::allows('module:restore', [$user, $module]);
        }

        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:restore') || (bool) $user->can('restore:Module');
        }

        // Fallback to update permission
        return $this->update($user, $module);
    }

    /**
     * Determine if the user can perform bulk operations.
     */
    public function bulkAction(?Authenticatable $user): bool
    {
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        if ($this->hasConfigPermission('bulkAction')) {
            return true;
        }

        if (Gate::has('module:bulkAction')) {
            return Gate::allows('module:bulkAction', $user);
        }

        if ($user instanceof Authorizable) {
            return (bool) $user->can('module:bulkAction') || (bool) $user->can('bulkAction:Module');
        }

        // Fallback to update permission for any module
        return (bool) config('modular-luncher.authorization.default_deny', false);
    }

    /**
     * Check if a permission is allowed via config.
     */
    protected function hasConfigPermission(string $action): bool
    {
        $permissions = config('modular-luncher.authorization.permissions', []);

        // Check if specific action is allowed
        if (isset($permissions[$action])) {
            return (bool) $permissions[$action];
        }

        // Check if all actions are allowed
        if (isset($permissions['*'])) {
            return (bool) $permissions['*'];
        }

        return false;
    }
}
