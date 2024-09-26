<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\AppVersion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateAppController extends Controller
{
    public function updateAppVersion(Request $request)
    {
        try {
            // Validate incoming request data
            $validator = Validator::make($request->all(), [
                'version' => 'required|string',
                'major' => 'required|string',
            ]);

            // If validation fails, return error response
            if ($validator->fails()) {
                return Utils::errorResponse(['error' => $validator->errors()], 'Invalid Input', 401);
            }

            $appSettings = AppVersion::first(); // Assuming a single settings record

            if (!$appSettings) {
                return Utils::errorResponse(null, 'App settings not found', 404);
            }

            // Update app version and app URL
            $appSettings->version = $request->version;
            $appSettings->major = $request->major;
            $appSettings->save(); // Persist changes to the database

            return Utils::sendResponse(['success' => 'success'], 'App updated successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function getAppVersion()
    {
        try {
            $appSettings = AppVersion::first(); // Assuming a single settings record
            if (!$appSettings) {
                return Utils::errorResponse(null, 'App settings not found', 404);
            }
            return Utils::sendResponse(['version' => $appSettings->version, 'major' => $appSettings->major], 'App settings fetched successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }
}
