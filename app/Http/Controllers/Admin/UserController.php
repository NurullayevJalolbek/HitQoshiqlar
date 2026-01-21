<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, iUserService $service)
    {
        $datas = $service->index($request);

        return view('pages.users.index', [
            'datas'=> $datas,
        ]);

    }

    public function create(Request $request)
    {
        $go_back = $request->go_back;


        $user = null;
        return view('pages.users.create', compact('user', 'go_back'));
    }

    public function show(Request $request, $id)
    {
        $go_back = $request->go_back;

        $model = getUsersData($id)[0];

        return view('pages.users.show', [
            'model'=> $model,
            'go_back'=> $go_back
        ]);
    }


    public function edit(Request $request, $id)
    {
        $go_back = $request->go_back;


        $user = getUsersData($id)[0];

        return view('pages.users.edit', [
            'user'=>$user,
            'go_back'=>$go_back
        ]);
    }
}
