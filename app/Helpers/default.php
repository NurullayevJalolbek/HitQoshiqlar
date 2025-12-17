<?php

use Illuminate\Support\Collection;




function isActiveRoute($routeName, $output = 'active')
{
    return request()->routeIs($routeName) ? $output : '';
}


function isActiveCollapseArray($routeNames, $class = 'active'): string
{
    foreach ($routeNames as $routeName) {
        if (request()->routeIs($routeName) || request()->is($routeName)) {
            return $class;
        }
    }

    return '';
}


function formatCurrency($number, $decimal = 0)
{
    if (is_null($number)) {
        return 0;
    }

    $decimal = strlen(explode('.', (string) $number)[1] ?? '');

    return number_format($number, $decimal, '.', ' ');
}



// Paginatsa uchun dinamik funksiya 
if (!function_exists('manualPaginate')) {
    /**
     *
     * @param array|\Illuminate\Support\Collection $items
     * @param int $perPage
     * @param int|null $currentPage
     * @return array
     */
    function manualPaginate($items, $perPage = 10, $currentPage = null)
    {
        if (is_array($items)) {
            $items = collect($items);
        }

        $currentPage = $currentPage ?? request()->get('page', 1);
        $total = $items->count();
        $pageCount = ceil($total / $perPage);

        $offset = ($currentPage - 1) * $perPage;
        $paginatedItems = $items->slice($offset, $perPage);

        $start = $total > 0 ? $offset + 1 : 0;
        $end = min($currentPage * $perPage, $total);

        return [
            'items' => $paginatedItems,
            'currentPage' => $currentPage,
            'perPage' => $perPage,
            'total' => $total,
            'pageCount' => $pageCount,
            'start' => $start,
            'end' => $end,
        ];
    }
}



// Statik userlar
if (!function_exists('getUsersData')) {
    /**
     * Foydalanuvchilar malumotlarini olish.
     *
     * @param int|null $id
     * @return \Illuminate\Support\Collection
     */
    function getUsersData($id = null): Collection
    {
        $datas = collect([
            [
                'id' => 1,
                'name' => 'Olim Jo‘rayev',
                'username' => 'olim_admin',
                'phone' => '+998 90 111 22 33',
                'email' => 'olim@example.com',
                'role' => 'Admin',
                'status' => 'Faol',
                'created_at' => '2025-11-25 14:32'
            ],
            [
                'id' => 2,
                'name' => 'Javohir Tursunov',
                'username' => 'javohir_mod1',
                'phone' => '+998 93 222 33 44',
                'email' => 'javohir@example.com',
                'role' => 'Moderator',
                'status' => 'Faol',
                'created_at' => '2025-11-26 09:15'
            ],
            [
                'id' => 3,
                'name' => 'Rustam Abdurahmonov',
                'username' => 'rustam_mod2',
                'phone' => '+998 95 333 44 55',
                'email' => 'rustam@example.com',
                'role' => 'Moderator',
                'status' => 'Faol',
                'created_at' => '2025-11-24 11:20'
            ],
            [
                'id' => 4,
                'name' => 'Zoir Bekmurodov',
                'username' => 'zoir_mod3',
                'phone' => '+998 97 444 55 66',
                'email' => 'zoir@example.com',
                'role' => 'Moderator',
                'status' => 'Bloklangan',
                'created_at' => '2025-11-20 18:20'
            ],
            [
                'id' => 5,
                'name' => 'Nodir Qodirov',
                'username' => 'nodir_aud1',
                'phone' => '+998 90 555 66 77',
                'email' => 'nodir@example.com',
                'role' => 'Moliyaviy auditor',
                'status' => 'Faol',
                'created_at' => '2025-11-23 15:52'
            ],
            [
                'id' => 6,
                'name' => 'Umid Abdullayev',
                'username' => 'umid_aud2',
                'phone' => '+998 93 666 77 88',
                'email' => 'umid@example.com',
                'role' => 'Moliyaviy auditor',
                'status' => 'Bloklangan',
                'created_at' => '2025-11-19 10:10'
            ],
            [
                'id' => 7,
                'name' => 'Sirojiddin Madrahimov',
                'username' => 'siroj_islam1',
                'phone' => '+998 97 777 88 99',
                'email' => 'siroj@example.com',
                'role' => 'Islom moliyasi nazorati',
                'status' => 'Faol',
                'created_at' => '2025-11-26 07:55'
            ],
            [
                'id' => 8,
                'name' => 'Husan Sharipov',
                'username' => 'husan_islam2',
                'phone' => '+998 95 888 99 00',
                'email' => 'husan@example.com',
                'role' => 'Islom moliyasi nazorati',
                'status' => 'Faol',
                'created_at' => '2025-11-22 12:40'
            ],
            [
                'id' => 9,
                'name' => 'Sherzod Mamatov',
                'username' => 'sherzod_admin2',
                'phone' => '+998 90 112 45 67',
                'email' => 'sherzod@example.com',
                'role' => 'Moderator',
                'status' => 'Faol',
                'created_at' => '2025-11-27 08:10'
            ],
            [
                'id' => 10,
                'name' => 'Jasur Rahmonov',
                'username' => 'jasur_mod4',
                'phone' => '+998 93 221 44 55',
                'email' => 'jasur@example.com',
                'role' => 'Moderator',
                'status' => 'Faol',
                'created_at' => '2025-11-25 19:44'
            ],
            [
                'id' => 11,
                'name' => 'Dilshod Yusupov',
                'username' => 'dilshod_aud3',
                'phone' => '+998 91 334 55 66',
                'email' => 'dilshod@example.com',
                'role' => 'Moliyaviy auditor',
                'status' => 'Bloklangan',
                'created_at' => '2025-11-18 11:05'
            ],
            [
                'id' => 12,
                'name' => 'Farrux Karimov',
                'username' => 'farrux_islam3',
                'phone' => '+998 94 445 66 77',
                'email' => 'farrux@example.com',
                'role' => 'Islom moliyasi nazorati',
                'status' => 'Faol',
                'created_at' => '2025-11-23 16:15'
            ],
            [
                'id' => 13,
                'name' => 'Bekzod Soliyev',
                'username' => 'bekzod_mod5',
                'phone' => '+998 99 556 77 88',
                'email' => 'bekzod@example.com',
                'role' => 'Moderator',
                'status' => 'Faol',
                'created_at' => '2025-11-26 10:40'
            ],
            [
                'id' => 14,
                'name' => 'Bobur Xolmatov',
                'username' => 'bobur_aud4',
                'phone' => '+998 90 667 88 99',
                'email' => 'bobur@example.com',
                'role' => 'Moliyaviy auditor',
                'status' => 'Faol',
                'created_at' => '2025-11-24 13:22'
            ],
            [
                'id' => 15,
                'name' => 'Akmal Ortiqov',
                'username' => 'akmal_islam4',
                'phone' => '+998 93 778 99 11',
                'email' => 'akmal@example.com',
                'role' => 'Islom moliyasi nazorati',
                'status' => 'Bloklangan',
                'created_at' => '2025-11-21 09:05'
            ],
        ]);

        if ($id) {
            return $datas->where('id', $id)->values();
        }

        return $datas;
    }
}


// Statik investorlar
if (!function_exists('getInvestorsData')) {
    /**
     * Investorlar ma'lumotlarini olish.
     *
     * @param int|null $id - Agar id berilsa, faqat o'sha investor ma'lumotlarini qaytaradi
     * @return \Illuminate\Support\Collection|array
     */
    function getInvestorsData($id = null)
    {
        $investors = collect([
            [
                'id' => 1,
                'name' => 'Jasur Islomov',
                'username' => 'jasur',
                'phone' => '+998 90 123 45 67',
                'passport' => 'AA 1234567',
                'inn' => '12345678901234',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-25 14:32'
            ],
            [
                'id' => 2,
                'name' => 'Gulbahor Qodirova',
                'username' => 'gulbahor',
                'phone' => '+998 90 987 65 43',
                'passport' => 'AB 7654321',
                'inn' => '98765432109876',
                'status' => 'Kutilmoqda',
                'verification_status' => 'Tasdiqlanmagan',
                'created_at' => '2025-11-26 09:15'
            ],
            [
                'id' => 3,
                'name' => 'Olimjon Tursunov',
                'username' => 'olimjon',
                'phone' => '+998 93 344 55 66',
                'passport' => 'AC 1122334',
                'inn' => '11223344556677',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-27 08:50'
            ],
            [
                'id' => 4,
                'name' => 'Nilufar Rasulova',
                'username' => 'nilufar',
                'phone' => '+998 92 233 44 55',
                'passport' => 'AD 5566778',
                'inn' => '55667788901234',
                'status' => 'Bloklangan',
                'verification_status' => 'Tasdiqlanmagan',
                'created_at' => '2025-11-24 18:20'
            ],
            [
                'id' => 5,
                'name' => 'Azizbek Karimov',
                'username' => 'azizbek',
                'phone' => '+998 91 122 33 44',
                'passport' => 'AA 9988776',
                'inn' => '99887766554433',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-26 12:45'
            ],
            [
                'id' => 6,
                'name' => 'Saodat Davronova',
                'username' => 'saodat',
                'phone' => '+998 90 011 22 33',
                'passport' => 'AB 4455667',
                'inn' => '44556677889900',
                'status' => 'Kutilmoqda',
                'verification_status' => 'Tasdiqlanmagan',
                'created_at' => '2025-11-23 16:10'
            ],
            [
                'id' => 7,
                'name' => 'Oybek Rahimov',
                'username' => 'oybek',
                'phone' => '+998905554433',
                'passport' => '',
                'inn' => '',
                'status' => 'Kutilmoqda',
                'verification_status' => 'Tasdiqlanmagan',
                'created_at' => '2025-11-22 11:10'
            ],
            [
                'id' => 8,
                'name' => 'Dilorom Mamarasul',
                'username' => 'dilorom',
                'phone' => '+998 90 999 88 77',
                'passport' => 'AC 5544332',
                'inn' => '55443322110099',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-21 17:33'
            ],
            [
                'id' => 9,
                'name' => 'Sirojiddin Bekmurodov',
                'username' => 'siroj',
                'phone' => '+998 90 001 12 23',
                'passport' => '',
                'inn' => '',
                'status' => 'Kutilmoqda',
                'verification_status' => 'Tasdiqlanmagan',
                'created_at' => '2025-11-20 09:55'
            ],
            [
                'id' => 10,
                'name' => 'Komil Qurbonov',
                'username' => 'komil',
                'phone' => '+998 933 30 11 22',
                'passport' => 'AA 8899007',
                'inn' => '88990077665544',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-19 08:12'
            ],
            [
                'id' => 11,
                'name' => 'Madina Usmonova',
                'username' => 'madina',
                'phone' => '+998 93 004 56 12',
                'passport' => 'AB 122994',
                'inn' => '11229944556677',
                'status' => 'Bloklangan',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-18 19:55'
            ],
            [
                'id' => 12,
                'name' => 'Jamshid Soliyev',
                'username' => 'jamshid',
                'phone' => '+998 95 003 32 21',
                'passport' => 'AC 7788112',
                'inn' => '77881122334455',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-17 16:40'
            ],
            [
                'id' => 13,
                'name' => 'Shohjahon Abdullayev',
                'username' => 'shoh',
                'phone' => '+998 97 771 23 45',
                'passport' => 'AD 6677885',
                'inn' => '66778855332211',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-16 10:27'
            ],
            [
                'id' => 14,
                'name' => 'Hilola Qodirova',
                'username' => 'hilola',
                'phone' => '+998 93 445 56 67',
                'passport' => '',
                'inn' => '',
                'status' => 'Kutilmoqda',
                'verification_status' => 'Tasdiqlanmagan',
                'created_at' => '2025-11-15 14:22'
            ],
            [
                'id' => 15,
                'name' => 'Aziza Matyoqubova',
                'username' => 'aziza',
                'phone' => '+998 99 011 22 33',
                'passport' => 'AA 4455667',
                'inn' => '44556677889911',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-14 18:00'
            ]
        ]);

        if ($id) {
            // ID berilsa, faqat o'sha investor ma'lumotlarini qaytaradi
            return $investors->where('id', $id)->first();
        }

        // ID berilmasa, barcha investorlarni qaytaradi
        return $investors;
    }



    function getRolesData($id = null): Collection
    {
        $roles = collect([
            [
                'id' => 1,
                'name' => 'Admin',
                'code' => 'admin',
                'icon' => 'fa-solid fa-user-gear',
                'users_count' => 0,
                'description' => 'Tizimni to\'liq boshqarish',
                'permissions_url' => route('admin.role-permissions.index'),
                'is_deletable' => false
            ],
            [
                'id' => 2,
                'name' => 'Moliyaviy auditor',
                'code' => 'finance',
                'icon' => 'fa-solid fa-file-invoice-dollar',
                'users_count' => 3,
                'description' => 'Moliyaviy ma\'lumotlarni tekshirish',
                'permissions_url' => route('admin.role-permissions.index'),
                'is_deletable' => true
            ],
            [
                'id' => 3,
                'name' => 'Moderator',
                'code' => 'moderator',
                'icon' => 'fa-solid fa-user-shield',
                'users_count' => 5,
                'description' => 'Kontent va foydalanuvchilarni nazorat qilish',
                'permissions_url' => route('admin.role-permissions.index'),
                'is_deletable' => true
            ],
            [
                'id' => 4,
                'name' => 'Islom moliyasi nazorati',
                'code' => 'islamic_fin',
                'icon' => 'fa-solid fa-scale-balanced',
                'users_count' => 1,
                'description' => 'Shariat asosida moliyaviy nazorat',
                'permissions_url' => route('admin.role-permissions.index'),
                'is_deletable' => true
            ]
        ]);

        if ($id) {
            return $roles->where('id', $id)->values();
        }

        return $roles;
    }
}

function getLoginHistoriesData($id = null): Collection
{
    $histories = collect([
        [
            'id' => 1,
            'user' => 'Olim Jo‘rayev',
            'username' => 'olim_admin',
            'date' => '2025-01-02 04:00', // eng yangi
            'ip' => '192.168.1.10',
            'result' => 'Ogohlantirish', // 3-marta xato
            'geo' => 'Toshkent',
            'user_agent' => 'Chrome / Windows 10',
            'session_id' => 'SID-15',
            'login_duration' => '3 soniya',
            'phone' => '+998901112233'
        ],
        [
            'id' => 2,
            'user' => 'Olim Jo‘rayev',
            'username' => 'olim_admin',
            'date' => '2025-01-02 03:55', // 2-xato
            'ip' => '192.168.1.10',
            'result' => 'Xato',
            'geo' => 'Toshkent',
            'user_agent' => 'Chrome / Windows 10',
            'session_id' => 'SID-14',
            'login_duration' => '2 soniya',
            'phone' => '+998901112233'
        ],
        [
            'id' => 3,
            'user' => 'Olim Jo‘rayev',
            'username' => 'olim_admin',
            'date' => '2025-01-02 03:50', // 1-xato
            'ip' => '192.168.1.10',
            'result' => 'Xato',
            'geo' => 'Toshkent',
            'user_agent' => 'Chrome / Windows 10',
            'session_id' => 'SID-13',
            'login_duration' => '1 soniya',
            'phone' => '+998901112233'
        ],
        [
            'id' => 4,
            'user' => 'Javohir Tursunov',
            'username' => 'javohir_mod1',
            'date' => '2025-01-02 03:45',
            'ip' => '192.168.1.11',
            'result' => 'Muvaffaqiyatli',
            'geo' => 'Toshkent',
            'user_agent' => 'Firefox / Windows 11',
            'session_id' => 'SID-12',
            'login_duration' => '4 soniya',
            'phone' => '+998932223344'
        ],
        [
            'id' => 5,
            'user' => 'Rustam Abdurahmonov',
            'username' => 'rustam_mod2',
            'date' => '2025-01-02 03:40',
            'ip' => '192.168.1.12',
            'result' => 'Ogohlantirish', // 3-marta xato
            'geo' => 'Samarqand',
            'user_agent' => 'Safari / MacOS',
            'session_id' => 'SID-11',
            'login_duration' => '2 soniya',
            'phone' => '+998953334455'
        ],
        [
            'id' => 6,
            'user' => 'Rustam Abdurahmonov',
            'username' => 'rustam_mod2',
            'date' => '2025-01-02 03:35',
            'ip' => '192.168.1.12',
            'result' => 'Xato',
            'geo' => 'Samarqand',
            'user_agent' => 'Safari / MacOS',
            'session_id' => 'SID-10',
            'login_duration' => '3 soniya',
            'phone' => '+998953334455'
        ],
        [
            'id' => 7,
            'user' => 'Rustam Abdurahmonov',
            'username' => 'rustam_mod2',
            'date' => '2025-01-02 03:30',
            'ip' => '192.168.1.12',
            'result' => 'Xato',
            'geo' => 'Samarqand',
            'user_agent' => 'Safari / MacOS',
            'session_id' => 'SID-9',
            'login_duration' => '2 soniya',
            'phone' => '+998953334455'
        ],
        [
            'id' => 8,
            'user' => 'Zoir Bekmurodov',
            'username' => 'zoir_mod3',
            'date' => '2025-01-02 03:25',
            'ip' => '192.168.1.13',
            'result' => 'Muvaffaqiyatli',
            'geo' => 'Buxoro',
            'user_agent' => 'Edge / Windows 10',
            'session_id' => 'SID-8',
            'login_duration' => '6 soniya',
            'phone' => '+998974445566'
        ],
        [
            'id' => 9,
            'user' => 'Nodir Qodirov',
            'username' => 'nodir_aud1',
            'date' => '2025-01-02 03:20',
            'ip' => '192.168.1.14',
            'result' => 'Xato',
            'geo' => 'Toshkent',
            'user_agent' => 'Chrome / Android',
            'session_id' => 'SID-7',
            'login_duration' => '3 soniya',
            'phone' => '+998905556677'
        ],
        [
            'id' => 10,
            'user' => 'Umid Abdullayev',
            'username' => 'umid_aud2',
            'date' => '2025-01-02 03:15',
            'ip' => '192.168.1.15',
            'result' => 'Muvaffaqiyatli',
            'geo' => 'Samarqand',
            'user_agent' => 'Opera / Windows 10',
            'session_id' => 'SID-6',
            'login_duration' => '5 soniya',
            'phone' => '+998936677888'
        ],
        [
            'id' => 11,
            'user' => 'Sirojiddin Madrahimov',
            'username' => 'siroj_islam1',
            'date' => '2025-01-02 03:10',
            'ip' => '192.168.1.16',
            'result' => 'Ogohlantirish', // 3-marta xato
            'geo' => 'Toshkent',
            'user_agent' => 'Chrome / iOS',
            'session_id' => 'SID-5',
            'login_duration' => '4 soniya',
            'phone' => '+998977778899'
        ],
        [
            'id' => 12,
            'user' => 'Sirojiddin Madrahimov',
            'username' => 'siroj_islam1',
            'date' => '2025-01-02 03:05',
            'ip' => '192.168.1.16',
            'result' => 'Xato',
            'geo' => 'Toshkent',
            'user_agent' => 'Chrome / iOS',
            'session_id' => 'SID-4',
            'login_duration' => '2 soniya',
            'phone' => '+998977778899'
        ],
        [
            'id' => 13,
            'user' => 'Sirojiddin Madrahimov',
            'username' => 'siroj_islam1',
            'date' => '2025-01-02 03:00',
            'ip' => '192.168.1.16',
            'result' => 'Xato',
            'geo' => 'Toshkent',
            'user_agent' => 'Chrome / iOS',
            'session_id' => 'SID-3',
            'login_duration' => '3 soniya',
            'phone' => '+998977778899'
        ],
        [
            'id' => 14,
            'user' => 'Husan Sharipov',
            'username' => 'husan_islam2',
            'date' => '2025-01-02 02:55',
            'ip' => '192.168.1.17',
            'result' => 'Muvaffaqiyatli',
            'geo' => 'Buxoro',
            'user_agent' => 'Firefox / Linux',
            'session_id' => 'SID-2',
            'login_duration' => '7 soniya',
            'phone' => '+998958889900'
        ],
        [
            'id' => 15,
            'user' => 'Sherzod Mamatov',
            'username' => 'sherzod_admin2',
            'date' => '2025-01-02 02:50',
            'ip' => '192.168.1.18',
            'result' => 'Xato',
            'geo' => 'Samarqand',
            'user_agent' => 'Edge / Windows 11',
            'session_id' => 'SID-1',
            'login_duration' => '2 soniya',
            'phone' => '+998901124567'
        ]
    ]);

    if ($id !== null) {
        return $histories->where('id', $id)->values();
    }

    return $histories;
}




function getAllPermissionsData(): Collection
{
    return collect([
        'tabs' => getTabs(),
        'menus' => getMenusTab(),
        'dashboard' => getDashboardTab(),
        'projects' => getProjectsTab(),
        'project_investors' => getProjectInvestorsTab(),
        'project_buyers' => getProjectBuyersTab(),
        'project_entry_requests' => getProjectEntryRequestsTab(),
        'project_exit_requests' => getProjectExitRequestsTab(),
        'company_details' => getCompanyDetailsTab(),
        'revenues' => getRevenuesTab(),
        'expenses' => getExpensesTab(),
        'distributions' => getDistributionsTab(),
        'contracts' => getContractsTab(),
        'reports' => getReportsTab(),
        'islamic' => getIslamicTab(),
        'references' => getReferencesTab(),
        'general_settings' => getGeneralSettingsTab(),
        'integration_settings' => getIntegrationSettingsTab(),
        'user_interface' => getUserInterfaceTab(),
        'users' => getUsersTab(),
        'investors' => getInvestorsTab(),
        'roles' => getRolesTab(),
        'login_histories' => getLoginHistoriesTab(),
        'system_logs' => getSystemLogsTab(),
        'notifications' => getNotificationsTab()
    ]);
}

/**
 * Tablar ro'yxati
 */
function getTabs(): Collection
{
    return collect([
        ['id' => 'dashboard', 'name' => 'Dashboard', 'icon' => 'speedometer2'],
        ['id' => 'projects', 'name' => 'Loyihalar', 'icon' => 'building'],
        ['id' => 'revenues', 'name' => 'Tushumlar', 'icon' => 'currency-dollar'],
        ['id' => 'incomes', 'name' => 'Daromadlar', 'icon' => 'wallet2'],
        ['id' => 'expenses', 'name' => 'Xarajatlar', 'icon' => 'cash-stack'],
        ['id' => 'distributions', 'name' => 'Taqsimot', 'icon' => 'diagram-3'],
        ['id' => 'contracts', 'name' => 'Shartnomalar', 'icon' => 'file-earmark-text'],
        ['id' => 'reports', 'name' => 'Hisobotlar', 'icon' => 'bar-chart-line'],
        ['id' => 'islamic', 'name' => 'Islom moliyasi', 'icon' => 'shield-check'],
        ['id' => 'settings', 'name' => 'Sozlamalar', 'icon' => 'gear'],
        ['id' => 'administration', 'name' => 'Ma\'muriyat', 'icon' => 'grid-3x3-gap'],
        ['id' => 'notifications', 'name' => 'Bildirishnomalar', 'icon' => 'bell']
    ]);
}

/**
 * MENYULAR tab ma'lumotlari
 */
function getMenusTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Dashboard', 'icon' => 'speedometer2', 'checked' => true],
        ['id' => 2, 'name' => 'Loyihalar', 'icon' => 'building', 'checked' => true],
        ['id' => 3, 'name' => 'Investorlar', 'icon' => 'people', 'checked' => true],
        ['id' => 4, 'name' => 'Xaridorlar', 'icon' => 'person-badge', 'checked' => true],
        ['id' => 5, 'name' => 'Kirish so\'rovlari', 'icon' => 'door-open', 'checked' => true],
        ['id' => 6, 'name' => 'Chiqish so\'rovlari', 'icon' => 'door-closed', 'checked' => true],
        ['id' => 7, 'name' => 'Rekvizitlar', 'icon' => 'building', 'checked' => true],
        ['id' => 8, 'name' => 'Tushumlar', 'icon' => 'currency-dollar', 'checked' => true],
        ['id' => 9, 'name' => 'Xarajatlar', 'icon' => 'cash-stack', 'checked' => true],
        ['id' => 10, 'name' => 'Taqsimot', 'icon' => 'diagram-3', 'checked' => true],
        ['id' => 11, 'name' => 'Shartnomalar', 'icon' => 'file-earmark-text', 'checked' => true],
        ['id' => 12, 'name' => 'Hisobotlar', 'icon' => 'bar-chart-line', 'checked' => true],
        ['id' => 13, 'name' => 'Islom moliyasi', 'icon' => 'shield-check', 'checked' => true],
        ['id' => 14, 'name' => 'Ma\'lumotnomalar', 'icon' => 'file-text', 'checked' => true],
        ['id' => 15, 'name' => 'Umumiy sozlamalar', 'icon' => 'gear-wide', 'checked' => true],
        ['id' => 16, 'name' => 'Integratsiyalar', 'icon' => 'plug', 'checked' => true],
        ['id' => 17, 'name' => 'Interfeys', 'icon' => 'display', 'checked' => true],
        ['id' => 18, 'name' => 'Foydalanuvchilar', 'icon' => 'person', 'checked' => true],
        ['id' => 19, 'name' => 'Investorlar', 'icon' => 'people', 'checked' => true],
        ['id' => 20, 'name' => 'Rollar', 'icon' => 'shield', 'checked' => true],
        ['id' => 21, 'name' => 'Kirish tarixi', 'icon' => 'clock-history', 'checked' => true],
        ['id' => 22, 'name' => 'Tizim loglari', 'icon' => 'journal-text', 'checked' => true],
        ['id' => 23, 'name' => 'Bildirishnomalar', 'icon' => 'bell', 'checked' => true]
    ]);
}

/**
 * 1. DASHBOARD
 */
function getDashboardTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Dashboard ko\'rinishi', 'route' => 'admin.dashboard', 'method' => 'GET', 'checked' => false]
    ]);
}

/**
 * 2. LOYIHALAR
 */
function getProjectsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Loyihalar ro\'yxati', 'route' => 'admin.projects.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Loyiha yaratish', 'route' => 'admin.projects.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Loyiha saqlash', 'route' => 'admin.projects.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Loyihani ko\'rish', 'route' => 'admin.projects.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Loyihani tahrirlash', 'route' => 'admin.projects.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Loyihani yangilash', 'route' => 'admin.projects.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Loyihani o\'chirish', 'route' => 'admin.projects.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 3. LOYIHA INVESTORLAR
 */
function getProjectInvestorsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Loyiha investorlar ro\'yxati', 'route' => 'admin.project-investors.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Loyiha investor yaratish', 'route' => 'admin.project-investors.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Loyiha investor saqlash', 'route' => 'admin.project-investors.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Loyiha investor ko\'rish', 'route' => 'admin.project-investors.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Loyiha investor tahrirlash', 'route' => 'admin.project-investors.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Loyiha investor yangilash', 'route' => 'admin.project-investors.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Loyiha investor o\'chirish', 'route' => 'admin.project-investors.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 4. LOYIHA XARIDORLAR
 */
function getProjectBuyersTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Loyiha xaridorlar ro\'yxati', 'route' => 'admin.project-buyers.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Loyiha xaridor yaratish', 'route' => 'admin.project-buyers.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Loyiha xaridor saqlash', 'route' => 'admin.project-buyers.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Loyiha xaridor ko\'rish', 'route' => 'admin.project-buyers.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Loyiha xaridor tahrirlash', 'route' => 'admin.project-buyers.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Loyiha xaridor yangilash', 'route' => 'admin.project-buyers.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Loyiha xaridor o\'chirish', 'route' => 'admin.project-buyers.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 5. KIRISH SO'ROVLARI
 */
function getProjectEntryRequestsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Kirish so\'rovlari ro\'yxati', 'route' => 'admin.project-entry-requests.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Kirish so\'rovi yaratish', 'route' => 'admin.project-entry-requests.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Kirish so\'rovi saqlash', 'route' => 'admin.project-entry-requests.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Kirish so\'rovini ko\'rish', 'route' => 'admin.project-entry-requests.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Kirish so\'rovini tahrirlash', 'route' => 'admin.project-entry-requests.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Kirish so\'rovini yangilash', 'route' => 'admin.project-entry-requests.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Kirish so\'rovini o\'chirish', 'route' => 'admin.project-entry-requests.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 6. CHIQISH SO'ROVLARI
 */
function getProjectExitRequestsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Chiqish so\'rovlari ro\'yxati', 'route' => 'admin.project-exit-requests.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Chiqish so\'rovi yaratish', 'route' => 'admin.project-exit-requests.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Chiqish so\'rovi saqlash', 'route' => 'admin.project-exit-requests.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Chiqish so\'rovini ko\'rish', 'route' => 'admin.project-exit-requests.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Chiqish so\'rovini tahrirlash', 'route' => 'admin.project-exit-requests.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Chiqish so\'rovini yangilash', 'route' => 'admin.project-exit-requests.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Chiqish so\'rovini o\'chirish', 'route' => 'admin.project-exit-requests.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 7. REKVIZITLAR
 */
function getCompanyDetailsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Korxona rekvizitlari', 'route' => 'admin.company-details.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Rekvizit yaratish', 'route' => 'admin.company-details.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Rekvizit saqlash', 'route' => 'admin.company-details.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Rekvizitni ko\'rish', 'route' => 'admin.company-details.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Rekvizitni tahrirlash', 'route' => 'admin.company-details.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Rekvizitni yangilash', 'route' => 'admin.company-details.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Rekvizitni o\'chirish', 'route' => 'admin.company-details.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 8. TUSHUMLAR
 */
function getRevenuesTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Tushumlar ro\'yxati', 'route' => 'admin.revenues.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Tushum yaratish', 'route' => 'admin.revenues.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Tushum saqlash', 'route' => 'admin.revenues.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Tushumni ko\'rish', 'route' => 'admin.revenues.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Tushumni tahrirlash', 'route' => 'admin.revenues.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Tushumni yangilash', 'route' => 'admin.revenues.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Tushumni o\'chirish', 'route' => 'admin.revenues.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 9. XARAJATLAR
 */
function getExpensesTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Xarajatlar ro\'yxati', 'route' => 'admin.expenses.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Xarajat yaratish', 'route' => 'admin.expenses.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Xarajat saqlash', 'route' => 'admin.expenses.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Xarajatni ko\'rish', 'route' => 'admin.expenses.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Xarajatni tahrirlash', 'route' => 'admin.expenses.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Xarajatni yangilash', 'route' => 'admin.expenses.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Xarajatni o\'chirish', 'route' => 'admin.expenses.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 10. TAQSIMOT
 */
function getDistributionsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Taqsimotlar ro\'yxati', 'route' => 'admin.distributions.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Taqsimot yaratish', 'route' => 'admin.distributions.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Taqsimot saqlash', 'route' => 'admin.distributions.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Taqsimotni ko\'rish', 'route' => 'admin.distributions.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Taqsimotni tahrirlash', 'route' => 'admin.distributions.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Taqsimotni yangilash', 'route' => 'admin.distributions.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Taqsimotni o\'chirish', 'route' => 'admin.distributions.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 11. SHARTNOMALAR
 */
function getContractsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Shartnomalar ro\'yxati', 'route' => 'admin.investment-contracts.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Shartnoma yaratish', 'route' => 'admin.investment-contracts.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Shartnoma saqlash', 'route' => 'admin.investment-contracts.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Shartnomani ko\'rish', 'route' => 'admin.investment-contracts.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Shartnomani tahrirlash', 'route' => 'admin.investment-contracts.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Shartnomani yangilash', 'route' => 'admin.investment-contracts.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Shartnomani o\'chirish', 'route' => 'admin.investment-contracts.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 12. HISOBOTLAR
 */
function getReportsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Hisobotlar ro\'yxati', 'route' => 'admin.reports.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Hisobot yaratish', 'route' => 'admin.reports.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Hisobot saqlash', 'route' => 'admin.reports.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Hisobotni ko\'rish', 'route' => 'admin.reports.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Hisobotni tahrirlash', 'route' => 'admin.reports.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Hisobotni yangilash', 'route' => 'admin.reports.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Hisobotni o\'chirish', 'route' => 'admin.reports.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 13. ISLOM MOLIYASI
 */
function getIslamicTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Islom moliyasi ro\'yxati', 'route' => 'admin.islamic-finance.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Islom moliyasi yaratish', 'route' => 'admin.islamic-finance.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Islom moliyasi saqlash', 'route' => 'admin.islamic-finance.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Islom moliyasi ko\'rish', 'route' => 'admin.islamic-finance.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Islom moliyasi tahrirlash', 'route' => 'admin.islamic-finance.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Islom moliyasi yangilash', 'route' => 'admin.islamic-finance.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Islom moliyasi o\'chirish', 'route' => 'admin.islamic-finance.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 14. MA'LUMOTNOMALAR
 */
function getReferencesTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Ma\'lumotnomalar ro\'yxati', 'route' => 'admin.references.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Ma\'lumotnoma yaratish', 'route' => 'admin.references.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Ma\'lumotnoma saqlash', 'route' => 'admin.references.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Ma\'lumotnomani ko\'rish', 'route' => 'admin.references.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Ma\'lumotnomani tahrirlash', 'route' => 'admin.references.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Ma\'lumotnomani yangilash', 'route' => 'admin.references.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Ma\'lumotnomani o\'chirish', 'route' => 'admin.references.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 15. UMUMIY SOZLAMALAR
 */
function getGeneralSettingsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Umumiy sozlamalar', 'route' => 'admin.general-settings.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Sozlamani yaratish', 'route' => 'admin.general-settings.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Sozlamani saqlash', 'route' => 'admin.general-settings.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Sozlamani ko\'rish', 'route' => 'admin.general-settings.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Sozlamani tahrirlash', 'route' => 'admin.general-settings.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Sozlamani yangilash', 'route' => 'admin.general-settings.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Sozlamani o\'chirish', 'route' => 'admin.general-settings.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 16. INTEGRATSIYALAR
 */
function getIntegrationSettingsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Integratsiya sozlamalari', 'route' => 'admin.integration-settings.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Integratsiya yaratish', 'route' => 'admin.integration-settings.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Integratsiya saqlash', 'route' => 'admin.integration-settings.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Integratsiyani ko\'rish', 'route' => 'admin.integration-settings.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Integratsiyani tahrirlash', 'route' => 'admin.integration-settings.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Integratsiyani yangilash', 'route' => 'admin.integration-settings.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Integratsiyani o\'chirish', 'route' => 'admin.integration-settings.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 17. INTERFEYS
 */
function getUserInterfaceTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Interfeys sozlamalari', 'route' => 'admin.user-interface.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Til boshqaruvi', 'route' => 'admin.user-interface.language-management.index', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Tizim tarjimalari', 'route' => 'admin.user-interface.system-translations.index', 'method' => 'GET', 'checked' => false],
        ['id' => 4, 'name' => 'Shablon xabarlari', 'route' => 'admin.user-interface.template-messages.index', 'method' => 'GET', 'checked' => false]
    ]);
}

/**
 * 18. FOYDALANUVCHILAR
 */
function getUsersTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Foydalanuvchilar ro\'yxati', 'route' => 'admin.users.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Foydalanuvchi yaratish', 'route' => 'admin.users.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Foydalanuvchi saqlash', 'route' => 'admin.users.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Foydalanuvchini ko\'rish', 'route' => 'admin.users.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Foydalanuvchini tahrirlash', 'route' => 'admin.users.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Foydalanuvchini yangilash', 'route' => 'admin.users.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Foydalanuvchini o\'chirish', 'route' => 'admin.users.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 19. INVESTORLAR (Ma'muriyat)
 */
function getInvestorsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Investorlar ro\'yxati', 'route' => 'admin.investors.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Investor yaratish', 'route' => 'admin.investors.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Investor saqlash', 'route' => 'admin.investors.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Investorni ko\'rish', 'route' => 'admin.investors.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Investorni tahrirlash', 'route' => 'admin.investors.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Investorni yangilash', 'route' => 'admin.investors.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Investorni o\'chirish', 'route' => 'admin.investors.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 20. ROLLAR
 */
function getRolesTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Rollar ro\'yxati', 'route' => 'admin.roles.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Rol yaratish', 'route' => 'admin.roles.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Rol saqlash', 'route' => 'admin.roles.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Rolni ko\'rish', 'route' => 'admin.roles.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Rolni tahrirlash', 'route' => 'admin.roles.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Rolni yangilash', 'route' => 'admin.roles.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Rolni o\'chirish', 'route' => 'admin.roles.destroy', 'method' => 'DELETE', 'checked' => false],
        ['id' => 8, 'name' => 'Ruxsatlar boshqaruvi', 'route' => 'admin.role-permissions.index', 'method' => 'GET', 'checked' => false]
    ]);
}

/**
 * 21. KIRISH TARIXI
 */
function getLoginHistoriesTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Kirish tarixi ro\'yxati', 'route' => 'admin.login-histories.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Kirish tarixi yaratish', 'route' => 'admin.login-histories.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Kirish tarixi saqlash', 'route' => 'admin.login-histories.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Kirish tarixini ko\'rish', 'route' => 'admin.login-histories.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Kirish tarixini tahrirlash', 'route' => 'admin.login-histories.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Kirish tarixini yangilash', 'route' => 'admin.login-histories.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Kirish tarixini o\'chirish', 'route' => 'admin.login-histories.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 22. TIZIM LOGLARI
 */
function getSystemLogsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Tizim loglari ro\'yxati', 'route' => 'admin.system-logs.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Log yaratish', 'route' => 'admin.system-logs.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Log saqlash', 'route' => 'admin.system-logs.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Logni ko\'rish', 'route' => 'admin.system-logs.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Logni tahrirlash', 'route' => 'admin.system-logs.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Logni yangilash', 'route' => 'admin.system-logs.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Logni o\'chirish', 'route' => 'admin.system-logs.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}

/**
 * 23. BILDIRISHNOMALAR
 */
function getNotificationsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Bildirishnomalar ro\'yxati', 'route' => 'admin.notifications.index', 'method' => 'GET', 'checked' => false],
        ['id' => 2, 'name' => 'Bildirishnoma yaratish', 'route' => 'admin.notifications.create', 'method' => 'GET', 'checked' => false],
        ['id' => 3, 'name' => 'Bildirishnoma saqlash', 'route' => 'admin.notifications.store', 'method' => 'POST', 'checked' => false],
        ['id' => 4, 'name' => 'Bildirishnomani ko\'rish', 'route' => 'admin.notifications.show', 'method' => 'GET', 'checked' => false],
        ['id' => 5, 'name' => 'Bildirishnomani tahrirlash', 'route' => 'admin.notifications.edit', 'method' => 'GET', 'checked' => false],
        ['id' => 6, 'name' => 'Bildirishnomani yangilash', 'route' => 'admin.notifications.update', 'method' => 'PUT', 'checked' => false],
        ['id' => 7, 'name' => 'Bildirishnomani o\'chirish', 'route' => 'admin.notifications.destroy', 'method' => 'DELETE', 'checked' => false]
    ]);
}



function getSystemLogsData($id = null): Collection
{
    $systemLogs =  collect([
        [
            'id' => 1,
            'time' => '2025-12-02 10:05:30',
            'level' => 'Muvaffaqiyatli',
            'action' => 'UPDATE',
            'module' => "Loyihalar",
            'user' => 'admin',
            'ip' => '192.168.1.10',
            'desc' => "Loyiha 'Yangi Texno Park' ma'lumotlari yangilandi",
            'extra' => "O'zgartirilgan maydonlar: nomi, byudjet"
        ],
        [
            'id' => 2,
            'time' => '2025-12-02 10:01:15',
            'level' => 'Xato',
            'action' => 'CREATE',
            'module' => "Loyihalar",
            'user' => 'sardor',
            'ip' => '192.168.1.15',
            'desc' => "Loyiha yaratishda xatolik yuz berdi: Nomi takrorlanishi",
            'extra' => "Xatolik kodi: 409 CONFLICT"
        ],
        [
            'id' => 3,
            'time' => '2025-12-02 09:55:40',
            'level' => 'Muvaffaqiyatli',
            'action' => 'EXPORT',
            'module' => "Loyihalar",
            'user' => 'ali',
            'ip' => '192.168.1.20',
            'desc' => "Loyihalar ro'yxatini CSV formatida export qilish amalga oshirildi",
            'extra' => "Fayl nomi: projects_20251202.csv"
        ],
        [
            'id' => 4,
            'time' => '2025-12-02 09:45:00',
            'level' => 'Ogohlantirish',
            'action' => 'DELETE',
            'module' => "Investorlar",
            'user' => 'bobur',
            'ip' => '192.168.1.18',
            'desc' => "Investorni o'chirishda noaniqlik kuzatildi. Investitsiyalar hali mavjud",
            'extra' => "Investor ID: 105, Status: Pending Confirmation"
        ],
        [
            'id' => 5,
            'time' => '2025-12-02 09:40:22',
            'level' => 'Muvaffaqiyatli',
            'action' => 'CREATE',
            'module' => "Investorlar",
            'user' => 'anna',
            'ip' => '192.168.1.14',
            'desc' => "Yangi investor 'Global Invest Corp' qo'shildi",
            'extra' => "Investor ID: 108"
        ],
        [
            'id' => 6,
            'time' => '2025-12-02 09:35:10',
            'level' => 'Xato',
            'action' => 'UPDATE',
            'module' => "Ma'muriyat bo'limi",
            'user' => 'admin',
            'ip' => '192.168.1.11',
            'desc' => "Admin foydalanuvchisi sozlamalarida xatolik: Ruxsatlar saqlanmadi",
            'extra' => "Database error: Timeout"
        ],
        [
            'id' => 7,
            'time' => '2025-12-02 09:30:55',
            'level' => 'Ogohlantirish',
            'action' => 'EXPORT',
            'module' => "Hisobotlar",
            'user' => 'dilshod',
            'ip' => '192.168.1.21',
            'desc' => "Yillik hisobot eksportida vaqtinchalik kechikish (5 soniya)",
            'extra' => "Hisobot turi: Yillik daromad"
        ],
        [
            'id' => 8,
            'time' => '2025-12-02 09:25:00',
            'level' => 'Muvaffaqiyatli',
            'action' => 'CREATE',
            'module' => "Hisobotlar",
            'user' => 'ali',
            'ip' => '192.168.1.22',
            'desc' => "Yangi 'Oylik Moliyaviy' hisobot generatsiya qilindi",
            'extra' => "Hisobot ID: 55"
        ],
        [
            'id' => 9,
            'time' => '2025-12-02 09:20:11',
            'level' => 'Xato',
            'action' => 'DELETE',
            'module' => "Loyihalar",
            'user' => 'sardor',
            'ip' => '192.168.1.19',
            'desc' => "Loyiha ID: 201 ni o'chirishda xatolik aniqlandi: Bog'liq resurslar topildi",
            'extra' => "Xatolik kodi: 403 Forbidden"
        ],
        [
            'id' => 10,
            'time' => '2025-12-02 09:15:30',
            'level' => 'Muvaffaqiyatli',
            'action' => 'UPDATE',
            'module' => "Investorlar",
            'user' => 'bobur',
            'ip' => '192.168.1.16',
            'desc' => "Investor 'Azizov Group' aloqa ma'lumotlari yangilandi",
            'extra' => "O'zgartirilgan maydonlar: telefon, email"
        ],
        [
            'id' => 11,
            'time' => '2025-12-01 18:00:00',
            'level' => 'Muvaffaqiyatli',
            'action' => 'CREATE',
            'module' => "Foydalanuvchilar",
            'user' => 'admin',
            'ip' => '192.168.1.10',
            'desc' => "Yangi foydalanuvchi 'Bekzod' qo'shildi",
            'extra' => "Roli: Moderator"
        ],
        [
            'id' => 12,
            'time' => '2025-12-01 17:45:00',
            'level' => 'Ogohlantirish',
            'action' => 'UPDATE',
            'module' => "Foydalanuvchilar",
            'user' => 'ali',
            'ip' => '192.168.1.20',
            'desc' => "Foydalanuvchi 'Javohir' rolini o'zgartirishda ma'lumotlar to'liq emas",
            'extra' => "Status: Incomplete form data"
        ],
        [
            'id' => 13,
            'time' => '2025-12-01 17:30:10',
            'level' => 'Muvaffaqiyatli',
            'action' => 'LOGIN',
            'module' => "Ma'muriyat bo'limi",
            'user' => 'rustam',
            'ip' => '192.168.1.25',
            'desc' => "Tizimga muvaffaqiyatli kirish",
            'extra' => "Platforma: Web, Browser: Firefox"
        ],
        [
            'id' => 14,
            'time' => '2025-12-01 17:28:40',
            'level' => 'Xato',
            'action' => 'LOGIN',
            'module' => "Ma'muriyat bo'limi",
            'user' => 'rustam',
            'ip' => '192.168.1.25',
            'desc' => "Kirish urinishi xatosi: noto'g'ri parol",
            'extra' => "Urinish soni: 3"
        ],
        [
            'id' => 15,
            'time' => '2025-12-01 17:20:00',
            'level' => 'Muvaffaqiyatli',
            'action' => 'VIEW',
            'module' => "Loyihalar",
            'user' => 'anna',
            'ip' => '192.168.1.14',
            'desc' => "Loyiha ro'yxatini ko'rish",
            'extra' => "Filter: Active projects"
        ],
    ]);

    if ($id !== null) {
        return $systemLogs->where('id', $id)->values();
    }
    return $systemLogs;
}


function getNotifications(): Collection
{
    return collect([
        [
            'id' => 1,
            'date' => '2025-12-01 09:14',
            'type' => 'technical',
            'text' => 'Server yuklanishi 85% ga yetdi.',
            'status' => 'unread'
        ],
        [
            'id' => 2,
            'date' => '2025-12-01 10:22',
            'type' => 'request',
            'text' => 'User parolni tiklashni so‘radi.',
            'status' => 'read'
        ],
        [
            'id' => 3,
            'date' => '2025-12-01 11:48',
            'type' => 'error',
            'text' => 'DB Connection Timeout xatosi.',
            'status' => 'unread'
        ],
        [
            'id' => 4,
            'date' => '2025-12-02 08:25',
            'type' => 'technical',
            'text' => 'Tizim yangilanishi yakunlandi.',
            'status' => 'read'
        ],
        [
            'id' => 5,
            'date' => '2025-12-02 12:14',
            'type' => 'request',
            'text' => 'Investor ro‘yxatdan o‘tishga so‘rov yubordi.',
            'status' => 'unread'
        ],
        [
            'id' => 6,
            'date' => '2025-12-03 14:00',
            'type' => 'error',
            'text' => 'To‘lov shlyuzida 502 xato.',
            'status' => 'unread'
        ]
    ]);
}



function getLanguagesData($id = null)
{
    $datas = collect([
        [
            'id' => 1,
            'name' => 'O\'zbek',
            'code' => 'uz',
            'is_active' => true,
            'is_default' => true,
        ],
        [
            'id' => 2,
            'name' => 'Русский',
            'code' => 'ru',
            'is_active' => true,
            'is_default' => false,
        ],
        [
            'id' => 3,
            'name' => 'English',
            'code' => 'en',
            'is_active' => false,
            'is_default' => false,
        ],
        [
            'id' => 4,
            'name' => 'العربية',
            'code' => 'ar',
            'is_active' => false,
            'is_default' => false,

        ]
    ]);

    if ($id !== null) {
        return $datas->where('id', $id)->first();
    }
    return $datas;
}

function renderValue($value, $prefix = '')
{
    if (is_array($value)) {
        $html = '';
        foreach ($value as $k => $v) {
            $html .= renderValue($v, $prefix . $k . '. ');
        }
        return $html;
    }

    return "<div>{$prefix}{$value}</div>";
}


function getNotificationsData($id = null)
{
    $notifications = collect([
        'sms' => [
            [
                'id' => 1,
                'type' => 'Tasdiqlash kodi',
                'template' => 'Hurmatli {FISH}, tizimga kirish uchun tasdiqlash kodingiz: {kod}. Ushbu kod 5 daqiqa davomida amal qiladi.',
                'condition' => "Ro'yxatdan o'tishda",
                'description' => 'Har doim',
                'category' => 'sms'
            ],
            [
                'id' => 2,
                'type' => 'Parol tiklash',
                'template' => 'Hurmatli {FISH}, parolingizni tiklash uchun kod: {kod}. Agar ushbu so\'rovni siz bajarmagan bo\'lsangiz, iltimos, e\'tibor bermang.',
                'condition' => 'Parol unutganda',
                'description' => 'Har doim',
                'category' => 'sms'
            ]
        ],
        'email' => [
            [
                'id' => 3,
                'type' => "Ro'yxatdan o'tish",
                'template' => "Assalomu alaykum, {FISH}! \n\nSizning ro'yxatdan o'tish jarayoningiz muvaffaqiyatli yakunlandi. Profilingiz faollashtirildi. \n\nHurmat bilan, Administratsiya.",
                'condition' => "Ro'yxatdan o'tishda",
                'description' => 'Har doim',
                'category' => 'email'
            ]
        ],
        'push' => [
            [
                'id' => 4,
                'type' => 'Yangilik xabari',
                'template' => '{FISH}, siz uchun yangi yangilik mavjud! Batafsil ko\'ring.',
                'condition' => 'Yangilik e\'loni',
                'description' => 'Push xabari',
                'category' => 'push'
            ],
            [
                'id' => 5,
                'type' => 'Reklama xabari',
                'template' => '{FISH}, siz uchun maxsus aksiya boshlandi! Shoshiling!',
                'condition' => 'Promo paytida',
                'description' => 'Push xabari',
                'category' => 'push'
            ]
        ]
    ]);

    // Barcha notificationlarni bitta array ga birlashtirish
    $allNotifications = collect();
    foreach ($notifications as $category => $items) {
        $allNotifications = $allNotifications->merge($items);
    }

    // Agar ID berilsa, shu ID ga mos notificationni qaytarish
    if ($id !== null) {
        return $allNotifications->firstWhere('id', $id);
    }

    // ID berilmasa, barchasini qaytarish
    return $allNotifications;
}



function getMediaItems($id = null)
{
    $datas = collect([
        [
            'id' => 1,
            'title' => 'Kompaniya logotipi',
            'description' => 'Platformaning asosiy brend logotipi.',
            'type' => 'LOGO',
            'image_url' => 'https://i.pinimg.com/736x/aa/7b/ab/aa7bab4df90c1d86cc205f237eb8a847.jpg'
        ],
        [
            'id' => 2,
            'title' => 'Bosh sahifa banneri',
            'description' => 'Marketing va vizual ko\'rinish uchun banner rasmi.',
            'type' => 'BANNER',
            'image_url' => 'https://img.freepik.com/premium-photo/vintage-camera-parts-black-fabric-background-flat-lay-composition-aig55_31965-690491.jpg?semt=ais_hybrid&w=740'
        ],
        [
            'id' => 3,
            'title' => 'Login fon rasmi',
            'description' => 'Login sahifasi uchun fon tasviri.',
            'type' => 'AUTH',
            'image_url' => 'https://www.ema-eda.com/wp-content/uploads/2023/12/datamanagement_web.jpg'
        ]
    ]);

    if ($id !== null) {
        return $datas->where('id', $id)->first();
    }

    return $datas;
}

function getStaticPages($id = null)
{
    $datas = collect([
        [
            'id' => 1,
            'title' => 'Biz haqimizda',
            'description' => '«Envast» platformasi – bu koʻchmas mulkka halol va ulushli investitsiyalarni amalga oshirish uchun yaratilgan raqamli axborot tizimidir. Platforma investorlarga ulushli moliyalashtirish asosida loyihalarda ishtirok etish, investitsiya shartlarini kuzatish va daromad taqsimotini onlayn nazorat qilish imkonini beradi. «Envast» platformasi Islom moliyasi qoidalari hamda Oʻzbekiston Respublikasi qonunchilik meʼyorlari asosida faoliyat yuritadi. Bizning maqsadimiz – investitsiya jarayonini shaffof, xavfsiz va qulay raqamli muhitda tashkil etishdir.'
        ],
        [
            'id' => 2,
            'title' => 'Aloqa uchun',
            'description' => "Agar siz «Envast» platformasi bilan bogʻlanmoqchi boʻlsangiz, quyidagi manzillar orqali murojaat qilishingiz mumkin:\n\nElektron pochta: support@envast.uz\nTelefon: +998 71 123 45 67\nManzil: Toshkent sh., Mustaqillik ko'chasi, 10-uy"
        ],
        [
            'id' => 3,
            'title' => 'Foydalanish shartlari',
            'description' => "«Envast» platformasidan foydalanish quyidagi shartlarga bogʻliq:\n1. Platformaga roʻyxatdan oʻtish va KYC (Know Your Customer) jarayonini toʻliq yakunlash.\n2. Investitsiya loyihalarini tanlash, ularga mablagʻ yoʻnaltirish va foyda ulushini kuzatish.\n3. Platformadagi shartnomalar va moliyaviy hisobotlarni hurmat qilish.\n4. Oʻz ulushingizni sotish yoki chiqarib olish jarayonlarini faqat belgilangan qoidalar asosida amalga oshirish.\n5. Platformadan foydalanish davomida qonun va Islom moliyasi tamoyillariga rioya qilish."
        ]
    ]);

    if ($id !== null) {
        return $datas->where('id', $id)->first();
    }

    return $datas;
}
