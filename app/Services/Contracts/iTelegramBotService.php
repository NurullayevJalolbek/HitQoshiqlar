<?php

namespace App\Services\Contracts;
use App\Models\User;

interface iTelegramBotService
{

    public function showSearchResults($chat_id, array $state, $token,  $message_id = null): void;


    public function deleteMessage($chat_id, $message_id, $token);

}