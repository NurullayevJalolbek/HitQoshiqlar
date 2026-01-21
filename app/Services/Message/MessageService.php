<?php

namespace App\Services\Message;

use App\Models\UserMessage;
use App\Services\Message\Contracts\iMessageService;
use App\Traits\Crud;

class MessageService implements iMessageService
{
    use Crud;

    public function index($request)
    {
        $user_id = $request->user_id;

        $datas = UserMessage::with("user")
            ->where("user_id", $user_id)
            ->orderBy("created_at", "desc")
            ->CustomPaginate(10);


        return $datas;
    }
}
