<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required|string|min:6',
                'confirmPassword' => 'required|string|same:newPassword',
            ]);

            // Check if the current password matches the stored password
            if (!Hash::check($request->currentPassword, Auth::user()->password)) {
                return Utils::errorResponse(
                    ['currentPassword' => 'The current password does not match our records.'],
                    'Validation Error',
                    422
                );
            }

            // Update the user's password
            $user = Auth::user();
            $user->password = Hash::make($request->newPassword);
            $user->save();

            // Return a success response
            return Utils::sendResponse(
                null,
                'Password successfully changed!',
                200
            );
        } catch (\Throwable $th) {
            // Handle any errors that occur during the process
            return Utils::errorResponse(
                ['error' => $th->getMessage()],
                'Internal Server Error',
                500
            );
        }
    }
}
