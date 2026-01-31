<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Exceptions;

use Exception;

/**
 * Exception thrown when module operations fail.
 */
final class ModuleOperationException extends Exception
{
    public static function notFound(string $name): self
    {
        return new self(__('modular-luncher::modules.errors.not_found', ['name' => $name]));
    }

    public static function notRemoveable(string $name): self
    {
        return new self(__('modular-luncher::modules.errors.not_removeable', ['name' => $name]));
    }

    public static function notDisableable(string $name): self
    {
        return new self(__('modular-luncher::modules.errors.not_disableable', ['name' => $name]));
    }

    public static function backupFailed(string $name, string $reason): self
    {
        return new self(__('modular-luncher::modules.errors.backup_failed', ['name' => $name, 'reason' => $reason]));
    }

    public static function restoreFailed(string $name, string $reason): self
    {
        return new self(__('modular-luncher::modules.errors.restore_failed', ['name' => $name, 'reason' => $reason]));
    }
}
