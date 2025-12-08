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
