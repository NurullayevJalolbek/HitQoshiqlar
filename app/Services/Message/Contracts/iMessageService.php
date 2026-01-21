<?php

namespace App\Services\Message\Contracts;

use Illuminate\Http\Request;

interface iMessageService
{
    public function index(Request $request);
}