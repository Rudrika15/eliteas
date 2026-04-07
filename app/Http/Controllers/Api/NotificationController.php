<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifications;
use App\Utils\ErrorLogger;
use App\Utils\Utils;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // public function notificationIndex(Request $request)
    // {
    //     try {
    //         $notification = Notifications::orderBy('created_at', 'desc')->get();

    //         return Utils::sendResponse(['notification' => $notification], 'Notification Data retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());

    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function notificationIndex(Request $request)
    // {
    //     try {
    //         $userId = Auth::id();

    //         $notifications = Notifications::whereJsonContains('data->memberId', $userId)
    //             ->latest()
    //             ->get();

    //         return Utils::sendResponse(
    //             ['notification' => $notifications],
    //             'Notification Data retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());

    //         return Utils::errorResponse(
    //             ['error' => $th->getMessage()],
    //             'Internal Server Error',
    //             500
    //         );
    //     }
    // }
    public function notificationIndex(Request $request)
    {
        try {
            $userId = Auth::id();

            $notifications = Notifications::all()
                ->filter(function ($item) use ($userId) {
                    $data = json_decode($item->data, true);
                    return isset($data['memberId']) && $data['memberId'] == $userId;
                })
                ->map(function ($item) {
                    $item->data = $item->data;
                    return $item;
                })
                ->values();


            return Utils::sendResponse(
                ['notification' => $notifications],
                'Notification Data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return Utils::errorResponse(
                ['error' => $th->getMessage()],
                'Internal Server Error',
                500
            );
        }
    }
}
