<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvestmentProjectController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.investment-projects.index');
    }
}
