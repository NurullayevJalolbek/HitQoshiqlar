<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $go_back = $request->go_back;

        return view('pages.permissions.show', compact('go_back'));
    }

    public function show(Request $request)
    {
        return view('pages.permissions.show');
    }
}
