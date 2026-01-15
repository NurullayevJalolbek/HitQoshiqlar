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
    function sendMessage($chat_id, $message, $token,  $message_id = null)
    {
        Log::warning('sendMessage called', [
            'chat_id' => $chat_id,
            'message' => $message,
            'message_id' => $message_id,
            'token' => $token
        ]);

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



if (!function_exists('sendLocalPhotoMessage')) {
    function sendLocalPhotoMessage($chat_id, $publicPath, $caption, $token, $reply_markup = null)
    {
        if (!$token) {
            Log::error("Telegram token bo'sh!");
            return false;
        }

        $absolutePath = public_path($publicPath); // masalan: 'assets/img/hitqoshiqlarbot.png'

        if (!file_exists($absolutePath)) {
            Log::error("Rasm topilmadi!", ['path' => $absolutePath]);
            return false;
        }

        $url = "https://api.telegram.org/bot{$token}/sendPhoto";

        $request = Http::asMultipart()->attach(
            'photo',
            file_get_contents($absolutePath),
            basename($absolutePath)
        );

        $payload = [
            'chat_id' => $chat_id,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ];

        if ($reply_markup) {
            $payload['reply_markup'] = json_encode($reply_markup, JSON_UNESCAPED_UNICODE);
        }

        $res = $request->post($url, $payload);

        Log::info("sendLocalPhotoMessage response", [
            'ok' => $res->ok(),
            'status' => $res->status(),
            'body' => $res->json(),
            'absolutePath' => $absolutePath,
        ]);

        return $res->ok();
    }
}
