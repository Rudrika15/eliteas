<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{

    public function saveLocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Assuming you have a Location model and the authenticated user is related to the location
        $user = Auth::user();

        // Save the location data to the database
        $location = new Location();
        $location->userId = $user->id; // Use snake_case for column names
        $location->latitude = $validated['latitude'];
        $location->longitude = $validated['longitude'];
        $location->save();

        return response()->json(['message' => 'Location saved successfully'], 200);
    }
}
