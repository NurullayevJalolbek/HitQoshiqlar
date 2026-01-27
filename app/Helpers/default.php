<?php

use App\Models\Music;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;




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

function getRequest($request = null)
{
    return $request ?? request();
}


function formatCurrency($number, $decimal = 0)
{
    if (is_null($number)) {
        return 0;
    }

    $decimal = strlen(explode('.', (string) $number)[1] ?? '');

    return number_format($number, $decimal, '.', ' ');
}




if (!function_exists('sendMessage')) {
    function sendMessage($chat_id, $message, $token,  $message_id = null)
    {
        if (!$token) {
            Log::error("Telegram token bo'sh! Check config/services.php and .env");
            return false;
        }

        // Agar $message_id kelgan bo'lsa, avval eski xabarni o'chirish
        if ($message_id) {
            Http::withOptions(['verify' => false])->post(
                "https://api.telegram.org/bot{$token}/deleteMessage",
                [
                    'chat_id' => $chat_id,
                    'message_id' => $message_id
                ]
            );
        }

        // Yangi xabar yuborish
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        Http::withOptions(['verify' => false])->post($url, [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);
    }
}

if (!function_exists('sendCachedMusicOrLoading')) {
    function sendCachedMusicOrLoading($chat_id, $message_id, $videoId, $sendAudioUrl, $token)
    {
        $keyboardM = [
            'inline_keyboard' => [
                [
                    [
                        'text' => '❌',
                        'callback_data' => 'clear'
                    ]
                ]
            ]
        ];

        $music = Music::where('yt_id', $videoId)->first();

        if ($music && $music->file_id) {

            $resp = Http::post($sendAudioUrl, [
                'chat_id' => $chat_id,
                'reply_to_message_id' => (int) $message_id,
                'audio' => $music->file_id,
                'reply_markup' => json_encode($keyboardM),
                'title' => mb_substr($music->title ?? 'Music', 0, 64),
                'performer' => mb_substr($music->artist ?? 'Unknown', 0, 64),
                'caption' => "@HitQoshiqlarBot"
            ]);
            return [
                'cached' => true,
                'response' => $resp,
            ];
        }

        $resp = Http::post("https://api.telegram.org/bot{$token}/sendSticker", [
            'chat_id' => $chat_id,
            'sticker' => 'CAACAgIAAxkBAAFA0aRpa2vWmXn4LAH4SqpWHtUD4opzDwACH4oAAnh1WEs-8AcZvvu0VDgE',
        ])->json();



        return [
            'cached' => false,
            'response' => $resp,
        ];
    }
}

if (!function_exists('normalizeQuery')) {

    function normalizeQuery(string $q): string
    {
        $q = mb_strtolower($q, 'UTF-8');
        $q = str_replace(["’", "‘", "`", "´", "ʻ", "ʼ", "′"], "'", $q);
        $q = str_replace("'", "", $q);
        $q = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $q);
        $q = preg_replace('/\s+/u', ' ', $q);

        return trim($q);
    }
}


if (!function_exists('buildHeightChoices')) {


    function buildHeightChoices(array $formats): array
    {
        $best = [];

        foreach ($formats as $f) {
            if (($f['vcodec'] ?? 'none') === 'none') continue;

            $h = (int)($f['height'] ?? 0);
            if ($h <= 0) continue;

            $id = (string)($f['format_id'] ?? '');
            if ($id === '') continue;

            $score = (float)($f['tbr'] ?? 0);

            if (!isset($best[$h]) || $score > $best[$h]['score']) {
                $best[$h] = [
                    'id' => $id,
                    'label' => "{$h}p",
                    'score' => $score,
                ];
            }
        }

        ksort($best); // 144p → 2160p

        return array_values(array_map(static function ($x) {
            return [
                'id' => $x['id'],
                'label' => $x['label'],
            ];
        }, $best));
    }
}


if (!function_exists('sendStartWithButtons')) {
    function sendStartWithButtons($chat_id, $text, $token, $keyboard, $message_id = null)
    {
        if (!$token) {
            Log::error("Telegram token bo'sh! Check config/services.php and .env");
            return false;
        }

        $payload = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($keyboard)
        ];

        $method = "sendMessage";
        if (!is_null($message_id)) {
            $payload['message_id'] = $message_id;
            $method = "editMessageText";
        }

        Http::withOptions(['verify' => false])->post(
            "https://api.telegram.org/bot{$token}/{$method}",
            $payload
        );
    }
}

if (!function_exists('buildLanguageKeyboard')) {



    function buildLanguageKeyboard($selected)
    {
        $languages = [
            'uz' => '🇺🇿 Uz',
            'ru' => '🇷🇺 Ру',
            'en' => '🇬🇧 Eng',
        ];

        $keyboard = [];

        foreach ($languages as $code => $label) {
            $text = $label;
            if ($code === $selected) {
                $text .= " ✅";
            }

            $keyboard[] = [
                'text' => $text,
                'callback_data' => $code
            ];
        }

        return [
            'inline_keyboard' => [
                $keyboard
            ]
        ];
    }
}


if (!function_exists('answerTelegramCallback')) {
    function answerTelegramCallback($callback_id, $text, $token,  $showAlert = false)
    {
        if (!$token) {
            Log::error("Telegram token missing in answerTelegramCallback");
            return false;
        }

        return Http::withOptions(['verify' => false])->post(
            "https://api.telegram.org/bot{$token}/answerCallbackQuery",
            [
                'callback_query_id' => $callback_id,
                'text' => $text,
                'show_alert' => $showAlert
            ]
        );
    }
}
if (!function_exists('sendPhotoMessage')) {
    function sendPhotoMessage($chat_id, $photo, $caption, $token, $reply_markup = null)
    {
        if (!$token) {
            Log::error("Telegram token bo'sh!");
            return false;
        }

        $url = "https://api.telegram.org/bot{$token}/sendPhoto";

        // Agar file_id bo‘lsa (Telegram ID)
        if (is_string($photo) && !str_contains($photo, '/')) {
            $payload = [
                'chat_id' => $chat_id,
                'photo' => $photo, // 👈 file_id
                'caption' => $caption,
                'parse_mode' => 'HTML',
            ];

            if ($reply_markup) {
                $payload['reply_markup'] = json_encode($reply_markup, JSON_UNESCAPED_UNICODE);
            }

            $res = Http::post($url, $payload);
        }

        Log::info("sendPhotoMessage response", [
            'ok' => $res->ok(),
            'status' => $res->status(),
            'body' => $res->json(),
        ]);

        return $res->ok();
    }
}


if (!function_exists('isSocialMediaUrl')) {


    function isSocialMediaUrl(string $message): bool
    {
        $patterns = [
            '/(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//i',
            '/(https?:\/\/)?(www\.)?instagram\.com\//i',
            '/(https?:\/\/)?(www\.)?tiktok\.com\//i',
            '/(https?:\/\/)?(www\.)?likee\.video\//i',
            '/(https?:\/\/)?(www\.)?snapchat\.com\//i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return true;
            }
        }

        return false;
    }
}


function isInstagram(string $host): bool
{
    return str_ends_with($host, 'instagram.com');
}

function isYoutube(string $host): bool
{
    return in_array($host, [
        'youtube.com',
        'www.youtube.com',
        'm.youtube.com',
        'youtu.be'
    ]);
}

function isTikTok(string $host): bool
{
    return str_ends_with($host, 'tiktok.com');
}

function isFacebook(string $host): bool
{
    return in_array($host, [
        'facebook.com',
        'www.facebook.com',
        'm.facebook.com',
        'fb.watch'
    ]);
}

function isSnapchat(string $host): bool
{
    return str_ends_with($host, 'snapchat.com');
}

function isLikee(string $host): bool
{
    return str_ends_with($host, 'likee.video');
}



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

function getIntegrationSettings($id = null)
{
    $integrations = collect([
        // 1. SMS Xizmati (Eskiz)
        [
            'id' => 1,
            'name' => 'SMS Xizmati (Eskiz)',
            'status' => true,
            'category' => 'sms',
            'icon' => 'fas fa-sms',
            'required_fields' => ['api', 'token', 'password'],
            'fields_config' => [
                'api' => [
                    'type' => 'url',
                    'required' => true,
                    'label' => 'API URL',
                    'placeholder' => 'https://api.eskiz.uz',
                    'icon' => 'fas fa-link'
                ],
                'token' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'API Token',
                    'placeholder' => 'Eskiz token kaliti',
                    'icon' => 'fas fa-key'
                ],
                'password' => [
                    'type' => 'password',
                    'required' => true,
                    'label' => 'SMS Paroli',
                    'placeholder' => 'SMS xizmat paroli',
                    'icon' => 'fas fa-lock'
                ],
                'sender' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'Jo\'natuvchi Raqam/Nomi',
                    'placeholder' => 'Masalan: 1234 yoki UzCard',
                    'icon' => 'fas fa-user'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'placeholder' => 'SMS xizmati haqida qisqacha izoh...',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 2. Payme To'lov Tizimi
        [
            'id' => 2,
            'name' => 'Payme To\'lov Tizimi',
            'status' => false,
            'category' => 'payment',
            'icon' => 'fas fa-credit-card',
            'required_fields' => ['api', 'secret_key', 'merchant_id'],
            'fields_config' => [
                'api' => [
                    'type' => 'url',
                    'required' => true,
                    'label' => 'API URL',
                    'placeholder' => 'https://api.payme.uz',
                    'icon' => 'fas fa-link'
                ],
                'merchant_id' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Merchant ID',
                    'placeholder' => 'Payme merchant identifikatori',
                    'icon' => 'fas fa-id-badge'
                ],
                'secret_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Secret Key',
                    'placeholder' => 'Payme maxfiy kaliti',
                    'icon' => 'fas fa-key'
                ],
                'checkout_url' => [
                    'type' => 'url',
                    'required' => true,
                    'label' => 'Checkout URL',
                    'placeholder' => 'https://checkout.payme.uz',
                    'icon' => 'fas fa-shopping-cart'
                ],
                'callback_url' => [
                    'type' => 'url',
                    'required' => false,
                    'label' => 'Callback URL',
                    'placeholder' => 'https://sizning-saytingiz.uz/payme/callback',
                    'icon' => 'fas fa-redo'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 3. Click To'lov Tizimi
        [
            'id' => 3,
            'name' => 'Click To\'lov Tizimi',
            'status' => true,
            'category' => 'payment',
            'icon' => 'fas fa-money-check-alt',
            'required_fields' => ['api', 'secret_key', 'service_id', 'merchant_id'],
            'fields_config' => [
                'api' => [
                    'type' => 'url',
                    'required' => true,
                    'label' => 'API URL',
                    'placeholder' => 'https://api.click.uz',
                    'icon' => 'fas fa-link'
                ],
                'service_id' => [
                    'type' => 'number',
                    'required' => true,
                    'label' => 'Service ID',
                    'placeholder' => 'Click service ID',
                    'icon' => 'fas fa-hashtag'
                ],
                'merchant_id' => [
                    'type' => 'number',
                    'required' => true,
                    'label' => 'Merchant ID',
                    'placeholder' => 'Click merchant ID',
                    'icon' => 'fas fa-store'
                ],
                'secret_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Secret Key',
                    'placeholder' => 'Click maxfiy kaliti',
                    'icon' => 'fas fa-key'
                ],
                'user_id' => [
                    'type' => 'number',
                    'required' => false,
                    'label' => 'User ID',
                    'placeholder' => 'Foydalanuvchi ID',
                    'icon' => 'fas fa-user'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 4. Visa Online Payments
        [
            'id' => 4,
            'name' => 'Visa Online Payments',
            'status' => false,
            'category' => 'payment',
            'icon' => 'fab fa-cc-visa',
            'required_fields' => ['api', 'secret_key', 'merchant_id'],
            'fields_config' => [
                'api' => [
                    'type' => 'url',
                    'required' => true,
                    'label' => 'API URL',
                    'placeholder' => 'https://api.visa.com',
                    'icon' => 'fas fa-link'
                ],
                'merchant_id' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Merchant ID',
                    'placeholder' => 'VISA merchant identifikatori',
                    'icon' => 'fas fa-id-badge'
                ],
                'secret_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Secret Key',
                    'placeholder' => 'VISA maxfiy kaliti',
                    'icon' => 'fas fa-key'
                ],
                'public_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Public Key',
                    'placeholder' => 'VISA ochiq kaliti',
                    'icon' => 'fas fa-key'
                ],
                'currency' => [
                    'type' => 'select',
                    'required' => true,
                    'label' => 'Valyuta',
                    'options' => ['USD' => 'USD', 'UZS' => 'UZS', 'EUR' => 'EUR'],
                    'icon' => 'fas fa-money-bill-wave'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 5. Mastercard Online Payments
        [
            'id' => 5,
            'name' => 'Mastercard Online Payments',
            'status' => false,
            'category' => 'payment',
            'icon' => 'fab fa-cc-mastercard',
            'required_fields' => ['api', 'secret_key', 'merchant_id'],
            'fields_config' => [
                'api' => [
                    'type' => 'url',
                    'required' => true,
                    'label' => 'API URL',
                    'placeholder' => 'https://api.mastercard.com',
                    'icon' => 'fas fa-link'
                ],
                'merchant_id' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Merchant ID',
                    'placeholder' => 'Mastercard merchant identifikatori',
                    'icon' => 'fas fa-id-badge'
                ],
                'secret_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Secret Key',
                    'placeholder' => 'Mastercard maxfiy kaliti',
                    'icon' => 'fas fa-key'
                ],
                'public_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Public Key',
                    'placeholder' => 'Mastercard ochiq kaliti',
                    'icon' => 'fas fa-key'
                ],
                'currency' => [
                    'type' => 'select',
                    'required' => true,
                    'label' => 'Valyuta',
                    'options' => ['USD' => 'USD', 'UZS' => 'UZS', 'EUR' => 'EUR'],
                    'icon' => 'fas fa-money-bill-wave'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 6. Email SMTP (Gmail)
        [
            'id' => 6,
            'name' => 'Email SMTP (Gmail)',
            'status' => true,
            'category' => 'email',
            'icon' => 'fas fa-envelope',
            'required_fields' => ['host', 'port', 'username', 'password'],
            'fields_config' => [
                'host' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'SMTP Server',
                    'placeholder' => 'smtp.gmail.com',
                    'icon' => 'fas fa-server'
                ],
                'port' => [
                    'type' => 'number',
                    'required' => true,
                    'label' => 'Port',
                    'placeholder' => '587',
                    'icon' => 'fas fa-plug'
                ],
                'username' => [
                    'type' => 'email',
                    'required' => true,
                    'label' => 'Email Manzil',
                    'placeholder' => 'example@gmail.com',
                    'icon' => 'fas fa-envelope'
                ],
                'password' => [
                    'type' => 'password',
                    'required' => true,
                    'label' => 'App Password',
                    'placeholder' => 'Google app paroli',
                    'icon' => 'fas fa-lock'
                ],
                'encryption' => [
                    'type' => 'select',
                    'required' => false,
                    'label' => 'Shifrlash',
                    'options' => ['tls' => 'TLS', 'ssl' => 'SSL', 'none' => 'Yo\'q'],
                    'icon' => 'fas fa-shield-alt'
                ],
                'from_address' => [
                    'type' => 'email',
                    'required' => true,
                    'label' => 'Jo\'natuvchi Email',
                    'placeholder' => 'noreply@sizning-saytingiz.uz',
                    'icon' => 'fas fa-paper-plane'
                ],
                'from_name' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'Jo\'natuvchi Nomi',
                    'placeholder' => 'Sizning Kompaniya Nomi',
                    'icon' => 'fas fa-user'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 7. Firebase Push Notification
        [
            'id' => 7,
            'name' => 'Firebase Push Notification',
            'status' => false,
            'category' => 'notification',
            'icon' => 'fab fa-firebase',
            'required_fields' => ['api_key', 'project_id'],
            'fields_config' => [
                'project_id' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Project ID',
                    'placeholder' => 'Firebase loyiha ID',
                    'icon' => 'fas fa-project-diagram'
                ],
                'api_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Server API Key',
                    'placeholder' => 'Firebase server API kaliti',
                    'icon' => 'fas fa-key'
                ],
                'sender_id' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'Sender ID',
                    'placeholder' => 'FCM sender ID',
                    'icon' => 'fas fa-id-card'
                ],
                'app_id' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'App ID',
                    'placeholder' => 'Firebase app ID',
                    'icon' => 'fas fa-mobile-alt'
                ],
                'database_url' => [
                    'type' => 'url',
                    'required' => false,
                    'label' => 'Database URL',
                    'placeholder' => 'https://your-project.firebaseio.com',
                    'icon' => 'fas fa-database'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 8. Google Maps API
        [
            'id' => 8,
            'name' => 'Google Maps API',
            'status' => true,
            'category' => 'maps',
            'icon' => 'fas fa-map-marked-alt',
            'required_fields' => ['api_key'],
            'fields_config' => [
                'api_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'API Key',
                    'placeholder' => 'Google Maps API kaliti',
                    'icon' => 'fas fa-key'
                ],
                'api_url' => [
                    'type' => 'url',
                    'required' => false,
                    'label' => 'API URL',
                    'placeholder' => 'https://maps.googleapis.com/maps/api',
                    'icon' => 'fas fa-link'
                ],
                'default_lat' => [
                    'type' => 'number',
                    'required' => false,
                    'label' => 'Standart Latitude',
                    'placeholder' => '41.311081',
                    'step' => '0.000001',
                    'icon' => 'fas fa-globe-asia'
                ],
                'default_lng' => [
                    'type' => 'number',
                    'required' => false,
                    'label' => 'Standart Longitude',
                    'placeholder' => '69.240562',
                    'step' => '0.000001',
                    'icon' => 'fas fa-globe-americas'
                ],
                'zoom_level' => [
                    'type' => 'number',
                    'required' => false,
                    'label' => 'Standart Zoom Darajasi',
                    'placeholder' => '12',
                    'min' => 1,
                    'max' => 20,
                    'icon' => 'fas fa-search-plus'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 9. Google Analytics
        [
            'id' => 9,
            'name' => 'Google Analytics',
            'status' => true,
            'category' => 'analytics',
            'icon' => 'fas fa-chart-line',
            'required_fields' => ['tracking_id'],
            'fields_config' => [
                'tracking_id' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Tracking ID',
                    'placeholder' => 'UA-XXXXXXXXX-X yoki G-XXXXXXXXXX',
                    'icon' => 'fas fa-barcode'
                ],
                'measurement_id' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'Measurement ID',
                    'placeholder' => 'G-XXXXXXXXXX',
                    'icon' => 'fas fa-ruler'
                ],
                'property_id' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'Property ID',
                    'placeholder' => 'GA4 property ID',
                    'icon' => 'fas fa-building'
                ],
                'api_secret' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'API Secret',
                    'placeholder' => 'Measurement Protocol API secret',
                    'icon' => 'fas fa-key'
                ],
                'view_id' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'View ID (UA)',
                    'placeholder' => 'Universal Analytics view ID',
                    'icon' => 'fas fa-eye'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],

        // 10. MyId Tizimi
        [
            'id' => 10,
            'name' => 'MyId Tizimi',
            'status' => true,
            'category' => 'auth',
            'icon' => 'fas fa-id-card-alt',
            'required_fields' => ['api', 'client_id', 'secret_key', 'redirect_uri'],
            'fields_config' => [
                'api' => [
                    'type' => 'url',
                    'required' => true,
                    'label' => 'API URL',
                    'placeholder' => 'https://api.myid.uz',
                    'icon' => 'fas fa-link'
                ],
                'client_id' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Client ID',
                    'placeholder' => 'MyId client identifikatori',
                    'icon' => 'fas fa-id-card'
                ],
                'secret_key' => [
                    'type' => 'text',
                    'required' => true,
                    'label' => 'Client Secret',
                    'placeholder' => 'MyId maxfiy kaliti',
                    'icon' => 'fas fa-key'
                ],
                'redirect_uri' => [
                    'type' => 'url',
                    'required' => true,
                    'label' => 'Redirect URI',
                    'placeholder' => 'https://sizning-saytingiz.uz/auth/myid/callback',
                    'icon' => 'fas fa-redo'
                ],
                'scope' => [
                    'type' => 'text',
                    'required' => false,
                    'label' => 'Scope',
                    'default' => 'openid profile phone email',
                    'placeholder' => 'openid profile phone email',
                    'icon' => 'fas fa-list'
                ],
                'description' => [
                    'type' => 'textarea',
                    'required' => false,
                    'label' => 'Tavsif',
                    'icon' => 'fas fa-align-left'
                ]
            ]
        ],
    ]);

    if ($id !== null) {
        return $integrations->where('id', $id)->first();
    }

    return $integrations;
}


function getSEOSettings($page = null)
{
    $seoSettings = collect([
        'general' => [
            'name' => 'Umumiy SEO Sozlamalari',
            'title' => 'Envast - Investitsiya Platformasi',
            'keywords' => 'Envast, investitsiya, ko\'chmas mulk, Islom moliyasi, ulushli moliyalashtirish, halol investitsiya, raqamli platforma, onlayn investitsiya, Shariat moliyasi',
            'description' => 'Envast - ko\'chmas mulkka halol va ulushli investitsiyalarni amalga oshirish uchun yaratilgan raqamli platforma. Investorlar investitsiya jarayonini onlayn nazorat qilish imkoniyatiga ega.',
            'type' => 'general',
            'key' => 'general',
            'icon' => 'fa-globe'
        ],
        'home' => [
            'name' => 'Asosiy Sahifa SEO Sozlamalari',
            'title' => 'Envast | Investitsiya Platformasi',
            'keywords' => 'asosiy sahifa, investitsiya platformasi, investor paneli, onlayn investitsiya, ko\'chmas mulk, foyda kuzatuv tizimi',
            'description' => 'Asosiy sahifada investitsiya loyihalari, moliyalashtirish va foyda kuzatuv tizimi mavjud. Envast - ko\'chmas mulk investitsiyalari uchun yetakchi raqamli platforma.',
            'type' => 'page',
            'key' => 'home',
            'icon' => 'fa-home'
        ],
        'about' => [
            'name' => 'Biz Haqimizda Sahifasi SEO',
            'title' => 'Envast Haqida | Bizning Maqsad va Qadriyatlar',
            'keywords' => 'Envast haqida, kompaniya tarixi, missiyasi, vision, jamoamiz, investorlar uchun platforma, Islom moliyasi prinsiplari',
            'description' => 'Envast - ko\'chmas mulkka halol va ulushli investitsiyalarni amalga oshirish uchun yaratilgan raqamli platforma. Bizning maqsadimiz - investorlar uchun ishonchli va Shariatga muvofiq investitsiya imkoniyatlarini yaratish.',
            'type' => 'page',
            'key' => 'about',
            'icon' => 'fa-info-circle'
        ],
        'projects' => [
            'name' => 'Investitsion Loyihalar Sahifasi SEO',
            'title' => 'Envast Loyiha Katalogi | Ko\'chmas Mulk Investitsiyalari',
            'keywords' => 'investitsion loyihalar, ko\'chmas mulk loyihalari, investitsiya ob\'yektlari, ulushli moliyalashtirish, aktivlarni tanlash, daromadli loyihalar, loyiha katalogi',
            'description' => 'Investitsion loyihalar katalogi. Investorlar uchun turli ko\'chmas mulk loyihalari, ulushli moliyalashtirish va daromad kuzatuvi. Turli xil investitsiya ob\'yektlari va ularning rentabelligi.',
            'type' => 'page',
            'key' => 'projects',
            'icon' => 'fa-building'
        ],
        'shariah' => [
            'name' => 'Shariatga Muvofiqligi Sahifasi SEO',
            'title' => 'Shariatga Muvofiqligi | Halol Investitsiya - Envast',
            'keywords' => 'Shariatga muvofiqligi, halol investitsiya, Islom moliyasi, Shariat qoidalari, mudoraba, musharaka, g\'arar va maisir, halol daromad',
            'description' => 'Envast platformasidagi barcha investitsiyalar Shariat qoidalariga qat\'iy rioya qilinadi. Mudoraba, Musharaka kabi halol moliyaviy modellar orqali investitsiya qilish imkoniyati.',
            'type' => 'page',
            'key' => 'shariah',
            'icon' => 'fa-star-and-crescent'
        ],
        'media' => [
            'name' => 'Media Sahifasi SEO',
            'title' => 'Media | Yangiliklar va Fotogalereya - Envast',
            'keywords' => 'media, yangiliklar, fotogalereya, videolar, tadbirlar, investor uchrashuvlari, loyiha yangiliklari, press-relizlar',
            'description' => 'Envast media markazi - platformamizdagi yangi loyihalar, investor uchrashuvlari, fotogalereya va videolar. Bizning faoliyatimiz haqida eng so\'nggi yangiliklar.',
            'type' => 'page',
            'key' => 'media',
            'icon' => 'fa-photo-video'
        ],
        'contact' => [
            'name' => 'Aloqa Sahifasi SEO',
            'title' => 'Bog\'lanish | Envast Investorlar Uchun Qo\'llab-quvvatlash',
            'keywords' => 'bog\'lanish, aloqa, mijozlar uchun qo\'llab-quvvatlash, texnik yordam, investor munosabatlari, ofis manzili, telefon raqamlari, elektron pochta',
            'description' => 'Envast bilan bog\'lanish uchun aloqa ma\'lumotlari. Investorlar uchun qo\'llab-quvvatlash xizmati, texnik yordam va maslahat olish imkoniyati. Biz bilan aloqaga chiqing.',
            'type' => 'page',
            'key' => 'contact',
            'icon' => 'fa-phone-alt'
        ],
        'og' => [
            'name' => 'Open Graph (Social Media) Sozlamalari',
            'title' => 'Envast - Investitsiya Platformasi',
            'description' => 'Ko\'chmas mulk investitsiyalari va ulushli moliyalashtirish imkoniyatlari. Halol va Shariatga muvofiq investitsiya platformasi.',
            'image' => 'https://envast.uz/images/og-image.jpg',
            'type' => 'social',
            'key' => 'og',
            'icon' => 'fa-facebook'
        ]
    ]);

    if ($page !== null && isset($seoSettings[$page])) {
        return (object) $seoSettings[$page];
    }

    return $seoSettings;
}



function getPartners($id = null)
{
    $partners = collect([
        [
            'id' => 1,
            'name' => 'Payme',
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Paymeuz_logo.png',
            'address' => 'Toshkent shahar, Yunusobod tumani',
            'description' => 'Oʻzbekistondagi yetakchi toʻlov tizimi va elektron pul hamyonlari provayderi.',
            'hashtag' => '#payme #tulovtizimi #epul',
            'email' => 'support@payme.uz',
            'phone' => '+998781111111',
            'website' => 'https://payme.uz',
            'status' => True,
        ],
        [
            'id' => 2,
            'name' => 'Click',
            'logo' => 'https://api.logobank.uz/media/logos_png/Click-01_hjB080W.png',
            'address' => 'Toshkent shahar, Mirzo Ulugʻbek tumani',
            'description' => 'Ommabop mobil ilova va onlayn toʻlov xizmatlari platformasi.',
            'hashtag' => '#click #mobililova #tulov',
            'email' => 'info@click.uz',
            'phone' => '+998781112222',
            'website' => 'https://click.uz',
            'status' => False,
        ],
        [
            'id' => 3,
            'name' => 'Uzum',
            'logo' => 'https://api.logobank.uz/media/logos_png/Uzum-01.png',
            'address' => 'Toshkent shahar, Chilonzor tumani',
            'description' => 'Oʻzbekistonning eng yirik onlayn savdo platformasi.',
            'hashtag' => '#uzum #onlaynsavdo #marketpleys',
            'email' => 'contact@uzum.uz',
            'phone' => '+998781113333',
            'website' => 'https://uzum.uz',
            'status' => True,
        ],
        [
            'id' => 4,
            'name' => 'MyTaxi',
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fc/Mytaxi_logo.png',
            'address' => 'Toshkent shahar, Yakkasaroy tumani',
            'description' => 'Taksiga buyurtma berish va transport xizmatlari platformasi.',
            'hashtag' => '#mytaxi #taksi #transport',
            'email' => 'support@mytaxi.uz',
            'phone' => '+998781114444',
            'website' => 'https://mytaxi.uz',
            'status' => True,
        ],
        [
            'id' => 5,
            'name' => 'Yandex Go',
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/22/Yandex_Go_icon.svg',
            'address' => 'Toshkent shahar, Shayxontohur tumani',
            'description' => 'Transport, yetkazib berish va boshqa turdagi xizmatlar platformasi.',
            'hashtag' => '#yandexgo #taksi #yetkazibberish',
            'email' => 'uzbekistan@yandex.com',
            'phone' => '+998781115555',
            'website' => 'https://go.yandex',
            'status' => True,
        ],
        [
            'id' => 6,
            'name' => 'Kun.uz',
            'logo' => 'https://kun.uz//assets/66844a27/img/icons/logo-light.svg',
            'address' => 'Toshkent shahar, Mirobod tumani',
            'description' => 'Oʻzbekistondagi yetakchi yangiliklar portali.',
            'hashtag' => '#kunuz #yangiliklar #media',
            'email' => 'info@kun.uz',
            'phone' => '+998781116666',
            'website' => 'https://kun.uz',
            'status' => False,
        ],
        [
            'id' => 8,
            'name' => 'Makro',
            'logo' => 'https://api.logobank.uz/media/logos_png/Makro-01.png',
            'address' => 'Toshkent shahar, Sergeli tumani',
            'description' => 'Ommabop supermarketlar tarmogʻi va oziq-ovqat doʻkonlari.',
            'hashtag' => '#makro #supermarket #oziqovqat',
            'email' => 'info@makro.uz',
            'phone' => '+998781118888',
            'website' => 'https://makro.uz',
            'status' => True,
        ],
        [
            'id' => 9,
            'name' => 'Olcha',
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/85/Olcha.uz.png',
            'address' => 'Toshkent shahar, Bektemir tumani',
            'description' => 'Tez yetkazib berish xizmati bilan elektronika doʻkoni.',
            'hashtag' => '#olcha #elektronika #onlayndokon',
            'email' => 'support@olcha.uz',
            'phone' => '+998781119999',
            'website' => 'https://olcha.uz',
            'status' => True,
        ],
        [
            'id' => 10,
            'name' => 'ZoodMall',
            'logo' => 'https://silverstonef1.ru/wp-content/uploads/2024/02/ZOODMALL.jpg',
            'address' => 'Toshkent shahar, Yangihayot tumani',
            'description' => 'Xalqaro va mahsulotlarni sotish platformasi.',
            'hashtag' => '#zoodmall #onlaynsavdo #marketpleys',
            'email' => 'help@zoodmall.com',
            'phone' => '+998781120000',
            'website' => 'https://zoodmall.com',
            'status' => True,
        ]
    ]);

    if ($id !== null) {
        return $partners->where('id', $id)->first();
    }

    return $partners;
}


function getAppeals($id = null)
{
    $appeals = collect([
        [
            'id' => 1,
            'name' => 'Ali Valiyev',
            'phone' => '+998901112233',
            'email' => 'ali@example.com',
            'subject' => 'Hamkorlik taklifi',
            'message' => 'Sizning kompaniyangiz bilan hamkorlik qilishni istayman. Loyihamiz haqida suhbatlashishimiz mumkinmi?',
            'status' => 'Yangi',
            'attachment' => 'https://example.com/files/ali_proposal.pdf',
            'created_at' => '2024-01-12 14:30:00',
            'read_at' => null,
            'replied_at' => null,
        ],
        [
            'id' => 2,
            'name' => 'Dilshod Bahodirov',
            'phone' => '+998931112233',
            'email' => 'dilshod@example.com',
            'subject' => 'Texnik support',
            'message' => 'Platformada xatolik bor. Login qilish imkoniyati yo‘q. Tezroq yordam bering.',
            'status' => 'Javob berildi',
            'attachment' => null,
            'created_at' => '2024-01-11 10:15:00',
            'read_at' => '2024-01-11 11:20:00',
            'replied_at' => '2024-01-11 12:00:00',
        ],
        [
            'id' => 3,
            'name' => 'Guli Karimova',
            'phone' => '+998941112233',
            'email' => 'guli@example.com',
            'subject' => 'To‘lov muammosi',
            'message' => 'To‘lov qilganimda pul qaytarilmadi. Qanday yechim topish mumkin?',
            'status' => 'Ko‘rildi',
            'attachment' => null,
            'created_at' => '2024-01-10 16:45:00',
            'read_at' => '2024-01-11 09:30:00',
            'replied_at' => null,
        ],
        [
            'id' => 4,
            'name' => 'Sardor Tursunov',
            'phone' => '+998971112233',
            'email' => 'sardor@example.com',
            'subject' => 'Xizmat narxi',
            'message' => 'Premium tarif narxini bilishni istardim. Chegirmalar bormi?',
            'status' => 'Yangi',
            'attachment' => null,
            'created_at' => '2024-01-10 09:20:00',
            'read_at' => null,
            'replied_at' => null,
        ],
        [
            'id' => 5,
            'name' => 'Malika Xudoyberdiyeva',
            'phone' => '+998901119988',
            'email' => 'malika@example.com',
            'subject' => 'Reklama hamkorligi',
            'message' => 'Sizning platformangizda reklama joylashtirishni istayman. Narxlar qanday?',
            'status' => 'Yopildi',
            'attachment' => 'https://example.com/files/malika_ad.pdf',
            'created_at' => '2024-01-09 11:10:00',
            'read_at' => '2024-01-09 14:00:00',
            'replied_at' => '2024-01-09 16:30:00',
        ],
        [
            'id' => 6,
            'name' => 'Javohir Sattorov',
            'phone' => '+998931119988',
            'email' => 'javohir@example.com',
            'subject' => 'API hujjatlari',
            'message' => 'Platformangiz uchun API hujjatlarini qayerdan olish mumkin?',
            'status' => 'Javob berildi',
            'attachment' => null,
            'created_at' => '2024-01-08 13:25:00',
            'read_at' => '2024-01-08 14:10:00',
            'replied_at' => '2024-01-08 15:45:00',
        ],
        [
            'id' => 7,
            'name' => 'Shaxzoda Umarova',
            'phone' => '+998941119988',
            'email' => 'shaxzoda@example.com',
            'subject' => 'Akkaunt bloklangan',
            'message' => 'Akkauntim bloklangan. Nima uchun va qanday ochish mumkin?',
            'status' => 'Ko‘rildi',
            'attachment' => null,
            'created_at' => '2024-01-07 17:40:00',
            'read_at' => '2024-01-08 10:15:00',
            'replied_at' => null,
        ],
        [
            'id' => 8,
            'name' => 'Botir Qodirov',
            'phone' => '+998971119988',
            'email' => 'botir@example.com',
            'subject' => 'Yangiliklar obunasi',
            'message' => 'Yangiliklarga obuna bo‘lishni istayman. Qanday qilish mumkin?',
            'status' => 'Yangi',
            'attachment' => null,
            'created_at' => '2024-01-07 15:20:00',
            'read_at' => null,
            'replied_at' => null,
        ],
    ]);

    if ($id !== null) {
        return $appeals->where('id', $id)->first();
    }

    return $appeals;
}

if (!function_exists('getContractsData')) {
    function getContractsData($id = null)
    {
        $datas = collect([
            [
                'id' => 101,
                'contract_no' => 'ENV-IC-2026-0001',
                'date' => '2026-01-12',
                'share_price' => 2500000,
                'share_value' => 25000000,
                'status' => 'imzolash', // imzolash, imzolangan, jarayonda, rad, bekor
                'contract_file' => 'contract_0001.pdf',
                'sale_file' => 'sale_0001.pdf',

                'project' => [
                    'name' => 'Toshkent City Rent',
                    'type' => 'Ijara',
                    'round' => '1-raund (yakunlandi)',
                    'address' => 'Toshkent, Yakkasaroy',
                    'funded' => 72,
                    'risk' => 'O‘rta',
                    'duration' => '3 oy',
                    'roi' => '18%',
                ],

                'buyer' => [
                    'name' => 'Jalolbek Nurullayev',
                    'pin' => 'AA1234567',
                    'type' => 'Jismoniy',
                    'state' => 'Faol',
                    'phone' => '+998 90 123 45 67',
                    'login' => 'jalolbek',
                    'address' => 'Toshkent sh.',
                ],

                'seller' => [
                    'name' => 'Envast Full Partner LLC',
                    'pin' => '309998877',
                    'type' => 'Yuridik',
                    'state' => 'Faol',
                    'phone' => '+998 71 200 00 00',
                    'login' => 'envast_partner',
                    'address' => 'Toshkent sh.',
                ],

                'payment' => [
                    'date' => '2026-01-12',
                    'amount' => 25000000,
                    'currency' => 'UZS',
                    'status' => 'Tasdiqlangan',
                    'method' => 'Payme',
                    'tx_id' => 'TX-9A3F-001',
                    'app_status' => 'Qabul qilingan',
                    'app_note' => 'Hammasi joyida',
                ],

                'transactions' => [
                    ['type' => 'Kiritim', 'amount' => 25000000, 'dt' => '2026-01-12 14:10', 'status' => 'Tasdiqlangan'],
                    ['type' => 'Dividend', 'amount' => 450000, 'dt' => '2026-01-13 18:00', 'status' => 'Jarayonda'],
                ],

                'expenses' => [
                    ['name' => 'Notarius', 'cat' => 'Huquqiy', 'dt' => '2026-01-12 16:10', 'total' => 1200000, 'share' => 240000],
                    ['name' => 'Platforma xizmati', 'cat' => 'Servis', 'dt' => '2026-01-12 16:15', 'total' => 800000, 'share' => 160000],
                ],

                'distribution' => [
                    ['party' => 'To‘liq sherik', 'base' => 'Sof foyda', 'percent' => 60, 'need' => 3000000, 'paid' => 1500000, 'dates' => '2026-02-12, 2026-03-12'],
                    ['party' => 'Komanditchi', 'base' => 'Sof foyda', 'percent' => 40, 'need' => 2000000, 'paid' => 500000, 'dates' => '2026-02-12, 2026-03-12'],
                ],

                'income' => [
                    ['amount' => 3500000, 'date' => '2026-01-13', 'doc' => 'INC-0009', 'payer' => 'Ijara to‘lovchi', 'details' => 'Yanvar ijara', 'by' => 'admin', 'bind' => '2026-01-13 19:40', 'note' => 'OK'],
                ],
            ],

            [
                'id' => 102,
                'contract_no' => 'ENV-IC-2026-0002',
                'date' => '2026-01-10',
                'share_price' => 3000000,
                'share_value' => 15000000,
                'status' => 'imzolangan',
                'contract_file' => 'contract_0002.pdf',
                'sale_file' => 'sale_0002.pdf',

                'project' => [
                    'name' => 'Chilonzor Qurilish',
                    'type' => 'Qurilish',
                    'round' => '3-raund (jarayonda)',
                    'address' => 'Toshkent, Chilonzor',
                    'funded' => 48,
                    'risk' => 'Yuqori',
                    'duration' => '10 oy',
                    'roi' => '24%',
                ],

                'buyer' => [
                    'name' => 'Aziza Karimova',
                    'pin' => 'BB7654321',
                    'type' => 'Jismoniy',
                    'state' => 'Faol',
                    'phone' => '+998 93 777 77 77',
                    'login' => 'aziza',
                    'address' => 'Toshkent sh.',
                ],

                'seller' => [
                    'name' => 'Envast Full Partner LLC',
                    'pin' => '309998877',
                    'type' => 'Yuridik',
                    'state' => 'Faol',
                    'phone' => '+998 71 200 00 00',
                    'login' => 'envast_partner',
                    'address' => 'Toshkent sh.',
                ],

                'payment' => [
                    'date' => '2026-01-10',
                    'amount' => 15000000,
                    'currency' => 'UZS',
                    'status' => 'Tasdiqlangan',
                    'method' => 'Click',
                    'tx_id' => 'TX-2B7C-889',
                    'app_status' => 'Qabul qilingan',
                    'app_note' => 'Tasdiqlandi',
                ],

                'transactions' => [
                    ['type' => 'Kiritim', 'amount' => 15000000, 'dt' => '2026-01-10 11:20', 'status' => 'Tasdiqlangan'],
                    ['type' => 'Dividend', 'amount' => 0, 'dt' => '—', 'status' => '—'],
                ],

                'expenses' => [],
                'distribution' => [],
                'income' => [],
            ],

            [
                'id' => 103,
                'contract_no' => 'ENV-IC-2026-0003',
                'date' => '2026-01-08',
                'share_price' => 2000000,
                'share_value' => 20000000,
                'status' => 'rad',
                'contract_file' => '—',
                'sale_file' => '—',

                'project' => [
                    'name' => 'Yer Uchastkasi — Sergeli',
                    'type' => 'Yer uchastkasi',
                    'round' => '2-raund (yakunlandi)',
                    'address' => 'Toshkent, Sergeli',
                    'funded' => 100,
                    'risk' => 'Past',
                    'duration' => '2 yil',
                    'roi' => '15%',
                ],

                'buyer' => [
                    'name' => 'Rustam Ismoilov',
                    'pin' => 'CC1122334',
                    'type' => 'Jismoniy',
                    'state' => 'Bloklangan',
                    'phone' => '+998 99 111 22 33',
                    'login' => 'rustam',
                    'address' => 'Toshkent sh.',
                ],

                'seller' => [
                    'name' => 'Envast Full Partner LLC',
                    'pin' => '309998877',
                    'type' => 'Yuridik',
                    'state' => 'Faol',
                    'phone' => '+998 71 200 00 00',
                    'login' => 'envast_partner',
                    'address' => 'Toshkent sh.',
                ],

                'payment' => [
                    'date' => '2026-01-08',
                    'amount' => 20000000,
                    'currency' => 'UZS',
                    'status' => 'Rad etilgan',
                    'method' => 'VisaCard',
                    'tx_id' => 'TX-REJ-004',
                    'app_status' => 'Rad etilgan',
                    'app_note' => 'KYC mos kelmadi',
                ],

                'transactions' => [
                    ['type' => 'Kiritim', 'amount' => 20000000, 'dt' => '2026-01-08 09:12', 'status' => 'Rad etilgan'],
                    ['type' => 'Qaytarim', 'amount' => 20000000, 'dt' => '2026-01-08 10:05', 'status' => 'Tasdiqlangan'],
                ],

                'expenses' => [],
                'distribution' => [],
                'income' => [],
            ],
        ]);

        // bitta contract kerak bo'lsa
        if ($id !== null) {
            return $datas->where('id', (int)$id)->first();
        }

        return $datas;
    }
}

if (!function_exists('getContractsStatusMap')) {
    function getContractsStatusMap(): array
    {
        return [
            'imzolash'   => ['cls' => 'st-signing', 'icon' => 'fa-regular fa-pen-to-square', 'txt' => "Imzolash jarayonida"],
            'imzolangan' => ['cls' => 'st-signed',  'icon' => 'fa-solid fa-check-circle',   'txt' => "Imzolangan"],
            'jarayonda'  => ['cls' => 'st-process', 'icon' => 'fa-solid fa-spinner',        'txt' => "Jarayonda"],
            'rad'        => ['cls' => 'st-reject',  'icon' => 'fa-solid fa-ban',            'txt' => "Rad etilgan"],
            'bekor'      => ['cls' => 'st-cancel',  'icon' => 'fa-solid fa-xmark-circle',   'txt' => "Bekor qilingan"],
        ];
    }
}
if (!function_exists('getMediaContents')) {
    function getMediaContents($id = null)
    {
        $mediaItems = [
            [
                'id' => 1,
                'image' => "https://www.toshvilstat.uz/images/yangiliklar2024/grafik_blue_pen_15032024.jpg",
                'title' => 'Investitsiya strategiyalari 2024',
                'type' => 'Moliyaviy maslahat',
                'status' => 'active',
                'date' => '15.10.2023',
                'description' => "2024 yil uchun eng so'nggi investitsiya strategiyalari va bozor tendensiyalari haqida batafsil qo'llanma. Global iqtisodiy o'zgarishlar, yangi texnologiyalarga investitsiya qilish imkoniyatlari, risklarni minimallashtirish usullari va daromadli aktivlarni tanlash bo'yicha professional maslahatlar. Moliya bozoridagi o'zgarishlarni oldindan ko'ra bilish va ulardan foydalanish sirlari.",
                'hashtags' => ['#investitsiya', '#strategiya2024', '#moliyaviyMaslahat', '#bozorTahlili', '#iqtisodiyot']
            ],
            [
                'id' => 2,
                'image' => "https://www.buxstat.uz/images/news/tanga3.jpg",
                'title' => 'Halol investitsiyalar haqida',
                'type' => 'Shariat',
                'status' => 'active',
                'date' => '14.10.2023',
                'description' => "Islom moliyaviy qoidalariga mos keladigan halol investitsiya turlari va usullari haqida to'liq ma'lumot. Shariat qonunlariga ko'ra qaysi faoliyat turlariga investitsiya qilish mumkin, qaysilariga yo'q. Halol daromad olishning zamonaviy usullari, Islom banklarining investitsiya loyihalari, g'aror va mudoraba shartnomalari asosida ishlash prinsiplari.",
                'hashtags' => ['#halolInvestitsiya', '#shariat', '#islamMoliyasi', '#halolDaromad', '#islamBank']
            ],
            [
                'id' => 3,
                'image' => "https://domtut.uz/resources/uploads/thumbs/binkat/main_0.webp?r=1744179521",
                'title' => 'Yangi turar-joy loyihasi',
                'type' => "Ko'chmas mulk",
                'status' => 'draft',
                'date' => '13.10.2023',
                'description' => "Toshkent shahri markazida yangi qurilayotgan premium turar-joy majmuasi haqida batafsil ma'lumot. Loyihaning arxitektura dizayni, infratuzilmasi, xavfsizlik tizimlari va qulayliklari. Kvartiralarning maydonlari, tartiblari va narxlari. Makonning kelajakdagi qiymat oshishi prognozlari va investitsion jozibadorligi. Muddatli to'lov imkoniyatlari va ipoteka kreditlari shartlari.",
                'hashtags' => ['#kochmasMulk', '#turarJoy', '#yangiloyiha', '#investitsiyaMulk', '#premiumKvartira']
            ],
            [
                'id' => 4,
                'image' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZyRDQRsGJPC-yteYZSTJmb3H2J-0xUO7udA&s",
                'title' => 'Bozor tahlili: Q3 2023',
                'type' => 'Bozor tahlili',
                'status' => 'active',
                'date' => '12.10.2023',
                'description' => "2023 yilning uchinchi choragi davomida O'zbekiston va global bozorlardagi asosiy tendensiyalar va o'zgarishlarning chuqur tahlili. Valyuta bozoridagi o'zgarishlar, aksiyalar va obligatsiyalar dinamikasi, neft va oltin narxlari, ko'chmas mulk bozorining holati. Har bir sektor bo'yicha investitsion imkoniyatlar va tavsiyalar. Kelgusi chorak uchun bozor prognozlari va potentsial risklar.",
                'hashtags' => ['#bozorTahlili', '#q32023', '#iqtisodiyTahlil', '#investitsionImkoniyatlar', '#globalBozor']
            ],
            [
                'id' => 5,
                'image' => "https://www.spot.uz/media/img/2024/07/BKZ7t417223446941464_l.jpg",
                'title' => 'Yangi ofis ochildi',
                'type' => 'Yangiliklar',
                'status' => 'archived',
                'date' => '11.10.2023',
                'description' => "Bizning kompaniyamizning Samarqand shahrida yangi ofis ochilishi bilan bog'liq batafsil ma'lumot. Yangi ofisning joylashuvi, xizmat ko'rsatish yo'nalishlari va mijozlar uchun qo'shimcha imkoniyatlari. Ofisning ochilish marosimi, ishtirokchi mehmonlar va kelishuvlar haqida. Yangi hududda biznesni kengaytirish strategiyasi va kelajakdagi loyihalar rejasi. Samarqand va atrofidagi mintaqalar uchun maxsus takliflar.",
                'hashtags' => ['#yangiofis', '#kompaniyaYangiliklari', '#samarqand', '#biznesKengaytirish', '#yangiLoyihalar']
            ],
            [
                'id' => 6,
                'image' => "https://innovation.gov.uz/media/post_images/Hero_Blog_Introducing-the-5G-Innovation-Space.jpg",
                'title' => 'Startap loyihalar uchun moliyalashtirish',
                'type' => 'Moliyaviy maslahat',
                'status' => 'active',
                'date' => '10.10.2023',
                'description' => "Yangi startap loyihalarni moliyalashtirishning turli usullari va manbalari haqida keng qamrovli qo'llanma. Venture kapital, biznes-anjellar, grantlar, kreditlar va krowdfanding platformalari. Investordan mablag' olish uchun biznes-reyni tayyorlash, pitch deck yaratish va muvaffaqiyatli prezentatsiya qilish sirlari. O'zbekistonda startaplar uchun davlat qo'llab-quvvatlash dasturlari va soliq imtiyozlari.",
                'hashtags' => ['#startap', '#moliyalashtirish', '#ventureKapital', '#biznesRey', '#grantlar']
            ],
            [
                'id' => 7,
                'image' => "https://www.gazeta.uz/media/img/2022/11/dTcfzC16687538675092_b.jpg",
                'title' => 'Kriptovalyuta bozoridagi yangiliklar',
                'type' => 'Bozor tahlili',
                'status' => 'draft',
                'date' => '09.10.2023',
                'description' => "So'nggi oylarda kriptovalyuta bozorida sodir bo'lgan muhim voqealar va o'zgarishlar tahlili. Bitcoin, Ethereum va boshqa yetakchi kriptovalyutalar narxlarining o'zgarishi, yangi blockchain loyihalari, NFT bozori tendensiyalari. Kriptovalyutaga investitsiya qilishning xavflari va imkoniyatlari, hamyonlarni xavfsiz saqlash usullari. O'zbekistonda kriptovalyutalar bilan operatsiyalar qilishning huquqiy jihatlari.",
                'hashtags' => ['#kriptovalyuta', '#bitcoin', '#blockchain', '#nft', '#kryptoInvestitsiya']
            ],
            [
                'id' => 8,
                'image' => "https://xn--80ajgpcpbhkds4a4g.xn--p1ai/wp-content/uploads/2017/02/investicii.jpg",
                'title' => "Qishloq xo'jaligiga investitsiya",
                'type' => "Ko'chmas mulk",
                'status' => 'active',
                'date' => '08.10.2023',
                'description' => "Qishloq xo'jaligi sohasiga investitsiya qilishning istiqbolli yo'nalishlari va usullari. Fermer xo'jaliklari, issiqxonalar, meva-sabzavot plantatsiyalari, chorvachilik komplekslariga investitsiyaning iqtisodiy samaradorligi. Davlatning qishloq xo'jaligi investitsiyalarini qo'llab-quvvatlash dasturlari, subsidiyalar va kreditlar. Eksport qilish imkoniyatlari va ichki bozorda talabni qondirish strategiyalari.",
                'hashtags' => ['#qishloqXojalik', '#fermerlik', '#investitsiyaQishloq', '#agrobiznes', '#fermerXojalik']
            ],
            [
                'id' => 9,
                'image' => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQN-hZiu9VDRwbvp879TRdU1uudEz_eSeb20w&s",
                'title' => 'Oilaviy biznesni meros qilib qoldirish',
                'type' => 'Moliyaviy maslahat',
                'status' => 'active',
                'date' => '07.10.2023',
                'description' => "Oilaviy biznesni keyingi avlodlarga muvaffaqiyatli meros qilib qoldirishning huquqiy va moliyaviy jihatlari. Meros shartnomalari, trust fondlari, biznesni boshqarishni o'tkazish strategiyalari. Soliqlarni optimallashtirish va mulkni himoya qilish usullari. Oilaviy biznesda kelishmovchiliklar va nizolarning oldini olish. Yosh avlodni biznes boshqaruviga tayyorlash va motivatsiya berish metodlari.",
                'hashtags' => ['#oilaviyBiznes', '#meros', '#biznesBoshqaruv', '#moliyaviyRey', '#soliqOptimizatsiya']
            ],
            [
                'id' => 10,
                'image' => "https://www.uzdaily.uz/media/filer_public/7d/8f/7d8fd8da-7cc9-4449-a06b-3d52cba97964/transport.jpg",
                'title' => 'Turizm biznesi investitsiyalari',
                'type' => 'Yangiliklar',
                'status' => 'active',
                'date' => '06.10.2023',
                'description' => "O'zbekiston turizm biznesiga investitsiya qilishning hozirgi imkoniyatlari va kelajakdagi istiqbollari. Mehmondo'stlik ob'ektlari, tur operatorlik xizmatlari, madaniy turizm loyihalari va ekoturizm. Davlatning turizm sohasini rivojlantirish dasturlari va investitsiyalarni rag'batlantirish choralari. Xalqaro sayyohlar oqimini oshirish strategiyalari va turistik infratuzilmani rivojlantirish.",
                'hashtags' => ['#turizmBiznes', '#investitsiyaTurizm', "#o'zbekistonTurizm", "#mehmondo'stlik", "#ekoturizm"]
            ]
        ];

        $collection = collect($mediaItems);

        if ($id !== null) {
            return $collection->where('id', $id)->first();
        }

        return $collection;
    }
}

if (!function_exists('getAvailableBanners')) {
    function getAvailableBanners($id = null)
    {
        $banners = [
            [
                'id' => 1,
                'title' => 'Media markazi',
                'size' => '1920×800 px',
                'label' => 'Asosiy banner',
                'image' => 'https://via.placeholder.com/180x110/111827/ffffff?text=Media'
            ],
            [
                'id' => 2,
                'title' => 'Moliyaviy maslahat',
                'size' => '1920×800 px',
                'label' => 'Asosiy banner',
                'image' => 'https://via.placeholder.com/180x110/4361ee/ffffff?text=Finance'
            ],
            [
                'id' => 3,
                'title' => 'Shariat',
                'size' => '1920×800 px',
                'label' => 'Asosiy banner',
                'image' => 'https://via.placeholder.com/180x110/10b981/ffffff?text=Sharia'
            ],
            [
                'id' => 4,
                'title' => 'Ko‘chmas mulk',
                'size' => '1920×800 px',
                'label' => 'Asosiy banner',
                'image' => 'https://via.placeholder.com/180x110/f59e0b/ffffff?text=Real+Estate'
            ],
        ];

        $collection = collect($banners);

        if ($id !== null) {
            return $collection->where('id', $id)->first();
        }

        return $collection;
    }
}

if (!function_exists('getMediaStatusMap')) {
    function getMediaStatusMap($status = null)
    {
        $statusMap = [
            'active'   => ['cls' => 'status-active', 'icon' => 'fa-solid fa-circle-check', 'txt' => "Faol"],
            'draft'    => ['cls' => 'status-draft', 'icon' => 'fa-regular fa-file-lines', 'txt' => "Qoralama"],
            'archived' => ['cls' => 'status-archived', 'icon' => 'fa-solid fa-box-archive', 'txt' => "Arxivlangan"],
        ];

        if ($status !== null) {
            return $statusMap[$status] ?? $statusMap['draft'];
        }

        return $statusMap;
    }
}
