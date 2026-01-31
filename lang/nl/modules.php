<?php

declare(strict_types=1);

return [
    'resource' => [
        'label' => 'Module',
        'plural_label' => 'Modules',
        'navigation_label' => 'Modules',
        'navigation_group' => 'Instellingen',
        'navigation' => [
            'group' => 'Instellingen',
        ],
    ],

    'fields' => [
        'name' => ['label' => 'Naam'],
        'description' => ['label' => 'Beschrijving'],
        'version' => ['label' => 'Versie'],
        'status' => [
            'label' => 'Status',
            'enabled' => 'Ingeschakeld',
            'disabled' => 'Uitgeschakeld',
        ],
        'authors' => ['label' => 'Auteurs'],
        'assets' => ['label' => 'Middelen'],
        'namespace' => ['label' => 'Naamruimte'],
        'path' => ['label' => 'Pad'],
        'providers' => ['label' => 'Providers'],
        'middleware' => ['label' => 'Middleware'],
        'policies' => ['label' => 'Beleid'],
        'events' => ['label' => 'Gebeurtenissen'],
        'source_type' => ['label' => 'Brontype'],
        'file' => ['label' => 'Modulepakket (ZIP)'],
        'url' => ['label' => 'Bron-URL'],
        'composer_package' => ['label' => 'Composer pakketnaam'],
        'enable_after_install' => ['label' => 'Inschakelen na installatie'],
    ],

    'actions' => [
        'toggle' => [
            'enable' => 'Inschakelen',
            'disable' => 'Uitschakelen',
        ],
        'view' => ['label' => 'Inspecteur'],
        'install' => ['label' => 'Pakket installeren'],
        'uninstall' => [
            'label' => 'Module verwijderen',
            'confirm_heading' => 'Module verwijderen?',
            'confirm_description' => 'Weet u zeker dat u deze module wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.',
            'confirm_button' => 'Ja, verwijderen',
        ],
        'update' => ['label' => 'Controleer updates'],
        'backup' => ['label' => 'Back-up maken'],
        'restore' => ['label' => 'Laatste herstellen'],
    ],

    'bulk_actions' => [
        'enable' => 'Geselecteerde inschakelen',
        'enable_confirm' => 'Modules inschakelen?',
        'enable_description' => 'Weet u zeker dat u :count module(s) wilt inschakelen?',
        'disable' => 'Geselecteerde uitschakelen',
        'disable_confirm' => 'Modules uitschakelen?',
        'disable_description' => 'Weet u zeker dat u :count module(s) wilt uitschakelen?',
        'uninstall' => 'Geselecteerde verwijderen',
        'uninstall_confirm' => 'Modules verwijderen?',
        'uninstall_description' => 'Weet u zeker dat u :count module(s) wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.',
        'uninstall_button' => 'Ja, alles verwijderen',
    ],

    'notifications' => [
        'status_updated' => 'Modulestatus succesvol bijgewerkt.',
        'installed' => 'Module(s) succesvol geïnstalleerd.',
        'uninstalled' => 'Module succesvol verwijderd.',
        'updated' => 'Module succesvol bijgewerkt.',
        'backed_up' => 'Module back-up succesvol aangemaakt.',
        'restored' => 'Module succesvol hersteld vanaf laatste back-up.',
        'bulk_enabled' => ':count module(s) succesvol ingeschakeld.',
        'bulk_disabled' => ':count module(s) succesvol uitgeschakeld.',
        'bulk_uninstalled' => ':count module(s) succesvol verwijderd.',
    ],

    'options' => [
        'sources' => [
            'zip' => 'ZIP-pakket',
            'url' => 'URL / GitHub Repository',
            'composer' => 'Composer-pakket',
        ],
        'yes' => 'Ja',
        'no' => 'Nee',
    ],

    'errors' => [
        'installation_failed' => 'Installatie mislukt',
        'unexpected_error' => 'Er is een onverwachte fout opgetreden.',
        'unsupported_source' => 'De installatiebron ":source" wordt niet ondersteund.',
        'composer_failed' => 'Composer-installatie mislukt: :error',
        'github_failed' => 'GitHub-kloon mislukt: :error',
        'local_failed' => 'Lokale installatie mislukt: :reason',
        'missing_parameter' => 'Vereiste parameter ontbreekt: :parameter',
        'path_not_found' => 'Het opgegeven pad is niet gevonden.',
        'destination_exists' => 'Er bestaat al een module met deze naam in de doelmap.',
        'symlink_failed' => 'Kan geen symbolische koppeling maken voor de lokale module.',
        'zip_failed' => 'ZIP-extractie mislukt: :error',
        'metadata_not_found' => 'Geen module.json metadata gevonden in het pakket.',
        'invalid_metadata' => 'Ongeldige of onleesbare module.json op :path.',
        'unknown_author' => 'Onbekende auteur',
        'no_description' => 'Geen beschrijving beschikbaar',
        'not_disableable' => 'Module ":name" kan niet worden uitgeschakeld.',
        'not_removeable' => 'Module ":name" kan niet worden verwijderd.',
        'bulk_uninstall_errors' => 'Sommige modules konden niet worden verwijderd',
    ],

    'sections' => [
        'identity' => ['label' => 'Identiteit en versiebeheer'],
        'architecture' => ['label' => 'Architectuur en registratie'],
        'discovery' => ['label' => 'Ontdekking en hooks'],
    ],

    'widgets' => [
        'stats' => [
            'total' => [
                'label' => 'Totaal modules',
                'description' => 'Alle ontdekte modules',
            ],
            'enabled' => [
                'label' => 'Ingeschakeld',
                'description' => 'Momenteel actief | :count actief',
            ],
            'disabled' => [
                'label' => 'Uitgeschakeld',
                'description' => 'Inactieve modules | :count inactief',
            ],
            'total_modules' => 'Totaal modules',
            'total_description' => 'Alle ontdekte modules',
            'enabled_modules' => 'Ingeschakelde modules',
            'enabled_description' => ':count uitgeschakeld',
            'module_health' => 'Module gezondheid',
            'health_description' => 'Percentage ingeschakelde modules',
        ],
        'distribution' => [
            'label' => 'Totaal modules',
            'enabled' => 'Ingeschakeld',
            'disabled' => 'Uitgeschakeld',
        ],
        'recent' => ['heading' => 'Recente modules'],
    ],

    'filters' => [
        'status' => [
            'label' => 'Status',
            'enabled' => 'Ingeschakeld',
            'disabled' => 'Uitgeschakeld',
            'all' => 'Alle statussen',
        ],
        'has_views' => 'Heeft weergaven',
        'has_migrations' => 'Heeft migraties',
        'has_translations' => 'Heeft vertalingen',
    ],

    'flags' => [
        'removeable' => 'Verwijderbaar',
        'disableable' => 'Uitschakelbaar',
    ],

    'backups' => [
        'fields' => [
            'filename' => 'Bestandsnaam',
            'size' => 'Grootte',
            'date' => 'Aangemaakt op',
        ],
        'actions' => [
            'restore' => [
                'label' => 'Herstellen',
                'confirm_heading' => 'Back-up herstellen?',
                'confirm_description' => 'Weet u zeker dat u deze back-up wilt herstellen? Huidige modulebestanden worden vervangen.',
                'confirm_button' => 'Ja, herstellen',
            ],
            'delete' => [
                'label' => 'Verwijderen',
                'confirm_heading' => 'Back-up verwijderen?',
                'confirm_description' => 'Weet u zeker dat u deze back-up wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.',
                'confirm_button' => 'Ja, verwijderen',
            ],
            'delete_bulk' => [
                'label' => 'Geselecteerde verwijderen',
                'confirm_heading' => 'Back-ups verwijderen?',
                'confirm_description' => 'Weet u zeker dat u de geselecteerde back-ups wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.',
                'confirm_button' => 'Ja, alles verwijderen',
            ],
        ],
        'notifications' => [
            'deleted' => 'Back-up succesvol verwijderd.',
            'bulk_deleted' => 'Geselecteerde back-ups succesvol verwijderd.',
        ],
        'empty' => [
            'heading' => 'Geen back-ups',
            'description' => 'Er zijn nog geen back-ups aangemaakt voor deze module.',
        ],
    ],
];
