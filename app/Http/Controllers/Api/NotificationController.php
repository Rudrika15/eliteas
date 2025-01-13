<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Utils\ErrorLogger;
use App\Utils\Utils;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notificationIndex(Request $request)
    {
        try {
            $notification = Notifications::get();
            return Utils::sendResponse(['notification' => $notification], 'Notification Data retrieved successfully', 200);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
