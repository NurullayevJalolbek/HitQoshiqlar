<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;




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
            $userData = $request->input('message.from');

            if (!is_null($userData)) {
                $first_name = $userData['first_name'] ?? null;
                $last_name  = $userData['last_name'] ?? null;
                $fullname   = trim($first_name . ' ' . $last_name);


                $user = User::updateOrCreate(
                    ['chat_id' => $userData['id']],
                    [
                        'is_bot'   => $userData['is_bot'],
                        'fullname' => $fullname,
                        'username' => $userData['username'] ?? null,
                        'status'   => 'active',
                        'registered_by' => 'telegram'
                    ]
                );
            }

            Log::warning("Telegram webhook data", [
                'chat_id' => $chat_id,
                'message' => $message
            ]);


            if ($message == '/start') {


                $locale_selected = User::where('chat_id', $chat_id)->value('locale');
                App::setLocale($locale_selected);
                $text = __("admin.start");



                sendMessage($chat_id, $text, $this->token);
            } else if ($message == '/language') {

                $locale_selected = User::where('chat_id', $chat_id)->value('locale');


                $keyboard = buildLanguageKeyboard($locale_selected);

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

            $user = User::where('chat_id', $chat_id)->update([
                'locale' => $selected,
            ]);

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
