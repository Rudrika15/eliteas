<?php

namespace App\Http\Controllers\Auth;

use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    //
    public function showChangePasswordForm()
    {
        try {
            return view('auth.changePassword');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Check if current password matches
            if (!Hash::check($request->current_password, Auth::user()->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'The current password is not matched with our records.',
                ]);
            }

            // Check if current password is same as new password
            if (Hash::check($request->password, Auth::user()->password)) {
                throw ValidationException::withMessages([
                    'password' => 'The new password must be different from the last password',
                ]);
            }

            // Change Password
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Password successfully changed!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
