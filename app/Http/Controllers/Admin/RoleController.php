<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.roles.index');
    }

    public function create()
    {
        return view('pages.roles.create');
    }

    public function edit($id)
    {
        $role = getRolesData($id)[0];


        return view('pages.roles.edit', compact('role'));
    }
}
