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
        $user = null;
        return view('pages.users.create', compact('user'));
    }

    public function show($id)
    {
        $model = getUsersData($id)[0];

        return view('pages.users.show', compact('model'));
    }


    public function edit($id)
    {
        $user = getUsersData($id)[0];

        return view('pages.users.edit', compact('user'));
    }
}
