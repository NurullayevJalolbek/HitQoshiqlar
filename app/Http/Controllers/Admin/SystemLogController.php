<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.system-logs.index');
    }


    public function show($id)
    {
        $datas  = getSystemLogsData($id);

        return response()->json([
            'data'=> $datas,
            'success' => true,

        ]);
    }
}
