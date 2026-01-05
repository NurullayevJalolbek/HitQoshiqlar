<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntegrationSettingController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.integration-settings.index');
    }

    public function edit($id)
    {
        $integration = getIntegrationSettings($id);


        return view('pages.integration-settings.edit', compact('integration'));
    }
}
