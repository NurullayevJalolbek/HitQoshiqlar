<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


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

    public function list(Request $request)
    {
        $path = public_path('assets/data/projects.json');

        if (!file_exists($path)) {
            return success_response([]);
        }

        $data = json_decode(file_get_contents($path), true);

        return success_response($data);
    }

    public function store(Request $request)
    {
        $path = public_path('assets/data/projects.json');

        $data = file_exists($path)
            ? json_decode(file_get_contents($path), true)
            : [];

        $newProject = $request->all();

        $newProject['id'] = uniqid('prj_');
        $newProject['created_at'] = now()->toDateTimeString();

        $data[] = $newProject;

        file_put_contents(
            $path,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return success_response($newProject, 'Successfully created');
    }

    public function update(Request $request, $id)
    {
        $path = public_path('assets/data/projects.json');

        if (!file_exists($path)) {
            return error_response('Data file not found', 404);
        }

        $data = json_decode(file_get_contents($path), true);

        $found = false;

        foreach ($data as &$item) {
            if (($item['id'] ?? null) === $id) {
                $item = array_merge($item, $request->all());
                $item['updated_at'] = now()->toDateTimeString();
                $found = true;
                break;
            }
        }

        if (!$found) {
            return error_response('Project not found', 404);
        }

        file_put_contents(
            $path,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return success_response('Successfully updated');
    }

    public function show($id)
    {
        $path = public_path('assets/data/projects.json');

        if (!file_exists($path)) {
            return error_response('Data file not found', 404);
        }

        $data = json_decode(file_get_contents($path), true);

        foreach ($data as $item) {
            if (($item['id'] ?? null) == $id) {
                return success_response($item);
            }
        }

        // DEBUG uchun ID-larni ko‘rsatamiz
        return error_response(
            "Project not found. Existing IDs: " . implode(', ', array_column($data, 'id')),
            404
        );
    }


    public function destroy($id)
    {
        $path = public_path('assets/data/projects.json');

        if (!file_exists($path)) {
            return error_response('Data file not found', 404);
        }

        $data = json_decode(file_get_contents($path), true);

        $filtered = array_values(array_filter($data, function ($item) use ($id) {
            return ($item['id'] ?? null) !== $id;
        }));

        file_put_contents(
            $path,
            json_encode($filtered, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return success_response('Successfully deleted');
    }


}
