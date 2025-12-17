<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function index(Request $request)
    {
        return view("pages.static-pages.index");
    }

    public function edit($id)
    {
        $model = getStaticPages($id);

        return view('pages.static-pages.edit',[
            'model'=> $model
        ]);
    }


    public function create()
    {
        return view('pages.static-pages.create');

    }
}
