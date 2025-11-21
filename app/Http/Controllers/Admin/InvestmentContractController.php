<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvestmentContractController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.investment-contracts.index');
    }
}
