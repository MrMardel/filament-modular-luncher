<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Models;

use AlizHarb\Modular\Facades\Modular;
use AlizHarb\ModularLuncher\Data\ModuleData;
use AlizHarb\ModularLuncher\Policies\ModulePolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Sushi\Sushi;

/**
 * Eloquent model representing a system module.
 *
 * This model utilizes Sushi for an in-memory database, bridging the
 * gap between the file-based modular registry and Eloquent functionality.
 *
 * @property string $name
 * @property string $version
 * @property string $path
 * @property string $namespace
 * @property bool $is_enabled
 * @property bool $has_views
 * @property bool $has_migrations
 * @property bool $has_translations
 * @property bool $is_removeable
 * @property bool $is_disableable
 * @property string $description
 * @property array $authors
 * @property array $providers
 * @property array $files
 * @property array $requires
 */
#[UsePolicy(ModulePolicy::class)]
class Module extends Model
{
    use Sushi;

    /** @var string The primary key for the model */
    protected $primaryKey = 'name';

    /** @var string The "type" of the primary key */
    protected $keyType = 'string';

    /** @var bool Indicates if the IDs are auto-incrementing */
    public $incrementing = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'has_views' => 'boolean',
            'has_migrations' => 'boolean',
            'has_translations' => 'boolean',
            'authors' => 'array',
            'providers' => 'array',
            'files' => 'array',
            'requires' => 'array',
            'is_removeable' => 'boolean',
            'is_disableable' => 'boolean',
        ];
    }

    /**
     * Populate the Sushi in-memory database rows.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $modules = Modular::getModules();

        return Collection::make(array_keys($modules))->map(function (string $name) {
            /** @var mixed $moduleData */
            $moduleData = Modular::getModule($name);
            $moduleInfo = (array) $moduleData;

            if ($moduleInfo === []) {
                return null;
            }

            $data = ModuleData::from([
                'name' => $name,
                'version' => $moduleInfo['version'] ?? '1.0.0',
                'path' => $moduleInfo['path'] ?? '',
                'namespace' => $moduleInfo['namespace'] ?? '',
                'description' => $moduleInfo['description'] ?? __('modular-luncher::modules.errors.no_description'),
                'authors' => $moduleInfo['authors'] ?? [],
                'providers' => $moduleInfo['providers'] ?? [],
                'files' => $moduleInfo['files'] ?? [],
                'requires' => $moduleInfo['requires'] ?? [],
                'is_enabled' => Modular::getActivator()->isEnabled($name),
                'has_views' => (bool) ($moduleInfo['has_views'] ?? false),
                'has_migrations' => (bool) ($moduleInfo['has_migrations'] ?? false),
                'has_translations' => (bool) ($moduleInfo['has_translations'] ?? false),
                'is_removeable' => (bool) (isset($moduleInfo['removeable']) ? $moduleInfo['removeable'] : true),
                'is_disableable' => (bool) (isset($moduleInfo['disableable']) ? $moduleInfo['disableable'] : true),
            ])->toArray();

            $data['authors'] = json_encode($data['authors']);
            $data['providers'] = json_encode($data['providers']);
            $data['files'] = json_encode($data['files']);
            $data['requires'] = json_encode($data['requires']);

            return $data;
        })->toArray();
    }

    /** @var array<string, string> Define the column schema for Sushi */
    protected $schema = [
        'name' => 'string',
        'version' => 'string',
        'path' => 'string',
        'namespace' => 'string',
        'is_enabled' => 'boolean',
        'has_views' => 'boolean',
        'has_migrations' => 'boolean',
        'has_translations' => 'boolean',
        'is_removeable' => 'boolean',
        'is_disableable' => 'boolean',
        'description' => 'string',
        'authors' => 'json',
        'providers' => 'json',
        'files' => 'json',
        'requires' => 'json',
    ];

    /**
     * Get all modules as an Eloquent collection.
     *
     * @return Collection<int, self>
     */
    public static function allModules(): Collection
    {
        return static::all();
    }

    /**
     * Find a specific module by its name.
     *
     * @return static|null
     */
    public static function findModule(string $name): ?self
    {
        /** @var static|null $module */
        $module = static::where('name', $name)->first();

        return $module;
    }

    /**
     * Get the backups associated with this module.
     *
     * @return HasMany<ModuleBackup, $this>
     */
    public function backups(): HasMany
    {
        return $this->hasMany(ModuleBackup::class, 'module_name', 'name');
    }
}
