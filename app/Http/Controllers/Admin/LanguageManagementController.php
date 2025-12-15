<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageManagementController extends Controller
{
    public function index()
    {
        return view('pages.language-management.index');
    }



    public function edit($id)
    {
        $model = getLanguagesData($id);
        return view('pages.language-management.edit', compact('model'));
    }

    public function create()
    {
        return view('pages.language-management.create');
    }

}
