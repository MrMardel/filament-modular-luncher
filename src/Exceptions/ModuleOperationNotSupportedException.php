<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Exceptions;

use Exception;

/**
 * Exception thrown when module operations are not supported.
 */
final class ModuleOperationNotSupportedException extends Exception
{
    public static function databaseQueriesNotSupported(): self
    {
        return new self(
            'Module model does not support database queries. Use Module::allModules() instead.'
        );
    }
}
