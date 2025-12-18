<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SEOController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.seo-settings.index');
    }



    public function edit(Request $request)
    {
        $model = getSEOSettings();

        return view("pages.seo-settings.edit", compact('model'));
    }
}
