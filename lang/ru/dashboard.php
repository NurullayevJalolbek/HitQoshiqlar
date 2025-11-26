<?php

return [
    // Asosiy
    'title' => 'Dashboard',
    'page_title' => 'Investitsiya Dashboard',
    'page_subtitle' => 'Barcha ko\'rsatkichlarni real vaqtda kuzatib boring',
    'refresh' => 'Yangilash',

    // Export
    'export' => [
        'pdf' => 'PDF',
        'excel' => 'Excel',
        'csv' => 'CSV',
    ],

    // Filtrlar
    'filters' => [
        'title' => 'Filtrlar',
        'start_date' => 'Boshlanish sanasi',
        'end_date' => 'Tugash sanasi',
        'project_type' => 'Loyiha turi',
        'investor_type' => 'Investor turi',
        'all' => 'Barchasi',
        'apply' => 'Qo\'llash',
        'reset' => 'Tozalash',
    ],

    // Loyiha turlari
    'project_types' => [
        'tech' => 'Texnologiya',
        'real_estate' => 'Ko\'chmas mulk',
        'agriculture' => 'Qishloq xo\'jaligi',
        'manufacturing' => 'Ishlab chiqarish',
    ],

    // Investor turlari
    'investor_types' => [
        'active' => 'Aktiv',
        'passive' => 'Passiv',
    ],

    // KPI Kartalar
    'kpi' => [
        'total_investors' => 'Jami Investorlar',
        'total_investment' => 'Umumiy Sarmoya',
        'active_projects' => 'Faol Loyihalar',
        'total_revenue' => 'Umumiy Daromad',
        'active_investors' => 'Aktiv Investorlar',
        'passive_investors' => 'Passiv Investorlar',
        'total_dividends' => 'Jami Dividendlar',
        'net_profit' => 'Sof Foyda',
        'vs_last_month' => 'O\'tgan oyga nisbatan',
    ],

    // Grafiklar
    'charts' => [
        'investors_growth' => 'Investorlar O\'sish Dinamikasi',
        'projects_distribution' => 'Loyihalar Taqsimoti',
        'investor_income' => 'Investorlar Tushumlari',
        'exit_payments' => 'Chiqish To\'lovlari',
        'contract_revenue' => 'Shartnomalardan Daromad',
        'dividends_distribution' => 'Dividendlar Taqsimoti',
        'net_profit' => 'Sof Foyda Dinamikasi',
        'realization_contracts' => 'Realizatsiya Shartnomalari',
        'documents_growth' => 'Hujjatlar O\'sish Dinamikasi',
        'revenue_by_project' => 'Loyihalar bo\'yicha Daromad',
        
        // Davr
        'month' => 'Oy',
        'year' => 'Yil',
        
        // Statistika
        'total_projects' => 'Jami loyihalar',
        'avg_income' => 'O\'rtacha tushum',
        'avg_payment' => 'O\'rtacha to\'lov',
        'total_contracts' => 'Jami shartnomalar',
        'avg_revenue' => 'O\'rtacha daromad',
        'growth' => 'O\'sish',
        'paid' => 'To\'langan',
        'pending' => 'Kutilmoqda',
        'avg_profit' => 'O\'rtacha foyda',
        'total_signed' => 'Jami imzolangan',
        'contracts' => 'shartnoma',
        
        // Grafik labellar
        'active_investors' => 'Aktiv Investorlar',
        'passive_investors' => 'Passiv Investorlar',
        'revenue_label' => 'Tushumlar',
        'payments_label' => 'To\'lovlar',
        'profit_label' => 'Foyda',
        'contracts_label' => 'Shartnomalar',
    ],

    // Oylar
    'months' => [
        'jan' => 'Yan',
        'feb' => 'Fev',
        'mar' => 'Mar',
        'apr' => 'Apr',
        'may' => 'May',
        'jun' => 'Iyun',
        'jul' => 'Iyul',
        'aug' => 'Avg',
        'sep' => 'Sen',
        'oct' => 'Okt',
        'nov' => 'Noy',
        'dec' => 'Dek',
    ],

    // Xabarlar
    'messages' => [
        'loading' => 'Yuklanmoqda...',
        'success' => 'Muvaffaqiyatli!',
        'error' => 'Xatolik yuz berdi!',
        'filter_applied' => 'Filtrlar qo\'llanildi',
        'export_success' => 'Fayl muvaffaqiyatli yuklandi',
        'no_data' => 'Ma\'lumot topilmadi',
        'select_date' => 'Iltimos, sanalarni tanlang',
        'invalid_date_range' => 'Boshlanish sanasi tugash sanasidan katta bo\'lishi mumkin emas',
    ],
];