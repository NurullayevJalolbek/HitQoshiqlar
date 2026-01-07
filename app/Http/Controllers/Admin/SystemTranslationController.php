<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;


class SystemTranslationController extends Controller
{

    public function index(Request $request)
    {



        $languages = Language::orderBy('id')->get();


        $data = [];

        foreach ($languages as $lang) {
            $code = $lang->url;
            $file = base_path("lang/$code/admin.php");
            $data[$code] = file_exists($file) ? include $file : [];
        }


        $baseKeys = array_keys($data['uz'] ?? []);

        return view('pages.system-translations.index', [
            'baseKeys' => $baseKeys,
            'data' => $data,
        ]);
    }


    public function edit(Request $request)
    {
        $key = $request->input('key');

        $languages = Language::orderBy('id')->get();

        $translations = [];

        foreach ($languages as $lang) {
            $file = base_path("lang/{$lang->url}/admin.php");

            if (file_exists($file)) {
                $arr = include $file;
                $translations[$lang->url] = $arr[$key] ?? '';
            } else {
                $translations[$lang->url] = '';
            }
        }

        return response()->json([
            'key' => $key,
            'translations' => $translations,
            'languages' => $languages->map(fn($l) => ['url' => $l->url, 'name' => $l->name]),
        ]);
    }
}
