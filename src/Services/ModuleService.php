<?php

declare(strict_types=1);

namespace AlizHarb\ModularLuncher\Services;

use AlizHarb\Modular\Facades\Modular;
use AlizHarb\ModularLuncher\Data\InstallModuleData;
use AlizHarb\ModularLuncher\Exceptions\ModuleInstallationException;
use AlizHarb\ModularLuncher\Exceptions\ModuleOperationException;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Finder\Finder;
use ZipArchive;

/**
 * Service responsible for module lifecycle management.
 *
 * Handles installation, updates, backups, and uninstallation of modules
 * adhering to strict PHP 8.3+ and Laravel 12 standards.
 */
class ModuleService
{
    /** @var string Prefix for temporary installation directories */
    private const string TEMP_PREFIX = 'module_install_';

    /**
     * Install a module from the provided data source.
     *
     * @throws ModuleInstallationException
     */
    public function install(InstallModuleData $data): void
    {
        $tempDir = storage_path('app/private/'.self::TEMP_PREFIX.uniqid());
        File::makeDirectory($tempDir, 0755, true);

        try {
            match ($data->sourceType) {
                'zip' => $this->installViaZip($data->filePath, $tempDir, $data->enableAfterInstall),
                'url' => $this->installViaUrl($data->url, $tempDir, $data->enableAfterInstall),
                'composer' => $this->installViaComposer($data->composerPackage, $data->enableAfterInstall),
                default => throw ModuleInstallationException::sourceNotSupported($data->sourceType),
            };
        } finally {
            if (File::exists($tempDir)) {
                File::deleteDirectory($tempDir);
            }
        }
    }

    /**
     * Install a module from a local ZIP file.
     *
     * @throws ModuleInstallationException
     */
    private function installViaZip(string $zipPath, string $tempDir, bool $enableAfterInstall): void
    {
        if (! File::exists($zipPath)) {
            throw ModuleInstallationException::missingParameter('filePath');
        }

        $this->extractAndProcess($zipPath, $tempDir, $enableAfterInstall);
    }

    /**
     * Install a module from a URL (ZIP or GitHub Repo).
     *
     * @throws ModuleInstallationException
     */
    private function installViaUrl(string $url, string $tempDir, bool $enableAfterInstall): void
    {
        if (str_ends_with($url, '.zip')) {
            $zipPath = $tempDir.DIRECTORY_SEPARATOR.'package.zip';

            try {
                File::put($zipPath, file_get_contents($url));
            } catch (Exception $e) {
                throw ModuleInstallationException::githubFailed($e->getMessage());
            }

            $this->extractAndProcess($zipPath, $tempDir, $enableAfterInstall);

            return;
        }

        $cloneUrl = $this->prepareGithubUrl($url);
        $cloneDir = $tempDir.DIRECTORY_SEPARATOR.'repo';
        $gitPath = (string) config('modular-luncher.installation.git_binary', 'git');

        $result = Process::timeout(300)->run("{$gitPath} clone --depth 1 {$cloneUrl} {$cloneDir}");

        if ($result->failed()) {
            throw ModuleInstallationException::githubFailed($result->errorOutput());
        }

        $this->scanAndInstall($cloneDir, $enableAfterInstall);
    }

    /**
     * Install a module via Composer.
     *
     * @throws ModuleInstallationException
     */
    private function installViaComposer(string $package, bool $enableAfterInstall): void
    {
        $result = Process::timeout(600)->run("composer require {$package}");

        if ($result->failed()) {
            throw ModuleInstallationException::composerFailed($result->errorOutput());
        }

        Modular::clearCache();
    }

    /**
     * Prepare a GitHub URL for cloning by injecting authentication token if available.
     */
    private function prepareGithubUrl(string $url): string
    {
        if (! str_contains($url, 'github.com')) {
            return $url;
        }

        $token = (string) config('modular-luncher.updates.github_token', '');
        if ($token === '') {
            return $url;
        }

        return str_replace('https://', "https://{$token}@", $url);
    }

    /**
     * Extract a ZIP file and initiate module processing.
     *
     * @throws ModuleInstallationException
     */
    protected function extractAndProcess(string $zipPath, string $tempDir, bool $enableAfterInstall): void
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($tempDir);
            $zip->close();
        } else {
            throw ModuleInstallationException::zipExtractionFailed('Could not open ZIP file.');
        }

        $this->scanAndInstall($tempDir, $enableAfterInstall);
    }

    /**
     * Scan a directory for valid module.json files and install the modules found.
     *
     * @throws ModuleInstallationException
     */
    private function scanAndInstall(string $directory, bool $enableAfterInstall): void
    {
        $finder = new Finder;
        $finder->files()->in($directory)->name('module.json');

        if (! $finder->hasResults()) {
            throw ModuleInstallationException::metadataNotFound();
        }

        foreach ($finder as $file) {
            $metadataPath = $file->getRealPath();
            $moduleDir = dirname($metadataPath);

            $metadata = json_decode((string) File::get($metadataPath), true);
            if (! is_array($metadata) || ! isset($metadata['name'])) {
                continue;
            }

            $moduleName = (string) $metadata['name'];
            $modulesPath = (string) config('modular.paths.modules', base_path('modules'));
            $targetPath = $modulesPath.DIRECTORY_SEPARATOR.$moduleName;

            if (File::exists($targetPath)) {
                continue;
            }

            File::copyDirectory($moduleDir, $targetPath);

            if ($enableAfterInstall) {
                Modular::getActivator()->setStatus($moduleName, true);
            }
        }

        Modular::clearCache();
    }

    /**
     * Update a module from its original source.
     *
     * @throws ModuleOperationException
     */
    public function update(string $name): void
    {
        if (! (bool) config('modular-luncher.updates.enabled', true)) {
            return;
        }

        /** @var mixed $moduleData */
        $moduleData = Modular::getModule($name);
        $module = (array) $moduleData;

        if ($module === []) {
            throw ModuleOperationException::notFound($name);
        }

        $modulePath = (string) ($module['path'] ?? '');

        if (File::exists($modulePath.DIRECTORY_SEPARATOR.'.git')) {
            $this->updateViaGit($modulePath);
        }

        Modular::clearCache();
    }

    /**
     * Update a module via Git pull.
     *
     * @throws ModuleInstallationException
     */
    private function updateViaGit(string $modulePath): void
    {
        $gitPath = (string) config('modular-luncher.installation.git_binary', 'git');
        $branch = (string) config('modular-luncher.updates.default_branch', 'main');
        $force = (bool) config('modular-luncher.updates.force', false) ? '-f' : '';

        $urlResult = Process::path($modulePath)->run("{$gitPath} remote get-url origin");
        if ($urlResult->successful()) {
            $currentUrl = trim($urlResult->output());
            $newUrl = $this->prepareGithubUrl($currentUrl);
            if ($newUrl !== $currentUrl) {
                Process::path($modulePath)->run("{$gitPath} remote set-url origin {$newUrl}");
            }
        }

        $result = Process::timeout(300)
            ->path($modulePath)
            ->run("{$gitPath} pull origin {$branch} {$force}");

        if ($result->failed()) {
            throw ModuleInstallationException::githubFailed($result->errorOutput());
        }
    }

    /**
     * Create a backup of the specified module.
     *
     * @throws ModuleOperationException
     */
    public function backup(string $name): void
    {
        if (! (bool) config('modular-luncher.backups.enabled', true)) {
            return;
        }

        /** @var mixed $moduleData */
        $moduleData = Modular::getModule($name);
        $module = (array) $moduleData;

        if ($module === []) {
            throw ModuleOperationException::notFound($name);
        }

        $modulePath = (string) ($module['path'] ?? '');
        $backupDisk = (string) config('modular-luncher.backups.disk', 'local');
        $backupDir = (string) config('modular-luncher.backups.storage_path', 'module-backups');
        $fileName = "{$name}_".date('Y-m-d_His').'.zip';

        $disk = Storage::disk($backupDisk);
        if (! $disk->exists($backupDir)) {
            $disk->makeDirectory($backupDir);
        }

        $fullBackupPath = $disk->path($backupDir.DIRECTORY_SEPARATOR.$fileName);

        $zip = new ZipArchive;
        if ($zip->open($fullBackupPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw ModuleOperationException::backupFailed($name, 'Could not create backup ZIP.');
        }

        if (File::isDirectory($modulePath)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($modulePath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                /** @var SplFileInfo $file */
                if (! $file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($modulePath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }

        $zip->close();
    }

    /**
     * Retrieve all available backups for a module.
     *
     * @return array<int, array{filename: string, size: int, created_at: int}>
     */
    public function getBackups(string $name): array
    {
        $backupDisk = (string) config('modular-luncher.backups.disk', 'local');
        $backupDir = (string) config('modular-luncher.backups.storage_path', 'module-backups');
        $disk = Storage::disk($backupDisk);

        if (! $disk->exists($backupDir)) {
            return [];
        }

        $files = (array) File::glob($disk->path($backupDir).DIRECTORY_SEPARATOR."{$name}_*.zip");

        if ($files === []) {
            return [];
        }

        return collect($files)->map(function ($path) {
            return [
                'filename' => basename($path),
                'size' => File::size($path),
                'created_at' => File::lastModified($path),
            ];
        })->sortByDesc('created_at')->values()->toArray();
    }

    /**
     * Restore a module from a specific backup file or the latest one.
     *
     * @throws ModuleOperationException
     * @throws ModuleInstallationException
     */
    public function restore(string $name, ?string $filename = null): void
    {
        $backupDisk = (string) config('modular-luncher.backups.disk', 'local');
        $backupDir = (string) config('modular-luncher.backups.storage_path', 'module-backups');
        $disk = Storage::disk($backupDisk);

        if ($filename !== null) {
            $relativeBackupPath = $backupDir.DIRECTORY_SEPARATOR.$filename;
            if (! $disk->exists($relativeBackupPath)) {
                throw ModuleOperationException::restoreFailed($name, "Backup file {$filename} not found.");
            }
            $backupPath = $disk->path($relativeBackupPath);
        } else {
            $files = (array) File::glob($disk->path($backupDir).DIRECTORY_SEPARATOR."{$name}_*.zip");

            if ($files === []) {
                throw ModuleOperationException::restoreFailed($name, 'No backups found.');
            }

            usort($files, fn ($a, $b) => filemtime($b) - filemtime($a));
            $backupPath = $files[0];
        }

        $modulesPath = (string) config('modular.paths.modules', base_path('modules'));
        $targetPath = $modulesPath.DIRECTORY_SEPARATOR.$name;

        if (File::exists($targetPath)) {
            File::deleteDirectory($targetPath);
        }

        $this->extractAndProcess($backupPath, $modulesPath, false);
    }

    /**
     * Uninstall a module by removing its files and clearing its registration.
     *
     * @throws ModuleOperationException
     */
    public function uninstall(string $name): void
    {
        /** @var mixed $moduleData */
        $moduleData = Modular::getModule($name);
        $module = (array) $moduleData;

        if ($module === []) {
            throw ModuleOperationException::notFound($name);
        }

        if (isset($module['removeable']) && $module['removeable'] === false) {
            throw ModuleOperationException::notRemoveable($name);
        }

        File::deleteDirectory((string) ($module['path'] ?? ''));
        Modular::getActivator()->delete($name);
        Modular::clearCache();
    }
}
