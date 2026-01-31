<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Models;

use AlizHarb\Modular\Facades\Modular;
use AlizHarb\ModularLuncher\Services\ModuleService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sushi\Sushi;

/**
 * Eloquent model representing a module backup.
 *
 * Utilizes Sushi to provide an Eloquent interface over the backup ZIP files
 * stored on disk, allowing for filtering and sorting within Filament.
 *
 * @property string $filename
 * @property string $module_name
 * @property int $size
 * @property string $created_at
 */
final class ModuleBackup extends Model
{
    use Sushi;

    /** @var string The primary key for the model */
    protected $primaryKey = 'filename';

    /** @var string The "type" of the primary key */
    protected $keyType = 'string';

    /** @var bool Indicates if the IDs are auto-incrementing */
    public $incrementing = false;

    /**
     * Populate the Sushi in-memory database rows from the backup files.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        /** @var ModuleService $service */
        $service = app(ModuleService::class);
        $modules = array_keys(Modular::getModules());
        $rows = [];

        foreach ($modules as $moduleName) {
            $backups = $service->getBackups($moduleName);

            foreach ($backups as $backup) {
                $rows[] = [
                    'filename' => $backup['filename'],
                    'module_name' => $moduleName,
                    'size' => $backup['size'],
                    'created_at' => date('Y-m-d H:i:s', $backup['created_at']),
                ];
            }
        }

        return $rows;
    }

    /** @var array<string, string> Define the column schema for Sushi */
    protected $schema = [
        'filename' => 'string',
        'module_name' => 'string',
        'size' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Get the module that this backup belongs to.
     *
     * @return BelongsTo<Module, $this>
     */
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_name', 'name');
    }
}
