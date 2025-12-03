<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateMessageController extends Controller
{
    public function index()
    {
        return view('pages.template-messages.index');
    }
}
