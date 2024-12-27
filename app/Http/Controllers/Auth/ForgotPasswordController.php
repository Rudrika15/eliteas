<?php

namespace App\Http\Controllers\Auth;

use DB;
use Hash;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use App\Utils\ErrorLogger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ForgotPasswordController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showForgetPasswordForm(): View
    {
        try {
            return view('auth.forgetPassword');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitForgetPasswordForm(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users',
            ]);

            $token = Str::random(64);

            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);

            Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            return back()->with('message', 'Email has been sent to your email address!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullurl());
            return view('servererror');
        }
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function showResetPasswordForm($token): View
    {
        try {
            return view('auth.forgetPasswordLink', ['token' => $token]);
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function submitResetPasswordForm(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ]);

            $updatePassword = DB::table('password_resets')
                ->where([
                    'email' => $request->email,
                    'token' => $request->token
                ])
                ->first();

            if (!$updatePassword) {
                return back()->withInput()->with('error', 'Invalid token!');
            }

            $user = User::where('email', $request->email)
                ->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')->where(['email' => $request->email])->delete();

            return redirect('/login')->with('message', 'Your password has been changed!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }
}
