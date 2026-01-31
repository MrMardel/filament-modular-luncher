<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
final class ModuleData extends Data
{
    public function __construct(
        public string $name,
        public string $version,
        public string $path,
        public string $namespace,
        public string $description,
        public array $authors,
        public array $providers,
        public array $files,
        public array $requires,
        public bool $is_enabled,
        public bool $has_views,
        public bool $has_migrations,
        public bool $has_translations,
        public bool $is_removeable = true,
        public bool $is_disableable = true,
    ) {}
}
