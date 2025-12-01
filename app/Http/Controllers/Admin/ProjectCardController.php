<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectCardController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.project-cards.index');
    }

    public function show(Request $request, $id)
    {
        return view('pages.project-cards.show');
    }
}
