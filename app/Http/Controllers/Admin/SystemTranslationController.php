<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemTranslationController extends Controller
{
    public function    index()
    {
        return view('pages.system-translations.index');
    }
}
