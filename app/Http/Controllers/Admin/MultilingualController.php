<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MultilingualController extends Controller
{
    public function index()
    {
        return view('pages.multimedia.index');
    }



    public function edit(Request $request)
    {
        $id = $request->input('id');

        $data = getMediaItems($id);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
