<?php

namespace App\Services\YoutubeSearch\Contracts;

use App\Models\User;

interface iYoutubeSearchService
{

    public function youtubeSearch($chat_id, $message);



}
