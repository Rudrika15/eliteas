<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Help;
use App\Utils\ErrorLogger;
use App\Utils\Utils;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index(Request $request)
    {
        try {
            $help = Help::where('status', 'Active')->get();
            return Utils::sendResponse(['help' => $help], 'Help Data retrieved successfully', 200);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
