<?php

declare(strict_types=1);

return [
    'resource' => [
        'label' => '模块',
        'plural_label' => '模块',
        'navigation_label' => '模块',
        'navigation_group' => '设置',
        'navigation' => [
            'group' => '设置',
        ],
    ],

    'fields' => [
        'name' => ['label' => '名称'],
        'description' => ['label' => '描述'],
        'version' => ['label' => '版本'],
        'status' => [
            'label' => '状态',
            'enabled' => '已启用',
            'disabled' => '已禁用',
        ],
        'authors' => ['label' => '作者'],
        'assets' => ['label' => '资源'],
        'namespace' => ['label' => '命名空间'],
        'path' => ['label' => '路径'],
        'providers' => ['label' => '服务提供者'],
        'middleware' => ['label' => '中间件'],
        'policies' => ['label' => '策略'],
        'events' => ['label' => '事件'],
        'source_type' => ['label' => '来源类型'],
        'file' => ['label' => '模块包 (ZIP)'],
        'url' => ['label' => '来源 URL'],
        'composer_package' => ['label' => 'Composer 包名'],
        'enable_after_install' => ['label' => '安装后启用'],
    ],

    'actions' => [
        'toggle' => [
            'enable' => '启用',
            'disable' => '禁用',
        ],
        'view' => ['label' => '检查器'],
        'install' => ['label' => '安装包'],
        'uninstall' => [
            'label' => '卸载模块',
            'confirm_heading' => '卸载模块？',
            'confirm_description' => '您确定要卸载此模块吗？此操作无法撤消。',
            'confirm_button' => '是的，卸载',
        ],
        'update' => ['label' => '检查更新'],
        'backup' => ['label' => '创建备份'],
        'restore' => ['label' => '恢复最新'],
    ],

    'bulk_actions' => [
        'enable' => '启用所选',
        'enable_confirm' => '启用模块？',
        'enable_description' => '您确定要启用 :count 个模块吗？',
        'disable' => '禁用所选',
        'disable_confirm' => '禁用模块？',
        'disable_description' => '您确定要禁用 :count 个模块吗？',
        'uninstall' => '卸载所选',
        'uninstall_confirm' => '卸载模块？',
        'uninstall_description' => '您确定要卸载 :count 个模块吗？此操作无法撤消。',
        'uninstall_button' => '是的，全部卸载',
    ],

    'notifications' => [
        'status_updated' => '模块状态已成功更新。',
        'installed' => '模块已成功安装。',
        'uninstalled' => '模块已成功卸载。',
        'updated' => '模块已成功更新。',
        'backed_up' => '模块备份已成功创建。',
        'restored' => '已成功从最新备份恢复模块。',
        'bulk_enabled' => '已成功启用 :count 个模块。',
        'bulk_disabled' => '已成功禁用 :count 个模块。',
        'bulk_uninstalled' => '已成功卸载 :count 个模块。',
    ],

    'options' => [
        'sources' => [
            'zip' => 'ZIP 包',
            'url' => 'URL / GitHub 仓库',
            'composer' => 'Composer 包',
        ],
        'yes' => '是',
        'no' => '否',
    ],

    'errors' => [
        'installation_failed' => '安装失败',
        'unexpected_error' => '发生意外错误。',
        'unsupported_source' => '不支持安装来源 ":source"。',
        'composer_failed' => 'Composer 安装失败：:error',
        'github_failed' => 'GitHub 克隆失败：:error',
        'local_failed' => '本地安装失败：:reason',
        'missing_parameter' => '缺少必需参数：:parameter',
        'path_not_found' => '未找到指定路径。',
        'destination_exists' => '目标目录中已存在同名模块。',
        'symlink_failed' => '无法为本地模块创建符号链接。',
        'zip_failed' => 'ZIP 解压失败：:error',
        'metadata_not_found' => '包中未找到 module.json 元数据。',
        'invalid_metadata' => ':path 处的 module.json 无效或不可读。',
        'unknown_author' => '未知作者',
        'no_description' => '无可用描述',
        'not_disableable' => '模块 ":name" 无法禁用。',
        'not_removeable' => '模块 ":name" 无法移除。',
        'bulk_uninstall_errors' => '某些模块无法卸载',
    ],

    'sections' => [
        'identity' => ['label' => '身份和版本'],
        'architecture' => ['label' => '架构和注册'],
        'discovery' => ['label' => '发现和钩子'],
    ],

    'widgets' => [
        'stats' => [
            'total' => [
                'label' => '总模块数',
                'description' => '所有已发现的模块',
            ],
            'enabled' => [
                'label' => '已启用',
                'description' => '当前活动 | :count 个活动',
            ],
            'disabled' => [
                'label' => '已禁用',
                'description' => '非活动模块 | :count 个非活动',
            ],
            'total_modules' => '总模块数',
            'total_description' => '所有已发现的模块',
            'enabled_modules' => '已启用模块',
            'enabled_description' => ':count 个已禁用',
            'module_health' => '模块健康度',
            'health_description' => '已启用模块的百分比',
        ],
        'distribution' => [
            'label' => '总模块数',
            'enabled' => '已启用',
            'disabled' => '已禁用',
        ],
        'recent' => ['heading' => '最近模块'],
    ],

    'filters' => [
        'status' => [
            'label' => '状态',
            'enabled' => '已启用',
            'disabled' => '已禁用',
            'all' => '所有状态',
        ],
        'has_views' => '有视图',
        'has_migrations' => '有迁移',
        'has_translations' => '有翻译',
    ],

    'flags' => [
        'removeable' => '可移除',
        'disableable' => '可禁用',
    ],

    'backups' => [
        'fields' => [
            'filename' => '文件名',
            'size' => '大小',
            'date' => '创建时间',
        ],
        'actions' => [
            'restore' => [
                'label' => '恢复',
                'confirm_heading' => '恢复备份？',
                'confirm_description' => '您确定要恢复此备份吗？当前模块文件将被替换。',
                'confirm_button' => '是的，恢复',
            ],
            'delete' => [
                'label' => '删除',
                'confirm_heading' => '删除备份？',
                'confirm_description' => '您确定要删除此备份吗？此操作无法撤消。',
                'confirm_button' => '是的，删除',
            ],
            'delete_bulk' => [
                'label' => '删除所选',
                'confirm_heading' => '删除备份？',
                'confirm_description' => '您确定要删除所选备份吗？此操作无法撤消。',
                'confirm_button' => '是的，全部删除',
            ],
        ],
        'notifications' => [
            'deleted' => '备份已成功删除。',
            'bulk_deleted' => '所选备份已成功删除。',
        ],
        'empty' => [
            'heading' => '无备份',
            'description' => '尚未为此模块创建备份。',
        ],
    ],
];
