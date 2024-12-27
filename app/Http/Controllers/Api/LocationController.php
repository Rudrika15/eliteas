<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils; // Assuming you have a Utils class for response handling


class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('user')->get();
        if ($locations->isNotEmpty()) {
            return Utils::sendResponse('Location data retrieved successfully', $locations);
        } else {
            return Utils::errorResponse('Location data not found', 404);
        }
    }

    public function userLocation()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve the user's location data
        $location = Location::where('userId', $user->id)
            ->get();

        if ($location->isNotEmpty()) {
            return Utils::sendResponse('Location data retrieved successfully', $location);
        } else {
            return Utils::errorResponse('Location data not found', 404);
        }
    }
}
