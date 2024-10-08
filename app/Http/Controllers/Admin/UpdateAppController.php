<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppVersion;
use Illuminate\Http\Request;

class UpdateAppController extends Controller
{

    public function edit()
    {
        $updateApp = AppVersion::first();
        return view('admin.updateApp.edit', compact('updateApp'));
    }

    public function updateAppVersion(Request $request)
    {
        $updateApp = AppVersion::first();
        $id = $updateApp->id;
        $updateApp->version = $request->version;
        $updateApp->major = $request->major;
        $updateApp->save();

        // Flash success message to the session
        session()->flash('success', 'App version updated successfully!');

        return view('admin.updateApp.edit', compact('updateApp'));
    }
}
