<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Member;
use App\Models\Circle;

class CityCountController extends Controller
{
    public function getCityCount()
    {
       
        $memberCities = Member::distinct()->pluck('cityId');
        $circleCities = Circle::distinct()->pluck('cityId');
        $allCities = $memberCities->merge($circleCities)->unique();
        $cityCount = $allCities->count();
        return response()->json([
            'status' => true,
            'city_count' => $cityCount,
        ]);
    }
}
