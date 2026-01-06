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

    public function create(Request $request)
    {
        $go_back = $request->go_back;

        return view('pages.roles.create', [
            'go_back'=> $go_back
        ]);
    }

    public function edit(Request $request, $id)
    {
        $go_back = $request->go_back;
        $role = getRolesData($id)[0];


        return view('pages.roles.edit', compact('role', 'go_back'));
    }
}
