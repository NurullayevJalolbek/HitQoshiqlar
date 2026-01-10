<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TelegramBotHandlerController extends Controller
{
    public function webhook(Request $request)
    {
        $message = $request->input('message.text');
        $chat_id = $request->input('message.chat.id');

        Log::warning("Telegram webhook data", [
            'chat_id' => $chat_id,
            'message' => $message
        ]);


        if ($message == '/start') {
            sendStartWithButtons($chat_id);
        } else {
            sendMessage($chat_id, "Buyruqni tushunmadim 😅\n/start yozib ko‘r");
        }

        return response()->json(['ok' => true]);
    }
}
