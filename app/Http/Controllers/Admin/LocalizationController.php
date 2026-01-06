<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    public function index(Request $request)
    {
        $go_back = $request->go_back;


        return view('pages.localization.index', [
            'go_back' => $go_back,
        ]);
    }
}
