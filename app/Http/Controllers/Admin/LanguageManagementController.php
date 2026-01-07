<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageManagementController extends Controller
{
    public function index(Request $request)
    {
        $go_back = $request->go_back;

        return view('pages.language-management.index', [
            'go_back'=> $go_back
        ]);
    }



    public function edit(Request $request, $id)
    {
        $go_back = $request->go_back;

        $model = getLanguagesData($id);
        return view('pages.language-management.edit', compact('model', 'go_back'));
    }

    public function create(Request $request)
    {
        $go_back = $request->go_back;
        return view('pages.language-management.create', [
            'go_back' => $go_back,
        ]);
    }

}
