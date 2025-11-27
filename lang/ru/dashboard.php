<?php
return [
    // Основные
    'title' => 'Панель управления',
    'page_title' => 'Инвестиционная Панель',
    'page_subtitle' => 'Отслеживайте все показатели в режиме реального времени',
    'refresh' => 'Обновить',

    // Экспорт
    'export' => [
        'pdf' => 'PDF',
        'excel' => 'Excel',
        'csv' => 'CSV',
    ],

    // Фильтры
    'filters' => [
        'title' => 'Фильтры',
        'start_date' => 'Дата начала',
        'end_date' => 'Дата окончания',
        'project_type' => 'Тип проекта',
        'investor_type' => 'Тип инвестора',
        'all' => 'Все',
        'apply' => 'Применить',
        'reset' => 'Сбросить',
    ],

    // Типы проектов
    'project_types' => [
        'tech' => 'Технологии',
        'real_estate' => 'Недвижимость',
        'agriculture' => 'Сельское хозяйство',
        'manufacturing' => 'Производство',
    ],

    // Типы инвесторов
    'investor_types' => [
        'active' => 'Активный',
        'passive' => 'Пассивный',
    ],

    // KPI карточки
    'kpi' => [
        'total_investors' => 'Всего Инвесторов',
        'total_investment' => 'Общие Инвестиции',
        'active_projects' => 'Активные Проекты',
        'total_revenue' => 'Общий Доход',
        'active_investors' => 'Активные Инвесторы',
        'passive_investors' => 'Пассивные Инвесторы',
        'total_dividends' => 'Всего Дивидендов',
        'net_profit' => 'Чистая Прибыль',
        'vs_last_month' => 'По сравнению с прошлым месяцем',
    ],

    // Графики
    'charts' => [
        'investors_growth' => 'Динамика Роста Инвесторов',
        'projects_distribution' => 'Распределение Проектов',
        'investor_income' => 'Доход Инвесторов',
        'exit_payments' => 'Платежи на Выход',
        'contract_revenue' => 'Доход от Контрактов',
        'dividends_distribution' => 'Распределение Дивидендов',
        'net_profit' => 'Динамика Чистой Прибыли',
        'realization_contracts' => 'Контракты Реализации',
        'documents_growth' => 'Динамика Роста Документов',
        'revenue_by_project' => 'Доход по Проектам',

        // Период
        'month' => 'Месяц',
        'year' => 'Год',

        // Статистика
        'total_projects' => 'Всего проектов',
        'avg_income' => 'Средний доход',
        'avg_payment' => 'Средний платеж',
        'total_contracts' => 'Всего контрактов',
        'avg_revenue' => 'Средний доход',
        'growth' => 'Рост',
        'paid' => 'Оплачено',
        'pending' => 'Ожидается',
        'avg_profit' => 'Средняя прибыль',
        'total_signed' => 'Всего подписано',
        'contracts' => 'контрактов',

        // Метки графиков
        'active_investors' => 'Активные Инвесторы',
        'passive_investors' => 'Пассивные Инвесторы',
        'revenue_label' => 'Доходы',
        'payments_label' => 'Платежи',
        'profit_label' => 'Прибыль',
        'contracts_label' => 'Контракты',
    ],

    // Месяцы
    'months' => [
        'jan' => 'Янв',
        'feb' => 'Фев',
        'mar' => 'Мар',
        'apr' => 'Апр',
        'may' => 'Май',
        'jun' => 'Июн',
        'jul' => 'Июл',
        'aug' => 'Авг',
        'sep' => 'Сен',
        'oct' => 'Окт',
        'nov' => 'Ноя',
        'dec' => 'Дек',
    ],

    // Сообщения
    'messages' => [
        'loading' => 'Загрузка...',
        'success' => 'Успешно!',
        'error' => 'Произошла ошибка!',
        'filter_applied' => 'Фильтры применены',
        'export_success' => 'Файл успешно загружен',
        'no_data' => 'Данные не найдены',
        'select_date' => 'Пожалуйста, выберите даты',
        'invalid_date_range' => 'Дата начала не может быть больше даты окончания',
    ],
    'project_types' => [
        'land' => 'Земля',
        'rent' => 'Аренда',
        'construction' => 'Строительство',
    ],
];
