<?php

declare(strict_types=1);

return [
    'resource' => [
        'label' => 'وحدة',
        'plural_label' => 'الوحدات',
        'navigation_label' => 'الوحدات',
        'navigation_group' => 'الإعدادات',
        'navigation' => [
            'group' => 'الإعدادات',
        ],
    ],

    'fields' => [
        'name' => ['label' => 'الاسم'],
        'description' => ['label' => 'الوصف'],
        'version' => ['label' => 'الإصدار'],
        'status' => [
            'label' => 'الحالة',
            'enabled' => 'مفعّل',
            'disabled' => 'معطّل',
        ],
        'authors' => ['label' => 'المؤلفون'],
        'assets' => ['label' => 'الموارد'],
        'namespace' => ['label' => 'مساحة الأسماء'],
        'path' => ['label' => 'المسار'],
        'providers' => ['label' => 'مزودو الخدمة'],
        'middleware' => ['label' => 'الوسيط'],
        'policies' => ['label' => 'السياسات'],
        'events' => ['label' => 'الأحداث'],
        'source_type' => ['label' => 'نوع المصدر'],
        'file' => ['label' => 'حزمة الوحدة (ZIP)'],
        'url' => ['label' => 'رابط المصدر'],
        'composer_package' => ['label' => 'اسم حزمة Composer'],
        'enable_after_install' => ['label' => 'تفعيل بعد التثبيت'],
    ],

    'actions' => [
        'toggle' => [
            'enable' => 'تفعيل',
            'disable' => 'تعطيل',
        ],
        'view' => ['label' => 'المفتش'],
        'install' => ['label' => 'تثبيت الحزمة'],
        'uninstall' => [
            'label' => 'إلغاء تثبيت الوحدة',
            'confirm_heading' => 'إلغاء تثبيت الوحدة؟',
            'confirm_description' => 'هل أنت متأكد من رغبتك في إلغاء تثبيت هذه الوحدة؟ لا يمكن التراجع عن هذا الإجراء.',
            'confirm_button' => 'نعم، إلغاء التثبيت',
        ],
        'update' => ['label' => 'التحقق من التحديثات'],
        'backup' => ['label' => 'إنشاء نسخة احتياطية'],
        'restore' => ['label' => 'استعادة الأحدث'],
    ],

    'bulk_actions' => [
        'enable' => 'تفعيل المحدد',
        'enable_confirm' => 'تفعيل الوحدات؟',
        'enable_description' => 'هل أنت متأكد من رغبتك في تفعيل :count وحدة؟',
        'disable' => 'تعطيل المحدد',
        'disable_confirm' => 'تعطيل الوحدات؟',
        'disable_description' => 'هل أنت متأكد من رغبتك في تعطيل :count وحدة؟',
        'uninstall' => 'إلغاء تثبيت المحدد',
        'uninstall_confirm' => 'إلغاء تثبيت الوحدات؟',
        'uninstall_description' => 'هل أنت متأكد من رغبتك في إلغاء تثبيت :count وحدة؟ لا يمكن التراجع عن هذا الإجراء.',
        'uninstall_button' => 'نعم، إلغاء تثبيت الكل',
    ],

    'notifications' => [
        'status_updated' => 'تم تحديث حالة الوحدة بنجاح.',
        'installed' => 'تم تثبيت الوحدة بنجاح.',
        'uninstalled' => 'تم إلغاء تثبيت الوحدة بنجاح.',
        'updated' => 'تم تحديث الوحدة بنجاح.',
        'backed_up' => 'تم إنشاء النسخة الاحتياطية للوحدة بنجاح.',
        'restored' => 'تمت استعادة الوحدة من النسخة الاحتياطية الأخيرة بنجاح.',
        'bulk_enabled' => 'تم تفعيل :count وحدة بنجاح.',
        'bulk_disabled' => 'تم تعطيل :count وحدة بنجاح.',
        'bulk_uninstalled' => 'تم إلغاء تثبيت :count وحدة بنجاح.',
    ],

    'options' => [
        'sources' => [
            'zip' => 'حزمة ZIP',
            'url' => 'رابط / مستودع GitHub',
            'composer' => 'حزمة Composer',
        ],
        'yes' => 'نعم',
        'no' => 'لا',
    ],

    'errors' => [
        'installation_failed' => 'فشل التثبيت',
        'unexpected_error' => 'حدث خطأ غير متوقع.',
        'unsupported_source' => 'مصدر التثبيت ":source" غير مدعوم.',
        'composer_failed' => 'فشل تثبيت Composer: :error',
        'github_failed' => 'فشل استنساخ GitHub: :error',
        'local_failed' => 'فشل التثبيت المحلي: :reason',
        'missing_parameter' => 'المعامل المطلوب مفقود: :parameter',
        'path_not_found' => 'لم يتم العثور على المسار المحدد.',
        'destination_exists' => 'توجد بالفعل وحدة بهذا الاسم في الدليل الهدف.',
        'symlink_failed' => 'فشل إنشاء الرابط الرمزي للوحدة المحلية.',
        'zip_failed' => 'فشل استخراج ZIP: :error',
        'metadata_not_found' => 'لم يتم العثور على بيانات module.json في الحزمة.',
        'invalid_metadata' => 'module.json غير صالح أو غير قابل للقراءة في :path.',
        'unknown_author' => 'مؤلف غير معروف',
        'no_description' => 'لا يوجد وصف متاح',
        'not_disableable' => 'لا يمكن تعطيل الوحدة ":name".',
        'not_removeable' => 'لا يمكن إزالة الوحدة ":name".',
        'bulk_uninstall_errors' => 'تعذر إلغاء تثبيت بعض الوحدات',
    ],

    'sections' => [
        'identity' => ['label' => 'الهوية والإصدار'],
        'architecture' => ['label' => 'البنية والتسجيل'],
        'discovery' => ['label' => 'الاكتشاف والخطافات'],
    ],

    'widgets' => [
        'stats' => [
            'total' => [
                'label' => 'إجمالي الوحدات',
                'description' => 'جميع الوحدات المكتشفة',
            ],
            'enabled' => [
                'label' => 'مفعّل',
                'description' => 'نشط حالياً | :count نشط',
            ],
            'disabled' => [
                'label' => 'معطّل',
                'description' => 'وحدات غير نشطة | :count غير نشط',
            ],
            'total_modules' => 'إجمالي الوحدات',
            'total_description' => 'جميع الوحدات المكتشفة',
            'enabled_modules' => 'الوحدات المفعّلة',
            'enabled_description' => ':count معطّل',
            'module_health' => 'صحة الوحدات',
            'health_description' => 'نسبة الوحدات المفعّلة',
        ],
        'distribution' => [
            'label' => 'إجمالي الوحدات',
            'enabled' => 'مفعّل',
            'disabled' => 'معطّل',
        ],
        'recent' => ['heading' => 'الوحدات الأخيرة'],
    ],

    'filters' => [
        'status' => [
            'label' => 'الحالة',
            'enabled' => 'مفعّل',
            'disabled' => 'معطّل',
            'all' => 'جميع الحالات',
        ],
        'has_views' => 'يحتوي على عروض',
        'has_migrations' => 'يحتوي على ترحيلات',
        'has_translations' => 'يحتوي على ترجمات',
    ],

    'flags' => [
        'removeable' => 'قابل للإزالة',
        'disableable' => 'قابل للتعطيل',
    ],

    'backups' => [
        'fields' => [
            'filename' => 'اسم الملف',
            'size' => 'الحجم',
            'date' => 'تاريخ الإنشاء',
        ],
        'actions' => [
            'restore' => [
                'label' => 'استعادة',
                'confirm_heading' => 'استعادة النسخة الاحتياطية؟',
                'confirm_description' => 'هل أنت متأكد من رغبتك في استعادة هذه النسخة الاحتياطية؟ سيتم استبدال ملفات الوحدة الحالية.',
                'confirm_button' => 'نعم، استعادة',
            ],
            'delete' => [
                'label' => 'حذف',
                'confirm_heading' => 'حذف النسخة الاحتياطية؟',
                'confirm_description' => 'هل أنت متأكد من رغبتك في حذف هذه النسخة الاحتياطية؟ لا يمكن التراجع عن هذا الإجراء.',
                'confirm_button' => 'نعم، حذف',
            ],
            'delete_bulk' => [
                'label' => 'حذف المحدد',
                'confirm_heading' => 'حذف النسخ الاحتياطية؟',
                'confirm_description' => 'هل أنت متأكد من رغبتك في حذف النسخ الاحتياطية المحددة؟ لا يمكن التراجع عن هذا الإجراء.',
                'confirm_button' => 'نعم، حذف الكل',
            ],
        ],
        'notifications' => [
            'deleted' => 'تم حذف النسخة الاحتياطية بنجاح.',
            'bulk_deleted' => 'تم حذف النسخ الاحتياطية المحددة بنجاح.',
        ],
        'empty' => [
            'heading' => 'لا توجد نسخ احتياطية',
            'description' => 'لم يتم إنشاء نسخ احتياطية لهذه الوحدة بعد.',
        ],
    ],
];
