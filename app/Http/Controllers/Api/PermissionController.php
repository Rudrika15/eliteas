<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        try {

            $permissions = Permission::where('status', 'Active')->get();

            return Utils::sendResponse([$permissions], 'Permissions retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function rolePermission(Request $request)
    {
        try {

            $permissions = Permission::with('roles:id,name')->where('status', 'Active')->get();

            return Utils::sendResponse([$permissions], 'Permissions retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function getRole(Request $request)
    {
        try {
            $role = Role::select('id', 'name')->with('permissions')->get();
            return Utils::sendResponse(['role' => $role], 'Role retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }
}
