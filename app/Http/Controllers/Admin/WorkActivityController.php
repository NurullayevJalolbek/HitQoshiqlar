<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkActivityController extends Controller
{
    public function index(){
        return view('pages.performance.index');
    }
}
