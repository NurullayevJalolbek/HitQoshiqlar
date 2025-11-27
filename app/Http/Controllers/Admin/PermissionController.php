<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.permissions.index');
    }

    public function show(Request $request)
    {
        return view('pages.permissions.show');
    }
}
