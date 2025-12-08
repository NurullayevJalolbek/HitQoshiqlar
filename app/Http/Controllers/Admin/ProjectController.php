<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{

    public function index(Request $request)
    {
        return view('pages.projects.index');
    }

    public function  create()
    {
        return view('pages.projects.create');
    }

    public function show(Request $request)
    {
        return view('pages.projects.show');
    }

    public function edit(Request $request, $id)
    {
        $project = (new \App\Http\Controllers\Api\ProjectController)->show($id);

        $project = $project->getData(true)['result'];
        return view('pages.projects.edit', compact('project'));
    }
}
