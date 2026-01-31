<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Exceptions;

use Exception;
use Throwable;

final class ModuleInstallationException extends Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function sourceNotSupported(string $source): self
    {
        return new self(__('modular-luncher::modules.errors.unsupported_source', ['source' => $source]));
    }

    public static function composerFailed(string $error): self
    {
        return new self(__('modular-luncher::modules.errors.composer_failed', ['error' => $error]));
    }

    public static function githubFailed(string $error): self
    {
        return new self(__('modular-luncher::modules.errors.github_failed', ['error' => $error]));
    }

    public static function localFailed(string $reason): self
    {
        return new self(__('modular-luncher::modules.errors.local_failed', ['reason' => $reason]));
    }

    public static function missingParameter(string $parameter): self
    {
        return new self(__('modular-luncher::modules.errors.missing_parameter', ['parameter' => $parameter]));
    }

    public static function zipExtractionFailed(string $error): self
    {
        return new self(__('modular-luncher::modules.errors.zip_failed', ['error' => $error]));
    }

    public static function metadataNotFound(): self
    {
        return new self(__('modular-luncher::modules.errors.metadata_not_found'));
    }

    public static function invalidMetadata(string $path): self
    {
        return new self(__('modular-luncher::modules.errors.invalid_metadata', ['path' => $path]));
    }

    public static function pathNotFound(): self
    {
        return new self(__('modular-luncher::modules.errors.path_not_found'));
    }
}
