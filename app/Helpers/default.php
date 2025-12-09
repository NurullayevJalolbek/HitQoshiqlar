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
