<?php

namespace App\Services\Contracts;
use App\Models\User;

interface iTelegramBotService
{

    public function showSearchResults($chat_id, array $state, $token,  $message_id = null): void;


}