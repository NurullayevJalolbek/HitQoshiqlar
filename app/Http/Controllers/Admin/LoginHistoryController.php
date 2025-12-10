<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginHistoryController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.login-histories.index');
    }


    public function show($id)
    {
        $loginHistoriesData = getLoginHistoriesData($id);

        return response()->json([
            'status' => 'success',
            'data' => $loginHistoriesData,
        ]);
    }
}
