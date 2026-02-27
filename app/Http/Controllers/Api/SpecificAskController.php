<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SpecificAsk;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class SpecificAskController extends Controller
{
    public function allIndexApi()
    {
        try {
            $specificasks = SpecificAsk::with('users:id,firstName,lastName')->where('status', 'Active')->get();

            return Utils::sendResponse(['specificasks' => $specificasks], 'Specific Ask retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function indexApi()
    {
        try {
            $specificasks = SpecificAsk::where('askBy', Auth::user()->id)->with('users:id,firstName,lastName')->where('status', 'Active')->get();

            return Utils::sendResponse(['specificasks' => $specificasks], 'Specific Ask retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function createApi(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'ask' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
    //     }

    //     try {
    //         $specificAsk = new SpecificAsk();
    //         $specificAsk->askBy = Auth::id();
    //         $specificAsk->ask = $request->ask;
    //         $specificAsk->status = "Active";
    //         $specificAsk->save();

    //         return Utils::sendResponse(['specificAsk' => $specificAsk], 'Specific Ask Created Successfully', 201);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function createApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ask' => 'required|string',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $specificAsk = new SpecificAsk;
            $specificAsk->askBy = Auth::id();
            $specificAsk->ask = $request->ask;
            $specificAsk->status = 'Active';
            $specificAsk->save();

            // Send notification to all users
            $users = User::whereNotNull('fcm_token')->get();
            $title = 'Specific Ask';
            $body = 'A new specific ask has been Posted by '.Auth::user()->firstName.' '.Auth::user()->lastName;

            $serviceAccountPath = storage_path('app/public/ubn_notification.json');
            $factory = (new Factory)->withServiceAccount($serviceAccountPath);
            $messaging = $factory->createMessaging();

            foreach ($users as $user) {
                $message = CloudMessage::withTarget('token', $user->fcm_token)
                    ->withNotification(Notification::create($title, $body));

                try {
                    $messaging->send($message);
                    Log::info('Notification sent to token: '.$user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Log::error('Token not found: '.$user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
                    Log::error('Invalid argument error with token: '.$user->fcm_token);
                } catch (\Exception $e) {
                    Log::error('General error sending to token: '.$user->fcm_token.'. Error: '.$e->getMessage());
                }
            }

            return Utils::sendResponse(['specificAsk' => $specificAsk], 'Specific Ask Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function updateApi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ask' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $specificasks = SpecificAsk::find($id);

            if (! $specificasks) {
                return Utils::errorResponse(['error' => 'Ask not found.'], 'Not Found', 404);
            }

            $specificasks->askBy = Auth::user()->id;
            $specificasks->ask = $request->ask;
            $specificasks->status = 'Active';
            $specificasks->save();

            return Utils::sendResponse(['specificasks' => $specificasks], 'Ask Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function deleteApi(Request $request, $id)
    {
        try {
            $specificasks = SpecificAsk::find($id);

            if (! $specificasks) {
                return Utils::errorResponse(['error' => 'ask not found.'], 'Not Found', 404);
            }

            $specificasks->status = 'Deleted';
            $specificasks->save();

            return Utils::sendResponse([], 'Ask Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
