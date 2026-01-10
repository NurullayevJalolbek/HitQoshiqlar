<?php

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


function formatCurrency($number, $decimal = 0)
{
    if (is_null($number)) {
        return 0;
    }

    $decimal = strlen(explode('.', (string) $number)[1] ?? '');

    return number_format($number, $decimal, '.', ' ');
}






if (!function_exists('sendMessage')) {
    function sendMessage($chat_id, $message)
    {
        // Tokenni config orqali olish — config allaqachon yuklangan bo‘lishi kerak
        $token = config("services.telegram.bot_token");

        Log::warning('sendMessage called', [
            'chat_id' => $chat_id,
            'message' => $message,
            'token' => $token
        ]);

        if (!$token) {
            Log::error("Telegram token bo'sh! Check config/services.php and .env");
            return false;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        Http::withOptions(['verify' => false])->post($url, [
            'chat_id' => $chat_id,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);
    }
}


if (!function_exists('sendStartWithButtons')) {
    function sendStartWithButtons($chat_id)
    {
        $token = config("services.telegram.bot_token");

        if (!$token) {
            Log::error("Telegram token bo'sh! Check config/services.php and .env");
            return false;
        }


        // 2️⃣ Inline keyboard
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => '🇺🇿 Uzbekcha', 'callback_data' => 'uz'],
                    ['text' => '🇷🇺 Русский', 'callback_data' => 'ru'],
                    ['text' => '🇬🇧 English', 'callback_data' => 'en'],
                ]
            ]
        ];

        // 3️⃣ Matn xabari
        $text = "🎵 Hit Qo‘shiqlar botiga xush kelibsiz!\n\nBotdan o'zingizga qulay tilda foydalanishingiz mumkin.";

        // 4️⃣ Xabarni yuborish
        $payload = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($keyboard)
        ];

        Http::withOptions(['verify' => false])->post(
            "https://api.telegram.org/bot{$token}/sendMessage",
            $payload
        );

        Log::warning("sendStartWithButtons called", [
            'chat_id' => $chat_id,
            'message' => $text
        ]);
    }
}

