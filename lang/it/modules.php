<?php

declare(strict_types=1);

return [
    'resource' => [
        'label' => 'Modulo',
        'plural_label' => 'Moduli',
        'navigation_label' => 'Moduli',
        'navigation_group' => 'Impostazioni',
        'navigation' => [
            'group' => 'Impostazioni',
        ],
    ],

    'fields' => [
        'name' => ['label' => 'Nome'],
        'description' => ['label' => 'Descrizione'],
        'version' => ['label' => 'Versione'],
        'status' => [
            'label' => 'Stato',
            'enabled' => 'Abilitato',
            'disabled' => 'Disabilitato',
        ],
        'authors' => ['label' => 'Autori'],
        'assets' => ['label' => 'Risorse'],
        'namespace' => ['label' => 'Namespace'],
        'path' => ['label' => 'Percorso'],
        'providers' => ['label' => 'Provider'],
        'middleware' => ['label' => 'Middleware'],
        'policies' => ['label' => 'Policy'],
        'events' => ['label' => 'Eventi'],
        'source_type' => ['label' => 'Tipo di origine'],
        'file' => ['label' => 'Pacchetto modulo (ZIP)'],
        'url' => ['label' => 'URL di origine'],
        'composer_package' => ['label' => 'Nome pacchetto Composer'],
        'enable_after_install' => ['label' => 'Abilita dopo l\'installazione'],
    ],

    'actions' => [
        'toggle' => [
            'enable' => 'Abilita',
            'disable' => 'Disabilita',
        ],
        'view' => ['label' => 'Ispettore'],
        'install' => ['label' => 'Installa pacchetto'],
        'uninstall' => [
            'label' => 'Disinstalla modulo',
            'confirm_heading' => 'Disinstallare il modulo?',
            'confirm_description' => 'Sei sicuro di voler disinstallare questo modulo? Questa azione non può essere annullata.',
            'confirm_button' => 'Sì, disinstalla',
        ],
        'update' => ['label' => 'Verifica aggiornamenti'],
        'backup' => ['label' => 'Crea backup'],
        'restore' => ['label' => 'Ripristina ultimo'],
    ],

    'bulk_actions' => [
        'enable' => 'Abilita selezionati',
        'enable_confirm' => 'Abilitare i moduli?',
        'enable_description' => 'Sei sicuro di voler abilitare :count moduli?',
        'disable' => 'Disabilita selezionati',
        'disable_confirm' => 'Disabilitare i moduli?',
        'disable_description' => 'Sei sicuro di voler disabilitare :count moduli?',
        'uninstall' => 'Disinstalla selezionati',
        'uninstall_confirm' => 'Disinstallare i moduli?',
        'uninstall_description' => 'Sei sicuro di voler disinstallare :count moduli? Questa azione non può essere annullata.',
        'uninstall_button' => 'Sì, disinstalla tutti',
    ],

    'notifications' => [
        'status_updated' => 'Stato del modulo aggiornato con successo.',
        'installed' => 'Modulo installato con successo.',
        'uninstalled' => 'Modulo disinstallato con successo.',
        'updated' => 'Modulo aggiornato con successo.',
        'backed_up' => 'Backup del modulo creato con successo.',
        'restored' => 'Modulo ripristinato dall\'ultimo backup con successo.',
        'bulk_enabled' => ':count moduli abilitati con successo.',
        'bulk_disabled' => ':count moduli disabilitati con successo.',
        'bulk_uninstalled' => ':count moduli disinstallati con successo.',
    ],

    'options' => [
        'sources' => [
            'zip' => 'Pacchetto ZIP',
            'url' => 'URL / Repository GitHub',
            'composer' => 'Pacchetto Composer',
        ],
        'yes' => 'Sì',
        'no' => 'No',
    ],

    'errors' => [
        'installation_failed' => 'Installazione fallita',
        'unexpected_error' => 'Si è verificato un errore imprevisto.',
        'unsupported_source' => 'L\'origine di installazione ":source" non è supportata.',
        'composer_failed' => 'Installazione Composer fallita: :error',
        'github_failed' => 'Clonazione GitHub fallita: :error',
        'local_failed' => 'Installazione locale fallita: :reason',
        'missing_parameter' => 'Parametro richiesto mancante: :parameter',
        'path_not_found' => 'Il percorso specificato non è stato trovato.',
        'destination_exists' => 'Un modulo con questo nome esiste già nella directory di destinazione.',
        'symlink_failed' => 'Impossibile creare il collegamento simbolico per il modulo locale.',
        'zip_failed' => 'Estrazione ZIP fallita: :error',
        'metadata_not_found' => 'Metadati module.json non trovati nel pacchetto.',
        'invalid_metadata' => 'module.json non valido o illeggibile in :path.',
        'unknown_author' => 'Autore sconosciuto',
        'no_description' => 'Nessuna descrizione disponibile',
        'not_disableable' => 'Il modulo ":name" non può essere disabilitato.',
        'not_removeable' => 'Il modulo ":name" non può essere rimosso.',
        'bulk_uninstall_errors' => 'Alcuni moduli non possono essere disinstallati',
    ],

    'sections' => [
        'identity' => ['label' => 'Identità e versioning'],
        'architecture' => ['label' => 'Architettura e registrazione'],
        'discovery' => ['label' => 'Scoperta e hook'],
    ],

    'widgets' => [
        'stats' => [
            'total' => [
                'label' => 'Moduli totali',
                'description' => 'Tutti i moduli scoperti',
            ],
            'enabled' => [
                'label' => 'Abilitati',
                'description' => 'Attualmente attivi | :count attivi',
            ],
            'disabled' => [
                'label' => 'Disabilitati',
                'description' => 'Moduli inattivi | :count inattivi',
            ],
            'total_modules' => 'Moduli totali',
            'total_description' => 'Tutti i moduli scoperti',
            'enabled_modules' => 'Moduli abilitati',
            'enabled_description' => ':count disabilitati',
            'module_health' => 'Salute dei moduli',
            'health_description' => 'Percentuale di moduli abilitati',
        ],
        'distribution' => [
            'label' => 'Moduli totali',
            'enabled' => 'Abilitati',
            'disabled' => 'Disabilitati',
        ],
        'recent' => ['heading' => 'Moduli recenti'],
    ],

    'filters' => [
        'status' => [
            'label' => 'Stato',
            'enabled' => 'Abilitato',
            'disabled' => 'Disabilitato',
            'all' => 'Tutti gli stati',
        ],
        'has_views' => 'Ha viste',
        'has_migrations' => 'Ha migrazioni',
        'has_translations' => 'Ha traduzioni',
    ],

    'flags' => [
        'removeable' => 'Rimovibile',
        'disableable' => 'Disabilitabile',
    ],

    'backups' => [
        'fields' => [
            'filename' => 'Nome file',
            'size' => 'Dimensione',
            'date' => 'Data di creazione',
        ],
        'actions' => [
            'restore' => [
                'label' => 'Ripristina',
                'confirm_heading' => 'Ripristinare il backup?',
                'confirm_description' => 'Sei sicuro di voler ripristinare questo backup? I file del modulo corrente verranno sostituiti.',
                'confirm_button' => 'Sì, ripristina',
            ],
            'delete' => [
                'label' => 'Elimina',
                'confirm_heading' => 'Eliminare il backup?',
                'confirm_description' => 'Sei sicuro di voler eliminare questo backup? Questa azione non può essere annullata.',
                'confirm_button' => 'Sì, elimina',
            ],
            'delete_bulk' => [
                'label' => 'Elimina selezionati',
                'confirm_heading' => 'Eliminare i backup?',
                'confirm_description' => 'Sei sicuro di voler eliminare i backup selezionati? Questa azione non può essere annullata.',
                'confirm_button' => 'Sì, elimina tutti',
            ],
        ],
        'notifications' => [
            'deleted' => 'Backup eliminato con successo.',
            'bulk_deleted' => 'Backup selezionati eliminati con successo.',
        ],
        'empty' => [
            'heading' => 'Nessun backup',
            'description' => 'Non sono ancora stati creati backup per questo modulo.',
        ],
    ],
];
