<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Url;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
final class InstallModuleData extends Data
{
    public function __construct(
        #[Required]
        public string $sourceType, // 'zip', 'url', 'composer'

        public ?string $filePath = null, // Temporary path for uploaded ZIP

        public ?string $url = null, // For GitHub or direct ZIP link

        public ?string $composerPackage = null, // For composer source

        public bool $enableAfterInstall = true,
    ) {}
}
