<?php

declare(strict_types=1);

return [
    'resource' => [
        'label' => 'Модуль',
        'plural_label' => 'Модули',
        'navigation_label' => 'Модули',
        'navigation_group' => 'Настройки',
        'navigation' => [
            'group' => 'Настройки',
        ],
    ],

    'fields' => [
        'name' => ['label' => 'Название'],
        'description' => ['label' => 'Описание'],
        'version' => ['label' => 'Версия'],
        'status' => [
            'label' => 'Статус',
            'enabled' => 'Включен',
            'disabled' => 'Отключен',
        ],
        'authors' => ['label' => 'Авторы'],
        'assets' => ['label' => 'Ресурсы'],
        'namespace' => ['label' => 'Пространство имен'],
        'path' => ['label' => 'Путь'],
        'providers' => ['label' => 'Провайдеры'],
        'middleware' => ['label' => 'Посредники'],
        'policies' => ['label' => 'Политики'],
        'events' => ['label' => 'События'],
        'source_type' => ['label' => 'Тип источника'],
        'file' => ['label' => 'Пакет модуля (ZIP)'],
        'url' => ['label' => 'URL источника'],
        'composer_package' => ['label' => 'Имя пакета Composer'],
        'enable_after_install' => ['label' => 'Включить после установки'],
    ],

    'actions' => [
        'toggle' => [
            'enable' => 'Включить',
            'disable' => 'Отключить',
        ],
        'view' => ['label' => 'Инспектор'],
        'install' => ['label' => 'Установить пакет'],
        'uninstall' => [
            'label' => 'Удалить модуль',
            'confirm_heading' => 'Удалить модуль?',
            'confirm_description' => 'Вы уверены, что хотите удалить этот модуль? Это действие нельзя отменить.',
            'confirm_button' => 'Да, удалить',
        ],
        'update' => ['label' => 'Проверить обновления'],
        'backup' => ['label' => 'Создать резервную копию'],
        'restore' => ['label' => 'Восстановить последнюю'],
    ],

    'bulk_actions' => [
        'enable' => 'Включить выбранные',
        'enable_confirm' => 'Включить модули?',
        'enable_description' => 'Вы уверены, что хотите включить :count модулей?',
        'disable' => 'Отключить выбранные',
        'disable_confirm' => 'Отключить модули?',
        'disable_description' => 'Вы уверены, что хотите отключить :count модулей?',
        'uninstall' => 'Удалить выбранные',
        'uninstall_confirm' => 'Удалить модули?',
        'uninstall_description' => 'Вы уверены, что хотите удалить :count модулей? Это действие нельзя отменить.',
        'uninstall_button' => 'Да, удалить все',
    ],

    'notifications' => [
        'status_updated' => 'Статус модуля успешно обновлен.',
        'installed' => 'Модуль успешно установлен.',
        'uninstalled' => 'Модуль успешно удален.',
        'updated' => 'Модуль успешно обновлен.',
        'backed_up' => 'Резервная копия модуля успешно создана.',
        'restored' => 'Модуль успешно восстановлен из последней резервной копии.',
        'bulk_enabled' => 'Успешно включено :count модулей.',
        'bulk_disabled' => 'Успешно отключено :count модулей.',
        'bulk_uninstalled' => 'Успешно удалено :count модулей.',
    ],

    'options' => [
        'sources' => [
            'zip' => 'ZIP пакет',
            'url' => 'URL / Репозиторий GitHub',
            'composer' => 'Пакет Composer',
        ],
        'yes' => 'Да',
        'no' => 'Нет',
    ],

    'errors' => [
        'installation_failed' => 'Установка не удалась',
        'unexpected_error' => 'Произошла непредвиденная ошибка.',
        'unsupported_source' => 'Источник установки ":source" не поддерживается.',
        'composer_failed' => 'Установка Composer не удалась: :error',
        'github_failed' => 'Клонирование GitHub не удалось: :error',
        'local_failed' => 'Локальная установка не удалась: :reason',
        'missing_parameter' => 'Отсутствует обязательный параметр: :parameter',
        'path_not_found' => 'Указанный путь не найден.',
        'destination_exists' => 'Модуль с таким именем уже существует в целевом каталоге.',
        'symlink_failed' => 'Не удалось создать символическую ссылку для локального модуля.',
        'zip_failed' => 'Распаковка ZIP не удалась: :error',
        'metadata_not_found' => 'Метаданные module.json не найдены в пакете.',
        'invalid_metadata' => 'Недопустимый или нечитаемый module.json в :path.',
        'unknown_author' => 'Неизвестный автор',
        'no_description' => 'Описание отсутствует',
        'not_disableable' => 'Модуль ":name" нельзя отключить.',
        'not_removeable' => 'Модуль ":name" нельзя удалить.',
        'bulk_uninstall_errors' => 'Некоторые модули не удалось удалить',
    ],

    'sections' => [
        'identity' => ['label' => 'Идентификация и версионирование'],
        'architecture' => ['label' => 'Архитектура и регистрация'],
        'discovery' => ['label' => 'Обнаружение и хуки'],
    ],

    'widgets' => [
        'stats' => [
            'total' => [
                'label' => 'Всего модулей',
                'description' => 'Все обнаруженные модули',
            ],
            'enabled' => [
                'label' => 'Включено',
                'description' => 'Активно сейчас | :count активных',
            ],
            'disabled' => [
                'label' => 'Отключено',
                'description' => 'Неактивные модули | :count неактивных',
            ],
            'total_modules' => 'Всего модулей',
            'total_description' => 'Все обнаруженные модули',
            'enabled_modules' => 'Включенные модули',
            'enabled_description' => ':count отключено',
            'module_health' => 'Здоровье модулей',
            'health_description' => 'Процент включенных модулей',
        ],
        'distribution' => [
            'label' => 'Всего модулей',
            'enabled' => 'Включено',
            'disabled' => 'Отключено',
        ],
        'recent' => ['heading' => 'Последние модули'],
    ],

    'filters' => [
        'status' => [
            'label' => 'Статус',
            'enabled' => 'Включен',
            'disabled' => 'Отключен',
            'all' => 'Все статусы',
        ],
        'has_views' => 'Есть представления',
        'has_migrations' => 'Есть миграции',
        'has_translations' => 'Есть переводы',
    ],

    'flags' => [
        'removeable' => 'Удаляемый',
        'disableable' => 'Отключаемый',
    ],

    'backups' => [
        'fields' => [
            'filename' => 'Имя файла',
            'size' => 'Размер',
            'date' => 'Дата создания',
        ],
        'actions' => [
            'restore' => [
                'label' => 'Восстановить',
                'confirm_heading' => 'Восстановить резервную копию?',
                'confirm_description' => 'Вы уверены, что хотите восстановить эту резервную копию? Текущие файлы модуля будут заменены.',
                'confirm_button' => 'Да, восстановить',
            ],
            'delete' => [
                'label' => 'Удалить',
                'confirm_heading' => 'Удалить резервную копию?',
                'confirm_description' => 'Вы уверены, что хотите удалить эту резервную копию? Это действие нельзя отменить.',
                'confirm_button' => 'Да, удалить',
            ],
            'delete_bulk' => [
                'label' => 'Удалить выбранные',
                'confirm_heading' => 'Удалить резервные копии?',
                'confirm_description' => 'Вы уверены, что хотите удалить выбранные резервные копии? Это действие нельзя отменить.',
                'confirm_button' => 'Да, удалить все',
            ],
        ],
        'notifications' => [
            'deleted' => 'Резервная копия успешно удалена.',
            'bulk_deleted' => 'Выбранные резервные копии успешно удалены.',
        ],
        'empty' => [
            'heading' => 'Нет резервных копий',
            'description' => 'Резервные копии для этого модуля еще не созданы.',
        ],
    ],
];
