<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        try {
            // Remove all spaces from password inputs
            if ($request->has('newPassword')) {
                $request->merge(['newPassword' => preg_replace('/\s+/', '', $request->newPassword)]);
            }
            if ($request->has('confirmPassword')) {
                $request->merge(['confirmPassword' => preg_replace('/\s+/', '', $request->confirmPassword)]);
            }

            // Validate the request
            $request->validate([
                'currentPassword' => 'required',
                'newPassword' => 'required|string|min:6',
                'confirmPassword' => 'required|string|same:newPassword',
            ]);
            // Check if the current password matches the stored password
            if (! Hash::check($request->currentPassword, Auth::user()->password)) {
                return Utils::errorResponse(
                    ['currentPassword' => 'The current password does not match our records.'],
                    'Validation Error',
                    422
                );
            }
            $user = Auth::user();

            // Check for both Circle Member and Digital Member roles
            if (! $user || (! $user->hasRole('Member') && ! $user->hasRole('Digital Member'))) {
                return Utils::errorResponse(
                    ['error' => 'Unauthorized. Password change is allowed for Circle Members and Digital Members only.'],
                    'Unauthorized',
                    403
                );
            }

            $newPassword = $request->newPassword;

            // Update the user's password
            $user->password = Hash::make($newPassword);
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
