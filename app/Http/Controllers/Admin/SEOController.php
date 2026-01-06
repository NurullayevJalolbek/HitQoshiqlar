<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SEOController extends Controller
{
    public function index(Request $request)
    {
        $go_back = $request->go_back;

        return view('pages.seo-settings.index', [
            'go_back' => $go_back
        ]);
    }



    public function edit(Request $request, $key)
    {

        $model = getSEOSettings($key);

        // dd($model);
        return view("pages.seo-settings.edit", compact('model'));
    }
}
