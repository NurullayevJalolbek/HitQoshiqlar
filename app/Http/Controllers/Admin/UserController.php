<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.users.index');
    }

    public function create()
    {
        return view('pages.users.create');
    }
}
