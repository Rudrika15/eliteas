<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OTPLoginController extends Controller
{
    // Send OTP to user's mobile number
    public function sendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        try {
            // Fetch the user based on phone number
            $user = User::where('contactNo', $request->phone)->first();

            if ($user) {
                $apiKey = urlencode('0c5ff664-819f-48f1-a22c-d5894e9fba3b');
                // Generate OTP
                $otp = random_int(100000, 999999);
                $numbers = $request->phone;
                $sender = urlencode('DGSAPI');
                $message = "Your One Time Verification Password is {$otp}.";
                $username = "BrandBeans";
                $smstype = "TRANS";

                // Prepare data for POST request
                $data = array(
                    'apikey' => $apiKey,
                    'numbers' => $numbers,
                    "sender" => $sender,
                    "message" => $message,
                    "username" => $username,
                    "sendername" => $sender,
                    "smstype" => $smstype,
                );

                // Send the POST request with cURL
                $ch = curl_init('http://sms.hspsms.com/sendSMS');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                // Send the POST request with Laravel HTTP client
                $response = Http::post('http://sms.hspsms.com/sendSMS', $data);

                // Save OTP and time
                $time = Carbon::now();
                $otpRecord = Otp::where('mobileno', $request->phone)->first();

                if ($otpRecord) {
                    // Update existing OTP record
                    $otpRecord->otp = $otp;
                    $otpRecord->time = $time;
                    $otpRecord->save();
                } else {
                    // Create new OTP record if none exists (fallback)
                    $otpRecord = new Otp();
                    $otpRecord->otp = $otp;
                    $otpRecord->mobileno = $request->phone;
                    $otpRecord->time = $time;
                    $otpRecord->save();
                }

                return Utils::sendResponse(['otp' => $otp], 'OTP sent successfully', 200);
            }

            // Return error response if user not found
            return Utils::errorResponse(['error' => 'User not found'], 'User not found', 404);
        } catch (\Throwable $th) {
            // Return error response for unexpected errors
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // Verify OTP
public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required'
        ]);

        try {
            // Fetch the user based on phone number
            $user = User::where('contactNo', $request->phone)->first();
            $otpRecord = Otp::where('mobileNo', $request->phone)->where('otp', $request->otp)->first();

            if ($user && $otpRecord && Carbon::parse($otpRecord->time)->addMinutes(10)->isFuture()) {
                Auth::login($user);
                $token = $user->createToken('AuthToken')->plainTextToken; // Generate auth token
                return Utils::sendResponse([
                    'user' => $user->only([
                        'id',
                        'firstName',
                        'lastName',
                        'email',
                        'contactNo',
                    ]),
                    'token' => $token // Include auth token in the response
                ], 'OTP verification successful', 200);
            }

            return Utils::errorResponse(['otp' => 'Invalid OTP or phone number, or OTP has expired.'], 'OTP verification failed', 400);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
