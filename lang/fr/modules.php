<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Module Resource Translations
    |--------------------------------------------------------------------------
    |
    | The following language lines are used throughout the Filament Modular
    | Luncher package for labels, notifications, errors, and UI elements.
    |
    */

    'resource' => [
        'label' => 'Module',
        'plural_label' => 'Modules',
        'navigation_label' => 'Modules',
        'navigation_group' => 'Paramètres',
        'navigation' => [
            'group' => 'Paramètres',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Field Labels
    |--------------------------------------------------------------------------
    */

    'fields' => [
        'name' => [
            'label' => 'Nom',
        ],
        'description' => [
            'label' => 'Description',
        ],
        'version' => [
            'label' => 'Version',
        ],
        'status' => [
            'label' => 'Statut',
            'enabled' => 'Activé',
            'disabled' => 'Désactivé',
        ],
        'authors' => [
            'label' => 'Auteurs',
        ],
        'assets' => [
            'label' => 'Ressources',
        ],
        'namespace' => [
            'label' => 'Nomspace',
        ],
        'path' => [
            'label' => 'Chemin',
        ],
        'providers' => [
            'label' => 'Fournisseurs',
        ],
        'middleware' => [
            'label' => 'Middleware',
        ],
        'policies' => [
            'label' => 'Politiques',
        ],
        'events' => [
            'label' => 'Événements',
        ],
        'source_type' => [
            'label' => 'Type de source',
        ],
        'file' => [
            'label' => 'Package de module (ZIP)',
        ],
        'url' => [
            'label' => 'URL source',
        ],
        'composer_package' => [
            'label' => 'Nom du package Composer',
        ],
        'enable_after_install' => [
            'label' => 'Activer après l'installation',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Actions
    |--------------------------------------------------------------------------
    */

    'actions' => [
        'toggle' => [
            'enable' => 'Activer',
            'disable' => 'Désactiver',
        ],
        'view' => [
            'label' => 'Inspecteur',
        ],
        'install' => [
            'label' => 'Installer le package',
        ],
        'uninstall' => [
            'label' => 'Désinstaller le module',
            'confirm_heading' => 'Désinstaller le module?',
            'confirm_description' => 'Are you sure you want to uninstall this module? This action cannot be undone.',
            'confirm_button' => 'Yes, Uninstall',
        ],
        'update' => [
            'label' => 'Vérifier les mises à jour',
        ],
        'backup' => [
            'label' => 'Créer une sauvegarde',
        ],
        'restore' => [
            'label' => 'Restaurer la dernière',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bulk Actions
    |--------------------------------------------------------------------------
    */

    'bulk_actions' => [
        'enable' => 'Activer Selected',
        'enable_confirm' => 'Activer Modules?',
        'enable_description' => 'Are you sure you want to enable :count module(s)?',
        'disable' => 'Désactiver Selected',
        'disable_confirm' => 'Désactiver Modules?',
        'disable_description' => 'Are you sure you want to disable :count module(s)?',
        'uninstall' => 'Uninstall Selected',
        'uninstall_confirm' => 'Désinstaller le modules?',
        'uninstall_description' => 'Are you sure you want to uninstall :count module(s)? This action cannot be undone.',
        'uninstall_button' => 'Yes, Uninstall All',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        'status_updated' => 'Module status updated successfully.',
        'installed' => 'Module(s) installed successfully.',
        'uninstalled' => 'Module uninstalled successfully.',
        'updated' => 'Module updated successfully.',
        'backed_up' => 'Module backup created successfully.',
        'restored' => 'Module restored from latest backup successfully.',
        'bulk_enabled' => ':count module(s) enabled successfully.',
        'bulk_disabled' => ':count module(s) disabled successfully.',
        'bulk_uninstalled' => ':count module(s) uninstalled successfully.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    */

    'options' => [
        'sources' => [
            'zip' => 'ZIP Package',
            'url' => 'URL / GitHub Repository',
            'composer' => 'Composer Package',
        ],
        'yes' => 'Yes',
        'no' => 'No',
    ],

    /*
    |--------------------------------------------------------------------------
    | Errors
    |--------------------------------------------------------------------------
    */

    'errors' => [
        'installation_failed' => 'Installation Failed',
        'unexpected_error' => 'An unexpected error occurred.',
        'unsupported_source' => 'The installation source ":source" is not supported.',
        'composer_failed' => 'Composer installation failed: :error',
        'github_failed' => 'GitHub clone failed: :error',
        'local_failed' => 'Local installation failed: :reason',
        'missing_parameter' => 'Missing required parameter: :parameter',
        'path_not_found' => 'The specified path was not found.',
        'destination_exists' => 'A module with this name already exists in the target directory.',
        'symlink_failed' => 'Failed to create symbolic link for the local module.',
        'zip_failed' => 'ZIP extraction failed: :error',
        'metadata_not_found' => 'No module.json metadata found in the package.',
        'invalid_metadata' => 'Invalid or unreadable module.json at :path.',
        'unknown_author' => 'Unknown Author',
        'no_description' => 'No description available',
        'not_disableable' => 'Module ":name" cannot be disabled.',
        'not_removeable' => 'Module ":name" cannot be removed.',
        'bulk_uninstall_errors' => 'Some modules could not be uninstalled',
    ],

    /*
    |--------------------------------------------------------------------------
    | Sections
    |--------------------------------------------------------------------------
    */

    'sections' => [
        'identity' => [
            'label' => 'Identity & Versioning',
        ],
        'architecture' => [
            'label' => 'Architecture & Registration',
        ],
        'discovery' => [
            'label' => 'Discovery & Hooks',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets
    |--------------------------------------------------------------------------
    */

    'widgets' => [
        'stats' => [
            'total' => [
                'label' => 'Total Modules',
                'description' => 'All discovered modules',
            ],
            'enabled' => [
                'label' => 'Activé',
                'description' => 'Currently active | :count Active',
            ],
            'disabled' => [
                'label' => 'Désactivé',
                'description' => 'Inactive modules | :count Inactive',
            ],
            'total_modules' => 'Total Modules',
            'total_description' => 'All discovered modules',
            'enabled_modules' => 'Activé Modules',
            'enabled_description' => ':count disabled',
            'module_health' => 'Module Health',
            'health_description' => 'Percentage of enabled modules',
        ],
        'distribution' => [
            'label' => 'Total Modules',
            'enabled' => 'Activé',
            'disabled' => 'Désactivé',
        ],
        'recent' => [
            'heading' => 'Recent Modules',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    'filters' => [
        'status' => [
            'label' => 'Statut',
            'enabled' => 'Activé',
            'disabled' => 'Désactivé',
            'all' => 'All Statuses',
        ],
        'has_views' => 'Has Views',
        'has_migrations' => 'Has Migrations',
        'has_translations' => 'Has Translations',
    ],

    /*
    |--------------------------------------------------------------------------
    | Module Flags
    |--------------------------------------------------------------------------
    */

    'flags' => [
        'removeable' => 'Removeable',
        'disableable' => 'Désactiverable',
    ],

    /*
    |--------------------------------------------------------------------------
    | Backups
    |--------------------------------------------------------------------------
    */

    'backups' => [
        'fields' => [
            'filename' => 'Filename',
            'size' => 'Size',
            'date' => 'Created At',
        ],
        'actions' => [
            'restore' => [
                'label' => 'Restore',
                'confirm_heading' => 'Restore Backup?',
                'confirm_description' => 'Are you sure you want to restore this backup? Current module files will be replaced.',
                'confirm_button' => 'Yes, Restore',
            ],
            'delete' => [
                'label' => 'Delete',
                'confirm_heading' => 'Delete Backup?',
                'confirm_description' => 'Are you sure you want to delete this backup? This action cannot be undone.',
                'confirm_button' => 'Yes, Delete',
            ],
            'delete_bulk' => [
                'label' => 'Delete Selected',
                'confirm_heading' => 'Delete Backups?',
                'confirm_description' => 'Are you sure you want to delete the selected backups? This action cannot be undone.',
                'confirm_button' => 'Yes, Delete All',
            ],
        ],
        'notifications' => [
            'deleted' => 'Backup deleted successfully.',
            'bulk_deleted' => 'Selected backups deleted successfully.',
        ],
        'empty' => [
            'heading' => 'No Backups',
            'description' => 'No backups have been created for this module yet.',
        ],
    ],
];
