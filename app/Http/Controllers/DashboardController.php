<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $path = public_path('assets/data/dashboard-data.json');

        if (!File::exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'Dashboard data file topilmadi'
            ], 404);
        }

        $data = json_decode(File::get($path), true);

        return success_response($data);
    }
}
