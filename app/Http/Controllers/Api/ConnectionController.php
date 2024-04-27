<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Connection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function myConnections(Request $request)
    {
        try {
            $connections = Connection::where('userId', Auth::user()->id)->get();
            return Utils::sendResponse(['connections' => $connections], 'My Connections retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
