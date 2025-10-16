<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\UserModule;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allModules = Module::all(['id', 'name', 'description']);
        return response()->json($allModules);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function activate(Request $request, Module $module)
    {
        $moduleId = $module->id;
        $realModule = Module::findOrfail($moduleId);
        if (!$realModule) {
            return response()->json([], 400);
        }

        $userId = $request->user()->id;

        UserModule::updateOrcreate(
            [
                "user_id" => $userId,
                "module_id" => $moduleId
            ],
            [
                "active" => true
            ]
        );

        return response()->json([
            'message' => "Module activated"
        ]);
    }

    public function deactivate(Request $request, Module $module)
    {
        $moduleId = $module->id;
        $realModule = Module::findOrfail($moduleId);
        if (!$realModule) {
            return response()->json([], 400);
        }

        $userId = $request->user()->id;

        UserModule::updateOrcreate(
            [
                "user_id" => $userId,
                "module_id" => $moduleId
            ],
            [
                "active" => false
            ]
        );

        return response()->json([
            'message' => "Module deactivated"
        ]);
    }
}
