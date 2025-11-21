<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\User;

class LanguageController extends Controller
{

    public function change(Request $request)
    {
        $lang = Language::findOrFail($request->lang_id);
        User::where('id', auth()->id())->update(['locale' => $lang->url]);
        App::setLocale($lang->url);

        return redirect()->back();
    }
}
