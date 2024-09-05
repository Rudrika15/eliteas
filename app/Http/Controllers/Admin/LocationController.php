<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{

    public function saveLocation(Request $request)
    {
        try {
            // Validate the request input
            $validated = $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            // Get the authenticated user
            $user = Auth::user();

            // Check if a location for the current user already exists
            $location = Location::where('userId', $user->id)->first();

            if ($location) {
                // If the location exists, update the latitude and longitude
                $location->latitude = $validated['latitude'];
                $location->longitude = $validated['longitude'];
                $location->save();
            } else {
                // If no location exists, create a new one
                $location = new Location();
                $location->userId = $user->id; // Use snake_case for column names
                $location->latitude = $validated['latitude'];
                $location->longitude = $validated['longitude'];
                $location->save();
            }

            // Return a success response
            return response()->json(['message' => 'Location saved successfully'], 200);
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, $request->fullUrl());

            // Return an error response
            return response()->json(['message' => 'Failed to save location'], 500);
        }
    }
}
