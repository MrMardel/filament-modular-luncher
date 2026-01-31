<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Filament\Resources\ModuleResource\Pages;

use AlizHarb\ModularLuncher\Filament\Resources\ModuleResource;
use AlizHarb\ModularLuncher\Models\Module;
use Filament\Resources\Pages\ViewRecord;

/**
 * Page class for viewing a single module's details.
 *
 * Overrides the standard record resolution to work with the virtual
 * Sushi-based Module model.
 */
class ViewModule extends ViewRecord
{
    /** @var string The resource associated with the page */
    protected static string $resource = ModuleResource::class;

    /**
     * Resolve the module record from the virtual in-memory database.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function resolveRecord(int|string $key): Module
    {
        $module = Module::findModule((string) $key);

        if ($module === null) {
            abort(404);
        }

        return $module;
    }
}
