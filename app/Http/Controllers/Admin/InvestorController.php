<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.investors.index');
    }


    public function show($id)
    {
        $investor = getInvestorsData($id);

        return view('pages.investors.show', compact('investor'));
    }
}
