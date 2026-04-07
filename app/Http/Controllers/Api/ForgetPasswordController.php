<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ForgetPasswordController extends Controller
{
    /**
     * Initiate forgot password process.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->errors()->has('email')) {
                return Utils::errorResponse('Invalid email address. Please enter the correct email', 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return Utils::errorResponses(['error' => 'Account Not Found'], 'Invalid email address. Please enter the correct email');
            }

            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]);

            Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return response()->json([
                'message' => 'We have e-mailed your password reset link!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 404);
        }
    }


    /**
     * Reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|exists:users,email',
    //         'password' => 'required|string|min:6|confirmed',
    //         'password_confirmation' => 'required',
    //         'token' => 'required|string|exists:password_resets,token',
    //     ]);

    //     $updatePassword = DB::table('password_resets')
    //         ->where('email', $request->email)
    //         ->where('token', $request->token)
    //         ->first();

    //     if (!$updatePassword) {
    //         return response()->json(['error' => 'Invalid token!'], 400);
    //     }

    //     DB::table('users')
    //         ->where('email', $request->email)
    //         ->update(['password' => Hash::make($request->password)]);

    //     DB::table('password_resets')
    //         ->where('email', $request->email)
    //         ->delete();

    //     return response()->json(['message' => 'Your password has been changed!']);
    // }
}
