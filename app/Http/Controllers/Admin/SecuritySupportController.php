<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SecuritySupportController extends Controller
{
    public function index(Request $request)
    {
        $go_back = $request->go_back;

        return view('pages.security-support.index', [
            'go_back'=> $go_back
        ]);
        
    }
}
