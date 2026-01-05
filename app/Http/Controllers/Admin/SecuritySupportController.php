<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SecuritySupportController extends Controller
{
    public function index()
    {
        return view('pages.security-support.index');
        
    }
}
