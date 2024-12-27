<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:permission-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['delete']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::where('status', 'Active')->paginate(10);
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->heading = $request->heading;
        $permission->status = 'Active';
        $permission->save();

        return redirect()->route('permission.create');
        // return redirect()->route('permission.create')->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::find($id);
        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $id = $request->id;

        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->heading = $request->heading;
        $permission->save();
        return redirect()->route('permission.index')->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        $permission->status = 'Deleted';
        $permission->save();
        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully');
    }
}
