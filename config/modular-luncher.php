<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authorization Configuration
    |--------------------------------------------------------------------------
    |
    | Configure how module permissions are handled throughout the package.
    | You can disable authorization entirely, set default behavior, or
    | configure specific permissions for each action.
    |
    */

    'authorization' => [
        /*
         * Enable or disable authorization globally.
         * When disabled, all users can perform all actions.
         */
        'enabled' => env('MODULAR_LUNCHER_AUTH_ENABLED', false),

        /*
         * Default behavior when no explicit permission is found.
         * true = deny by default, false = allow by default
         */
        'default_deny' => env('MODULAR_LUNCHER_DEFAULT_DENY', true),

        /*
         * Specific permissions for each action.
         * Set to true to allow, false to deny, or null to use Gates/User abilities.
         *
         * Available actions:
         * - viewAny: View module list
         * - view: View specific module details
         * - create: Install new modules
         * - update: Update existing modules
         * - delete: Uninstall modules
         * - toggle: Enable/disable modules
         * - backup: Create module backups
         * - restore: Restore modules from backup
         * - bulkAction: Perform bulk operations
         *
         * Use '*' to allow/deny all actions.
         */
        'permissions' => [
            // '*' => true, // Uncomment to allow all actions
            'viewAny' => null,
            'view' => null,
            'create' => null,
            'update' => null,
            'delete' => null,
            'toggle' => null,
            'backup' => null,
            'restore' => null,
            'bulkAction' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resource Settings
    |--------------------------------------------------------------------------
    |
    | Configure the Filament resource settings for the Module Manager.
    |
    */
    'resource' => [
        'label' => 'modular-luncher::modules.resource.label',
        'navigation_group' => 'modular-luncher::modules.navigation.group',
        'navigation_label' => 'modular-luncher::modules.navigation.label',
        'plural_label' => 'modular-luncher::modules.resource.plural_label',
        'navigation_icon' => 'heroicon-o-cube',
        'navigation_sort' => 100,
        'should_register_navigation' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Discovery Features
    |--------------------------------------------------------------------------
    |
    | Enable or disable specific discovery features in the Module Inspector.
    |
    */
    'discovery' => [
        'policies' => true,
        'events' => true,
        'middleware' => true,
        'providers' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Installation Settings
    |--------------------------------------------------------------------------
    |
    | Configure how modules are installed. You can enable/disable specifically
    | for production or restrict sources.
    |
    */
    'installation' => [
        'enabled' => env('MODULAR_LUNCHER_INSTALL_ENABLED', true),

        /**
         * Maximum upload size for ZIP files (in MB).
         */
        'max_upload_size' => env('MODULAR_LUNCHER_MAX_UPLOAD_SIZE', 50),

        'disk' => 'local',
        'temp_path' => 'temp_modules',
        'allowed_sources' => ['zip', 'url', 'composer'],
        'git_binary' => env('GIT_BINARY_PATH', 'git'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Update & Repository Settings
    |--------------------------------------------------------------------------
    |
    | Configure auto-updates and private repository support.
    |
    */
    'updates' => [
        'enabled' => env('MODULAR_LUNCHER_UPDATES_ENABLED', true),
        'auto_check' => true,

        // GitHub Personal Access Token for private repositories
        'github_token' => env('GITHUB_MODULES_TOKEN'),

        // Default branch to pull from if not specified
        'default_branch' => 'main',

        // Force update using git pull -f
        'force' => env('MODULAR_LUNCHER_UPDATES_FORCE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Backup Settings
    |--------------------------------------------------------------------------
    |
    | Configure automatic backup functionality with retention policies.
    |
    */
    'backups' => [
        /**
         * Enable automatic backups.
         */
        'enabled' => env('MODULAR_LUNCHER_BACKUPS_ENABLED', true),

        /**
         * Automatically backup before updates.
         */
        'backup_before_update' => env('MODULAR_LUNCHER_BACKUP_BEFORE_UPDATE', true),

        /**
         * Automatically backup before uninstall.
         */
        'backup_before_uninstall' => env('MODULAR_LUNCHER_BACKUP_BEFORE_UNINSTALL', true),

        /**
         * Number of days to retain backups (0 = keep forever).
         */
        'retention_days' => env('MODULAR_LUNCHER_BACKUP_RETENTION_DAYS', 30),

        /**
         * Storage path for backups (relative to storage/app/).
         */
        'storage_path' => env('MODULAR_LUNCHER_BACKUP_PATH', 'module-backups'),

        /**
         * Maximum number of backups to keep per module (0 = unlimited).
         */
        'max_backups_per_module' => env('MODULAR_LUNCHER_MAX_BACKUPS_PER_MODULE', 10),

        /**
         * Backup Relation Manager configuration.
         */
        'relation_manager' => [
            'enabled' => true,
            'icon' => 'heroicon-o-archive-box',
            'title' => 'modular-luncher::modules.backups.title',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets Configuration
    |--------------------------------------------------------------------------
    |
    | Configure module dashboard widgets.
    |
    */
    'widgets' => [
        'enabled' => env('MODULAR_LUNCHER_WIDGETS_ENABLED', true),
        'polling_interval' => env('MODULAR_LUNCHER_WIDGET_POLLING', 30),
        'display' => [
            'stats' => true,
            'recent' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Filtering
    |--------------------------------------------------------------------------
    |
    | Modules that should be excluded from the manager.
    |
    */
    'exclude' => [
        // 'Auth',
    ],
];
