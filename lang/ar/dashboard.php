<?php
return [
    // الرئيسية
    'title' => 'لوحة المعلومات',
    'page_title' => 'لوحة المعلومات الاستثمارية',
    'page_subtitle' => 'تتبع جميع المؤشرات في الوقت الفعلي',
    'refresh' => 'تحديث',

    // التصدير
    'export' => [
        'pdf' => 'PDF',
        'excel' => 'Excel',
        'csv' => 'CSV',
    ],

    // الفلاتر
    'filters' => [
        'title' => 'الفلاتر',
        'start_date' => 'تاريخ البدء',
        'end_date' => 'تاريخ الانتهاء',
        'project_type' => 'نوع المشروع',
        'investor_type' => 'نوع المستثمر',
        'all' => 'الكل',
        'apply' => 'تطبيق',
        'reset' => 'إعادة تعيين',
    ],

    // أنواع المشاريع
    'project_types' => [
        'tech' => 'التكنولوجيا',
        'real_estate' => 'العقارات',
        'agriculture' => 'الزراعة',
        'manufacturing' => 'التصنيع',
    ],

    // أنواع المستثمرين
    'investor_types' => [
        'active' => 'نشط',
        'passive' => 'سلبي',
    ],

    // بطاقات KPI
    'kpi' => [
        'total_investors' => 'إجمالي المستثمرين',
        'total_investment' => 'إجمالي الاستثمار',
        'active_projects' => 'المشاريع النشطة',
        'total_revenue' => 'إجمالي الإيرادات',
        'active_investors' => 'المستثمرون النشطون',
        'passive_investors' => 'المستثمرون السلبيون',
        'total_dividends' => 'إجمالي الأرباح',
        'net_profit' => 'صافي الربح',
        'vs_last_month' => 'مقارنة بالشهر الماضي',
    ],

    // الرسوم البيانية
    'charts' => [
        'investors_growth' => 'ديناميكية نمو المستثمرين',
        'projects_distribution' => 'توزيع المشاريع',
        'investor_income' => 'دخل المستثمرين',
        'exit_payments' => 'مدفوعات الخروج',
        'contract_revenue' => 'إيرادات العقود',
        'dividends_distribution' => 'توزيع الأرباح',
        'net_profit' => 'ديناميكية صافي الربح',
        'realization_contracts' => 'عقود التحقيق',
        'documents_growth' => 'ديناميكية نمو المستندات',
        'revenue_by_project' => 'الإيرادات حسب المشروع',

        // الفترة
        'month' => 'شهر',
        'year' => 'سنة',

        // الإحصائيات
        'total_projects' => 'إجمالي المشاريع',
        'avg_income' => 'متوسط الدخل',
        'avg_payment' => 'متوسط الدفع',
        'total_contracts' => 'إجمالي العقود',
        'avg_revenue' => 'متوسط الإيرادات',
        'growth' => 'النمو',
        'paid' => 'مدفوع',
        'pending' => 'معلق',
        'avg_profit' => 'متوسط الربح',
        'total_signed' => 'إجمالي الموقعة',
        'contracts' => 'عقود',

        // تسميات الرسم البياني
        'active_investors' => 'المستثمرون النشطون',
        'passive_investors' => 'المستثمرون السلبيون',
        'revenue_label' => 'الإيرادات',
        'payments_label' => 'المدفوعات',
        'profit_label' => 'الربح',
        'contracts_label' => 'العقود',
    ],

    // الأشهر
    'months' => [
        'jan' => 'يناير',
        'feb' => 'فبراير',
        'mar' => 'مارس',
        'apr' => 'أبريل',
        'may' => 'مايو',
        'jun' => 'يونيو',
        'jul' => 'يوليو',
        'aug' => 'أغسطس',
        'sep' => 'سبتمبر',
        'oct' => 'أكتوبر',
        'nov' => 'نوفمبر',
        'dec' => 'ديسمبر',
    ],

    // الرسائل
    'messages' => [
        'loading' => 'جاري التحميل...',
        'success' => 'نجح!',
        'error' => 'حدث خطأ!',
        'filter_applied' => 'تم تطبيق الفلاتر',
        'export_success' => 'تم تنزيل الملف بنجاح',
        'no_data' => 'لم يتم العثور على بيانات',
        'select_date' => 'الرجاء تحديد التواريخ',
        'invalid_date_range' => 'لا يمكن أن يكون تاريخ البدء أكبر من تاريخ الانتهاء',
    ],
    'project_types' => [
        'land' => 'الأرض',
        'rent' => 'الإيجار',
        'construction' => 'البناء',
    ],
];
