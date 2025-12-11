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
                'phone' => '+998901234567',
                'passport' => 'AA1234567',
                'inn' => '12345678901234',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-25 14:32'
            ],
            [
                'id' => 2,
                'name' => 'Gulbahor Qodirova',
                'username' => 'gulbahor',
                'phone' => '+998909876543',
                'passport' => 'AB7654321',
                'inn' => '98765432109876',
                'status' => 'Kutilmoqda',
                'verification_status' => 'Tasdiqlanmagan',
                'created_at' => '2025-11-26 09:15'
            ],
            [
                'id' => 3,
                'name' => 'Olimjon Tursunov',
                'username' => 'olimjon',
                'phone' => '+998933445566',
                'passport' => 'AC1122334',
                'inn' => '11223344556677',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-27 08:50'
            ],
            [
                'id' => 4,
                'name' => 'Nilufar Rasulova',
                'username' => 'nilufar',
                'phone' => '+998922334455',
                'passport' => 'AD5566778',
                'inn' => '55667788901234',
                'status' => 'Bloklangan',
                'verification_status' => 'Tasdiqlanmagan',
                'created_at' => '2025-11-24 18:20'
            ],
            [
                'id' => 5,
                'name' => 'Azizbek Karimov',
                'username' => 'azizbek',
                'phone' => '+998911223344',
                'passport' => 'AA9988776',
                'inn' => '99887766554433',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-26 12:45'
            ],
            [
                'id' => 6,
                'name' => 'Saodat Davronova',
                'username' => 'saodat',
                'phone' => '+998900112233',
                'passport' => 'AB4455667',
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
                'phone' => '+998909998877',
                'passport' => 'AC5544332',
                'inn' => '55443322110099',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-21 17:33'
            ],
            [
                'id' => 9,
                'name' => 'Sirojiddin Bekmurodov',
                'username' => 'siroj',
                'phone' => '+998900011223',
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
                'phone' => '+998933301122',
                'passport' => 'AA8899007',
                'inn' => '88990077665544',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-19 08:12'
            ],
            [
                'id' => 11,
                'name' => 'Madina Usmonova',
                'username' => 'madina',
                'phone' => '+998930045612',
                'passport' => 'AB1122994',
                'inn' => '11229944556677',
                'status' => 'Bloklangan',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-18 19:55'
            ],
            [
                'id' => 12,
                'name' => 'Jamshid Soliyev',
                'username' => 'jamshid',
                'phone' => '+998950033221',
                'passport' => 'AC7788112',
                'inn' => '77881122334455',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-17 16:40'
            ],
            [
                'id' => 13,
                'name' => 'Shohjahon Abdullayev',
                'username' => 'shoh',
                'phone' => '+998977712345',
                'passport' => 'AD6677885',
                'inn' => '66778855332211',
                'status' => 'Faol',
                'verification_status' => 'Tasdiqlangan',
                'created_at' => '2025-11-16 10:27'
            ],
            [
                'id' => 14,
                'name' => 'Hilola Qodirova',
                'username' => 'hilola',
                'phone' => '+998934455667',
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
                'phone' => '+998990112233',
                'passport' => 'AA4455667',
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
        'projects' => getProjectsTab(),
        'revenues' => getRevenuesTab(),
        'incomes' => getIncomesTab(),
        'expenses' => getExpensesTab(),
        'distributions' => getDistributionsTab(),
        'contracts' => getContractsTab(),
        'reports' => getReportsTab(),
        'islamic' => getIslamicTab(),
        'settings' => getSettingsTab(),
        'administration' => getAdministrationTab(),
        'notifications' => getNotificationsTab()
    ]);
}


/**
 * Tablar ro'yxati
 */
function getTabs(): Collection
{
    return collect([
        ['id' => 'menus', 'name' => 'Menyular', 'icon' => 'list'],
        ['id' => 'projects', 'name' => 'Investitsiya loyihalari', 'icon' => 'building'],
        ['id' => 'revenues', 'name' => 'Tushumlar', 'icon' => 'currency-dollar'],
        ['id' => 'incomes', 'name' => 'Daromadlar', 'icon' => 'wallet2'],
        ['id' => 'expenses', 'name' => 'Xarajatlar', 'icon' => 'cash-stack'],
        ['id' => 'distributions', 'name' => 'Taqsimot', 'icon' => 'diagram-3'],
        ['id' => 'contracts', 'name' => 'Investitsiya shartnomalar', 'icon' => 'file-earmark-text'],
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
        ['id' => 2, 'name' => 'Investitsiya loyihalari', 'icon' => 'building', 'checked' => true],
        ['id' => 3, 'name' => 'Tushumlar', 'icon' => 'currency-dollar', 'checked' => true],
        ['id' => 4, 'name' => 'Daromadlar', 'icon' => 'wallet2', 'checked' => true],
        ['id' => 5, 'name' => 'Xarajatlar', 'icon' => 'cash-stack', 'checked' => true],
        ['id' => 6, 'name' => 'Taqsimot', 'icon' => 'diagram-3', 'checked' => true],
        ['id' => 7, 'name' => 'Investitsiya shartnomalar', 'icon' => 'file-earmark-text', 'checked' => true],
        ['id' => 8, 'name' => 'Hisobotlar', 'icon' => 'bar-chart-line', 'checked' => true],
        ['id' => 9, 'name' => 'Islom moliyasi', 'icon' => 'shield-check', 'checked' => true],
        ['id' => 10, 'name' => 'Sozlamalar', 'icon' => 'gear', 'checked' => true],
        ['id' => 11, 'name' => 'Ma\'muriyat', 'icon' => 'grid-3x3-gap', 'checked' => true],
        ['id' => 12, 'name' => 'Bildirishnomalar', 'icon' => 'bell', 'checked' => true]
    ]);
}

/**
 * INVESTITSIYA LOYIHALARI tab ma'lumotlari
 */
function getProjectsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Loyihalar ro\'yxati', 'route' => 'admin.projects.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Loyiha yaratish', 'route' => 'admin.projects.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Loyihani tahrirlash', 'route' => 'admin.projects.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Loyihani o\'chirish', 'route' => 'admin.projects.destroy', 'method' => 'default', 'checked' => false],
        ['id' => 5, 'name' => 'Loyiha investorlar ro\'yxati', 'route' => 'admin.project-investors.index', 'method' => 'default', 'checked' => false],
        ['id' => 6, 'name' => 'Loyiha investor yaratish', 'route' => 'admin.project-investors.create', 'method' => 'default', 'checked' => false],
        ['id' => 7, 'name' => 'Loyiha sotib olganlar', 'route' => 'admin.project-buyers.index', 'method' => 'default', 'checked' => false],
        ['id' => 8, 'name' => 'Ulushga kirish so\'rovlari', 'route' => 'admin.project-entry-requests.index', 'method' => 'default', 'checked' => false],
        ['id' => 9, 'name' => 'Ulushdan chiqish so\'rovlari', 'route' => 'admin.project-exit-requests.index', 'method' => 'default', 'checked' => false],
        ['id' => 10, 'name' => 'Korxona rekvizitlari', 'route' => 'admin.company-details.index', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * TUSHUMLAR tab ma'lumotlari
 */
function getRevenuesTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Tushumlar ro\'yxati', 'route' => 'admin.revenues.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Tushum qo\'shish', 'route' => 'admin.revenues.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Tushumni tahrirlash', 'route' => 'admin.revenues.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Tushumni o\'chirish', 'route' => 'admin.revenues.destroy', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * DAROMADLAR tab ma'lumotlari
 */
function getIncomesTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Daromadlar ro\'yxati', 'route' => 'admin.incomes.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Daromad qo\'shish', 'route' => 'admin.incomes.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Daromadni tahrirlash', 'route' => 'admin.incomes.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Daromadni o\'chirish', 'route' => 'admin.incomes.destroy', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * XARAJATLAR tab ma'lumotlari
 */
function getExpensesTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Xarajatlar ro\'yxati', 'route' => 'admin.expenses.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Xarajat qo\'shish', 'route' => 'admin.expenses.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Xarajatni tahrirlash', 'route' => 'admin.expenses.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Xarajatni o\'chirish', 'route' => 'admin.expenses.destroy', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * TAQSIMOT tab ma'lumotlari
 */
function getDistributionsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Taqsimotlar ro\'yxati', 'route' => 'admin.distributions.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Taqsimot yaratish', 'route' => 'admin.distributions.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Taqsimotni tahrirlash', 'route' => 'admin.distributions.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Taqsimotni o\'chirish', 'route' => 'admin.distributions.destroy', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * INVESTITSIYA SHARTNOMALAR tab ma'lumotlari
 */
function getContractsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Shartnomalar ro\'yxati', 'route' => 'admin.investment-contracts.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Shartnoma yaratish', 'route' => 'admin.investment-contracts.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Shartnomani tahrirlash', 'route' => 'admin.investment-contracts.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Shartnomani o\'chirish', 'route' => 'admin.investment-contracts.destroy', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * HISOBOTLAR tab ma'lumotlari
 */
function getReportsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Hisobotlar ro\'yxati', 'route' => 'admin.reports.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Hisobot yaratish', 'route' => 'admin.reports.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Hisobotni tahrirlash', 'route' => 'admin.reports.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Hisobotni o\'chirish', 'route' => 'admin.reports.destroy', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * ISLOM MOLIYASI tab ma'lumotlari
 */
function getIslamicTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Islom moliyasi ro\'yxati', 'route' => 'admin.islamic-finance.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Nazorat qo\'shish', 'route' => 'admin.islamic-finance.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Nazoratni tahrirlash', 'route' => 'admin.islamic-finance.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Nazoratni o\'chirish', 'route' => 'admin.islamic-finance.destroy', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * SOZLAMALAR tab ma'lumotlari
 */
function getSettingsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Ma\'lumotnomalar', 'route' => 'admin.references.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Umumiy sozlamalar', 'route' => 'admin.general-settings.index', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Integratsiya sozlamalari', 'route' => 'admin.integration-settings.index', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Foydalanuvchi interfeysi', 'route' => 'admin.user-interface.index', 'method' => 'default', 'checked' => false],
        ['id' => 5, 'name' => 'Til boshqaruvi', 'route' => 'admin.user-interface.language-management.index', 'method' => 'default', 'checked' => false],
        ['id' => 6, 'name' => 'Tizim tarjimalari', 'route' => 'admin.user-interface.system-translations.index', 'method' => 'default', 'checked' => false],
        ['id' => 7, 'name' => 'Shablon xabarlari', 'route' => 'admin.user-interface.template-messages.index', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * MA'MURIYAT tab ma'lumotlari
 */
function getAdministrationTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Foydalanuvchilar ro\'yxati', 'route' => 'admin.users.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Foydalanuvchi yaratish', 'route' => 'admin.users.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Foydalanuvchini tahrirlash', 'route' => 'admin.users.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Foydalanuvchini o\'chirish', 'route' => 'admin.users.destroy', 'method' => 'default', 'checked' => false],
        ['id' => 5, 'name' => 'Investorlar ro\'yxati', 'route' => 'admin.investors.index', 'method' => 'default', 'checked' => false],
        ['id' => 6, 'name' => 'Investor yaratish', 'route' => 'admin.investors.create', 'method' => 'default', 'checked' => false],
        ['id' => 7, 'name' => 'Rollar ro\'yxati', 'route' => 'admin.roles.index', 'method' => 'default', 'checked' => false],
        ['id' => 8, 'name' => 'Rol yaratish', 'route' => 'admin.roles.create', 'method' => 'default', 'checked' => false],
        ['id' => 9, 'name' => 'Login tarixi', 'route' => 'admin.login-histories.index', 'method' => 'default', 'checked' => false],
        ['id' => 10, 'name' => 'Tizim loglar', 'route' => 'admin.system-logs.index', 'method' => 'default', 'checked' => false]
    ]);
}

/**
 * BILDIRISHNOMALAR tab ma'lumotlari
 */
function getNotificationsTab(): Collection
{
    return collect([
        ['id' => 1, 'name' => 'Bildirishnomalar ro\'yxati', 'route' => 'admin.notifications.index', 'method' => 'default', 'checked' => false],
        ['id' => 2, 'name' => 'Bildirishnoma yaratish', 'route' => 'admin.notifications.create', 'method' => 'default', 'checked' => false],
        ['id' => 3, 'name' => 'Bildirishnomani tahrirlash', 'route' => 'admin.notifications.edit', 'method' => 'default', 'checked' => false],
        ['id' => 4, 'name' => 'Bildirishnomani o\'chirish', 'route' => 'admin.notifications.destroy', 'method' => 'default', 'checked' => false]
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
