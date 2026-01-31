<?php

declare(strict_types=1);

return [
    'resource' => [
        'label' => 'モジュール',
        'plural_label' => 'モジュール',
        'navigation_label' => 'モジュール',
        'navigation_group' => '設定',
        'navigation' => [
            'group' => '設定',
        ],
    ],

    'fields' => [
        'name' => ['label' => '名前'],
        'description' => ['label' => '説明'],
        'version' => ['label' => 'バージョン'],
        'status' => [
            'label' => 'ステータス',
            'enabled' => '有効',
            'disabled' => '無効',
        ],
        'authors' => ['label' => '作成者'],
        'assets' => ['label' => 'アセット'],
        'namespace' => ['label' => '名前空間'],
        'path' => ['label' => 'パス'],
        'providers' => ['label' => 'プロバイダー'],
        'middleware' => ['label' => 'ミドルウェア'],
        'policies' => ['label' => 'ポリシー'],
        'events' => ['label' => 'イベント'],
        'source_type' => ['label' => 'ソースタイプ'],
        'file' => ['label' => 'モジュールパッケージ (ZIP)'],
        'url' => ['label' => 'ソース URL'],
        'composer_package' => ['label' => 'Composer パッケージ名'],
        'enable_after_install' => ['label' => 'インストール後に有効化'],
    ],

    'actions' => [
        'toggle' => [
            'enable' => '有効化',
            'disable' => '無効化',
        ],
        'view' => ['label' => 'インスペクター'],
        'install' => ['label' => 'パッケージをインストール'],
        'uninstall' => [
            'label' => 'モジュールをアンインストール',
            'confirm_heading' => 'モジュールをアンインストールしますか？',
            'confirm_description' => 'このモジュールをアンインストールしてもよろしいですか？この操作は元に戻せません。',
            'confirm_button' => 'はい、アンインストール',
        ],
        'update' => ['label' => '更新を確認'],
        'backup' => ['label' => 'バックアップを作成'],
        'restore' => ['label' => '最新を復元'],
    ],

    'bulk_actions' => [
        'enable' => '選択を有効化',
        'enable_confirm' => 'モジュールを有効化しますか？',
        'enable_description' => ':count 個のモジュールを有効化してもよろしいですか？',
        'disable' => '選択を無効化',
        'disable_confirm' => 'モジュールを無効化しますか？',
        'disable_description' => ':count 個のモジュールを無効化してもよろしいですか？',
        'uninstall' => '選択をアンインストール',
        'uninstall_confirm' => 'モジュールをアンインストールしますか？',
        'uninstall_description' => ':count 個のモジュールをアンインストールしてもよろしいですか？この操作は元に戻せません。',
        'uninstall_button' => 'はい、すべてアンインストール',
    ],

    'notifications' => [
        'status_updated' => 'モジュールのステータスが正常に更新されました。',
        'installed' => 'モジュールが正常にインストールされました。',
        'uninstalled' => 'モジュールが正常にアンインストールされました。',
        'updated' => 'モジュールが正常に更新されました。',
        'backed_up' => 'モジュールのバックアップが正常に作成されました。',
        'restored' => '最新のバックアップからモジュールが正常に復元されました。',
        'bulk_enabled' => ':count 個のモジュールが正常に有効化されました。',
        'bulk_disabled' => ':count 個のモジュールが正常に無効化されました。',
        'bulk_uninstalled' => ':count 個のモジュールが正常にアンインストールされました。',
    ],

    'options' => [
        'sources' => [
            'zip' => 'ZIP パッケージ',
            'url' => 'URL / GitHub リポジトリ',
            'composer' => 'Composer パッケージ',
        ],
        'yes' => 'はい',
        'no' => 'いいえ',
    ],

    'errors' => [
        'installation_failed' => 'インストールに失敗しました',
        'unexpected_error' => '予期しないエラーが発生しました。',
        'unsupported_source' => 'インストールソース ":source" はサポートされていません。',
        'composer_failed' => 'Composer のインストールに失敗しました：:error',
        'github_failed' => 'GitHub のクローンに失敗しました：:error',
        'local_failed' => 'ローカルインストールに失敗しました：:reason',
        'missing_parameter' => '必須パラメータが不足しています：:parameter',
        'path_not_found' => '指定されたパスが見つかりませんでした。',
        'destination_exists' => 'この名前のモジュールは既にターゲットディレクトリに存在します。',
        'symlink_failed' => 'ローカルモジュールのシンボリックリンクの作成に失敗しました。',
        'zip_failed' => 'ZIP の展開に失敗しました：:error',
        'metadata_not_found' => 'パッケージに module.json メタデータが見つかりませんでした。',
        'invalid_metadata' => ':path の module.json が無効または読み取れません。',
        'unknown_author' => '不明な作成者',
        'no_description' => '説明がありません',
        'not_disableable' => 'モジュール ":name" は無効化できません。',
        'not_removeable' => 'モジュール ":name" は削除できません。',
        'bulk_uninstall_errors' => '一部のモジュールをアンインストールできませんでした',
    ],

    'sections' => [
        'identity' => ['label' => 'アイデンティティとバージョン管理'],
        'architecture' => ['label' => 'アーキテクチャと登録'],
        'discovery' => ['label' => '検出とフック'],
    ],

    'widgets' => [
        'stats' => [
            'total' => [
                'label' => '総モジュール数',
                'description' => '検出されたすべてのモジュール',
            ],
            'enabled' => [
                'label' => '有効',
                'description' => '現在アクティブ | :count 個アクティブ',
            ],
            'disabled' => [
                'label' => '無効',
                'description' => '非アクティブなモジュール | :count 個非アクティブ',
            ],
            'total_modules' => '総モジュール数',
            'total_description' => '検出されたすべてのモジュール',
            'enabled_modules' => '有効なモジュール',
            'enabled_description' => ':count 個無効',
            'module_health' => 'モジュールの健全性',
            'health_description' => '有効なモジュールの割合',
        ],
        'distribution' => [
            'label' => '総モジュール数',
            'enabled' => '有効',
            'disabled' => '無効',
        ],
        'recent' => ['heading' => '最近のモジュール'],
    ],

    'filters' => [
        'status' => [
            'label' => 'ステータス',
            'enabled' => '有効',
            'disabled' => '無効',
            'all' => 'すべてのステータス',
        ],
        'has_views' => 'ビューあり',
        'has_migrations' => 'マイグレーションあり',
        'has_translations' => '翻訳あり',
    ],

    'flags' => [
        'removeable' => '削除可能',
        'disableable' => '無効化可能',
    ],

    'backups' => [
        'fields' => [
            'filename' => 'ファイル名',
            'size' => 'サイズ',
            'date' => '作成日時',
        ],
        'actions' => [
            'restore' => [
                'label' => '復元',
                'confirm_heading' => 'バックアップを復元しますか？',
                'confirm_description' => 'このバックアップを復元してもよろしいですか？現在のモジュールファイルは置き換えられます。',
                'confirm_button' => 'はい、復元',
            ],
            'delete' => [
                'label' => '削除',
                'confirm_heading' => 'バックアップを削除しますか？',
                'confirm_description' => 'このバックアップを削除してもよろしいですか？この操作は元に戻せません。',
                'confirm_button' => 'はい、削除',
            ],
            'delete_bulk' => [
                'label' => '選択を削除',
                'confirm_heading' => 'バックアップを削除しますか？',
                'confirm_description' => '選択したバックアップを削除してもよろしいですか？この操作は元に戻せません。',
                'confirm_button' => 'はい、すべて削除',
            ],
        ],
        'notifications' => [
            'deleted' => 'バックアップが正常に削除されました。',
            'bulk_deleted' => '選択したバックアップが正常に削除されました。',
        ],
        'empty' => [
            'heading' => 'バックアップなし',
            'description' => 'このモジュールのバックアップはまだ作成されていません。',
        ],
    ],
];
