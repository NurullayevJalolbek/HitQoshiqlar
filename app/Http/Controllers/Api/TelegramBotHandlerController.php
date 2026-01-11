<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class TelegramBotHandlerController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = config("services.telegram.bot_token");
    }

    public function webhook(Request $request)
    {

        if ($request->has("message")) {
            $message = $request->input('message.text');
            $chat_id = $request->input('message.chat.id');
            $user = $request->input('message.from');


            Log::warning("Telegram webhook data", [
                'chat_id' => $chat_id,
                'message' => $message
            ]);


            if ($message == '/start') {
                $text = __("admin.start");

                sendMessage($chat_id, $text, $this->token);
            } else if ($message == '/language') {
                $keyboard = [
                    'inline_keyboard' => [
                        [
                            ['text' => '🇺🇿 Uz', 'callback_data' => 'uz'],
                            ['text' => '🇷🇺 Ру', 'callback_data' => 'ru'],
                            ['text' => '🇬🇧 En', 'callback_data' => 'en'],
                        ]
                    ]
                ];

                $text = "O'zingizga qulay bo‘lgan tilni tanlang";
                sendStartWithButtons($chat_id, $text, $this->token, $keyboard);
            }
        }

        if ($request->has('callback_query')) {

            $callback = $request->input('callback_query');

            $chat_id     = $callback['message']['chat']['id'];
            $message_id  = $callback['message']['message_id'];
            $selected    = $callback['data'];
            $callback_id = $callback['id'];

            /*

            1️⃣ Tilni yangilash

            */

            $langTexts = [
                'uz' => [
                    'title' => "Til muvaffaqiyatli yangilandi ✅",
                    'select' => "O‘zingizga qulay bo‘lgan tilni tanlang"
                ],
                'ru' => [
                    'title' => "Язык успешно обновлён ✅",
                    'select' => "Выберите удобный для вас язык"
                ],
                'en' => [
                    'title' => "Language successfully updated ✅",
                    'select' => "Choose the language you prefer"
                ],
            ];

            answerTelegramCallback(
                $callback_id,
                $langTexts[$selected]['title'],
                $this->token
            );

            // 2️⃣ Xabar matni
            $text = $langTexts[$selected]['select'];

            // 3️⃣ Tugmalarni ✅ bilan qayta chizish
            $keyboard = buildLanguageKeyboard($selected);


            sendStartWithButtons(
                $chat_id,
                $text,
                $this->token,
                $keyboard,
                $message_id
            );
        }






        return response()->json(['ok' => true]);
    }
}
