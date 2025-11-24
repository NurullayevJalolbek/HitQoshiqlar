<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find($request->user_id);


        return view('pages.profile.index', [
            'model'=>$user
        ]);
    }
}
