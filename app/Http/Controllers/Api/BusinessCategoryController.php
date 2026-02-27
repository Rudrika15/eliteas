<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Utils\Utils;
use Illuminate\Http\Request; // Assuming you have a Utils class for response handling

class BusinessCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $businessCategory = BusinessCategory::where('status', 'Active')->get();

            return Utils::sendResponse(['businessCategory' => $businessCategory], 'Business Category Retrieved Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
