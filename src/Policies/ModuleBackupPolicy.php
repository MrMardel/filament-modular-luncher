<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Policies;

use AlizHarb\ModularLuncher\Models\ModuleBackup;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Gate;

final class ModuleBackupPolicy
{
    /**
     * Determine if the user can view any module backups.
     */
    public function viewAny(?Authenticatable $user): bool
    {
        return $this->canManage($user, 'viewAny');
    }

    /**
     * Determine if the user can view a specific module backup.
     */
    public function view(?Authenticatable $user, ModuleBackup $backup): bool
    {
        return $this->canManage($user, 'view', $backup);
    }

    /**
     * Determine if the user can create module backups.
     */
    public function create(?Authenticatable $user): bool
    {
        return $this->canManage($user, 'create');
    }

    /**
     * Determine if the user can update module backups.
     */
    public function update(?Authenticatable $user, ModuleBackup $backup): bool
    {
        return $this->canManage($user, 'update', $backup);
    }

    /**
     * Determine if the user can delete module backups.
     */
    public function delete(?Authenticatable $user, ModuleBackup $backup): bool
    {
        return $this->canManage($user, 'delete', $backup);
    }

    /**
     * Determine if the user can restore module backups.
     */
    public function restore(?Authenticatable $user, ModuleBackup $backup): bool
    {
        return $this->canManage($user, 'restore', $backup);
    }

    /**
     * Determine if the user can force delete module backups.
     */
    public function forceDelete(?Authenticatable $user, ModuleBackup $backup): bool
    {
        return $this->canManage($user, 'forceDelete', $backup);
    }

    /**
     * Centralized authorization logic.
     */
    protected function canManage(?Authenticatable $user, string $ability, ?ModuleBackup $backup = null): bool
    {
        // Check if authorization is disabled globally
        if (! (bool) config('modular-luncher.authorization.enabled', true)) {
            return true;
        }

        // Check internal permissions config
        $permissions = config('modular-luncher.authorization.permissions', []);
        if (isset($permissions['backup']) && $permissions['backup']) {
            return true;
        }

        // Check Gate
        if (Gate::has("module.backup:{$ability}")) {
            return Gate::allows("module.backup:{$ability}", [$user, $backup]);
        }

        // Check user ability
        if ($user instanceof Authorizable) {
            return (bool) $user->can("module.backup:{$ability}") || (bool) $user->can('module:backup');
        }

        return (bool) config('modular-luncher.authorization.default_deny', false);
    }
}
