<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.revenues.index');
    }

    public function show(Request $request, $id)
    {
        return view('pages.revenues.show');
    }
}
