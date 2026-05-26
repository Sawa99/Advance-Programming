<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Http\Resources\ModuleResource;

class ModuleController extends Controller{
    public function index()
    {
        $modules = Module::all();
        return response()->json($modules);
    }

    public function show($id)
    {
        $module = Module::findOrFail($id);
        return response()->json($module);
    }
}
