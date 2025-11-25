<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.general-settings.index');
    }
}
