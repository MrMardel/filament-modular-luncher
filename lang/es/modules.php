<?php

declare(strict_types=1);

return [
    'resource' => [
        'label' => 'Módulo',
        'plural_label' => 'Módulos',
        'navigation_label' => 'Módulos',
        'navigation_group' => 'Configuración',
        'navigation' => [
            'group' => 'Configuración',
        ],
    ],

    'fields' => [
        'name' => ['label' => 'Nombre'],
        'description' => ['label' => 'Descripción'],
        'version' => ['label' => 'Versión'],
        'status' => [
            'label' => 'Estado',
            'enabled' => 'Habilitado',
            'disabled' => 'Deshabilitado',
        ],
        'authors' => ['label' => 'Autores'],
        'assets' => ['label' => 'Recursos'],
        'namespace' => ['label' => 'Espacio de nombres'],
        'path' => ['label' => 'Ruta'],
        'providers' => ['label' => 'Proveedores'],
        'middleware' => ['label' => 'Middleware'],
        'policies' => ['label' => 'Políticas'],
        'events' => ['label' => 'Eventos'],
        'source_type' => ['label' => 'Tipo de fuente'],
        'file' => ['label' => 'Paquete de módulo (ZIP)'],
        'url' => ['label' => 'URL de origen'],
        'composer_package' => ['label' => 'Nombre del paquete Composer'],
        'enable_after_install' => ['label' => 'Habilitar después de la instalación'],
    ],

    'actions' => [
        'toggle' => [
            'enable' => 'Habilitar',
            'disable' => 'Deshabilitar',
        ],
        'view' => ['label' => 'Inspector'],
        'install' => ['label' => 'Instalar paquete'],
        'uninstall' => [
            'label' => 'Desinstalar módulo',
            'confirm_heading' => '¿Desinstalar módulo?',
            'confirm_description' => '¿Está seguro de que desea desinstalar este módulo? Esta acción no se puede deshacer.',
            'confirm_button' => 'Sí, desinstalar',
        ],
        'update' => ['label' => 'Buscar actualizaciones'],
        'backup' => ['label' => 'Crear copia de seguridad'],
        'restore' => ['label' => 'Restaurar última'],
    ],

    'bulk_actions' => [
        'enable' => 'Habilitar seleccionados',
        'enable_confirm' => '¿Habilitar módulos?',
        'enable_description' => '¿Está seguro de que desea habilitar :count módulo(s)?',
        'disable' => 'Deshabilitar seleccionados',
        'disable_confirm' => '¿Deshabilitar módulos?',
        'disable_description' => '¿Está seguro de que desea deshabilitar :count módulo(s)?',
        'uninstall' => 'Desinstalar seleccionados',
        'uninstall_confirm' => '¿Desinstalar módulos?',
        'uninstall_description' => '¿Está seguro de que desea desinstalar :count módulo(s)? Esta acción no se puede deshacer.',
        'uninstall_button' => 'Sí, desinstalar todos',
    ],

    'notifications' => [
        'status_updated' => 'Estado del módulo actualizado correctamente.',
        'installed' => 'Módulo(s) instalado(s) correctamente.',
        'uninstalled' => 'Módulo desinstalado correctamente.',
        'updated' => 'Módulo actualizado correctamente.',
        'backed_up' => 'Copia de seguridad del módulo creada correctamente.',
        'restored' => 'Módulo restaurado desde la última copia de seguridad correctamente.',
        'bulk_enabled' => ':count módulo(s) habilitado(s) correctamente.',
        'bulk_disabled' => ':count módulo(s) deshabilitado(s) correctamente.',
        'bulk_uninstalled' => ':count módulo(s) desinstalado(s) correctamente.',
    ],

    'options' => [
        'sources' => [
            'zip' => 'Paquete ZIP',
            'url' => 'URL / Repositorio GitHub',
            'composer' => 'Paquete Composer',
        ],
        'yes' => 'Sí',
        'no' => 'No',
    ],

    'errors' => [
        'installation_failed' => 'Instalación fallida',
        'unexpected_error' => 'Ocurrió un error inesperado.',
        'unsupported_source' => 'La fuente de instalación ":source" no es compatible.',
        'composer_failed' => 'Instalación de Composer fallida: :error',
        'github_failed' => 'Clonación de GitHub fallida: :error',
        'local_failed' => 'Instalación local fallida: :reason',
        'missing_parameter' => 'Falta el parámetro requerido: :parameter',
        'path_not_found' => 'No se encontró la ruta especificada.',
        'destination_exists' => 'Ya existe un módulo con este nombre en el directorio de destino.',
        'symlink_failed' => 'Error al crear el enlace simbólico para el módulo local.',
        'zip_failed' => 'Extracción de ZIP fallida: :error',
        'metadata_not_found' => 'No se encontró metadata module.json en el paquete.',
        'invalid_metadata' => 'module.json inválido o ilegible en :path.',
        'unknown_author' => 'Autor desconocido',
        'no_description' => 'Sin descripción disponible',
        'not_disableable' => 'El módulo ":name" no se puede deshabilitar.',
        'not_removeable' => 'El módulo ":name" no se puede eliminar.',
        'bulk_uninstall_errors' => 'Algunos módulos no pudieron ser desinstalados',
    ],

    'sections' => [
        'identity' => ['label' => 'Identidad y versionado'],
        'architecture' => ['label' => 'Arquitectura y registro'],
        'discovery' => ['label' => 'Descubrimiento y hooks'],
    ],

    'widgets' => [
        'stats' => [
            'total' => [
                'label' => 'Total de módulos',
                'description' => 'Todos los módulos descubiertos',
            ],
            'enabled' => [
                'label' => 'Habilitados',
                'description' => 'Actualmente activos | :count activos',
            ],
            'disabled' => [
                'label' => 'Deshabilitados',
                'description' => 'Módulos inactivos | :count inactivos',
            ],
            'total_modules' => 'Total de módulos',
            'total_description' => 'Todos los módulos descubiertos',
            'enabled_modules' => 'Módulos habilitados',
            'enabled_description' => ':count deshabilitados',
            'module_health' => 'Salud de módulos',
            'health_description' => 'Porcentaje de módulos habilitados',
        ],
        'distribution' => [
            'label' => 'Total de módulos',
            'enabled' => 'Habilitados',
            'disabled' => 'Deshabilitados',
        ],
        'recent' => ['heading' => 'Módulos recientes'],
    ],

    'filters' => [
        'status' => [
            'label' => 'Estado',
            'enabled' => 'Habilitado',
            'disabled' => 'Deshabilitado',
            'all' => 'Todos los estados',
        ],
        'has_views' => 'Tiene vistas',
        'has_migrations' => 'Tiene migraciones',
        'has_translations' => 'Tiene traducciones',
    ],

    'flags' => [
        'removeable' => 'Eliminable',
        'disableable' => 'Deshabilitab

le',
    ],

    'backups' => [
        'fields' => [
            'filename' => 'Nombre de archivo',
            'size' => 'Tamaño',
            'date' => 'Creado el',
        ],
        'actions' => [
            'restore' => [
                'label' => 'Restaurar',
                'confirm_heading' => '¿Restaurar copia de seguridad?',
                'confirm_description' => '¿Está seguro de que desea restaurar esta copia de seguridad? Los archivos actuales del módulo serán reemplazados.',
                'confirm_button' => 'Sí, restaurar',
            ],
            'delete' => [
                'label' => 'Eliminar',
                'confirm_heading' => '¿Eliminar copia de seguridad?',
                'confirm_description' => '¿Está seguro de que desea eliminar esta copia de seguridad? Esta acción no se puede deshacer.',
                'confirm_button' => 'Sí, eliminar',
            ],
            'delete_bulk' => [
                'label' => 'Eliminar seleccionados',
                'confirm_heading' => '¿Eliminar copias de seguridad?',
                'confirm_description' => '¿Está seguro de que desea eliminar las copias de seguridad seleccionadas? Esta acción no se puede deshacer.',
                'confirm_button' => 'Sí, eliminar todas',
            ],
        ],
        'notifications' => [
            'deleted' => 'Copia de seguridad eliminada correctamente.',
            'bulk_deleted' => 'Copias de seguridad seleccionadas eliminadas correctamente.',
        ],
        'empty' => [
            'heading' => 'Sin copias de seguridad',
            'description' => 'Aún no se han creado copias de seguridad para este módulo.',
        ],
    ],
];
