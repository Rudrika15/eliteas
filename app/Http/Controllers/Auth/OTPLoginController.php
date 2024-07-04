<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Otp;
use Carbon\Carbon;

class OTPLoginController extends Controller
{
    // Show the OTP request form
    public function showOTPRequestForm()
    {
        return view('auth.otpRequest');
    }

    // Send OTP to user's mobile number
    public function sendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        // Fetch the user based on phone number
        $user = User::where('contactNo', $request->phone)->first();

        if ($user) {
            try {
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

                // Save OTP and time
                $time = Carbon::now();
                $otpRecord = Otp::where('mobileNo', $request->phone)->first();

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

                return redirect()->route('otp.verify')->with('phone', $request->phone);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        return back()->withErrors(['phone' => 'Phone number not found.']);
    }

    // Show the OTP verification form
    public function showOTPVerificationForm(Request $request)
    {
        $phone = $request->session()->get('phone');
        if (!$phone) {
            return redirect()->route('otp.request');
        }

        return view('auth.otpVerify', ['phone' => $phone]);
    }

    // Verify OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp1' => 'required|digits:1',
            'otp2' => 'required|digits:1',
            'otp3' => 'required|digits:1',
            'otp4' => 'required|digits:1',
            'otp5' => 'required|digits:1',
            'otp6' => 'required|digits:1'
        ]);

        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4 . $request->otp5 . $request->otp6;

        // Fetch the user based on phone number
        $user = User::where('contactNo', $request->phone)->first();
        $otpRecord = Otp::where('mobileNo', $request->phone)->where('otp', $otp)->first();

        if ($user && $otpRecord && Carbon::parse($otpRecord->time)->addMinutes(10)->isFuture()) {
            Auth::login($user);
            return redirect()->intended('/'); // redirect to the intended page after login
        }

        return redirect()->route('otp.verify')->withErrors(['message' => 'Invalid OTP or OTP has expired.']);
    }


    // Resend OTP
    public function resendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        // Fetch the user based on phone number
        $user = User::where('contactNo', $request->phone)->first();

        if ($user) {
            try {
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

                // Save or update OTP and time
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

                // Store the phone number in the session
                Session::put('phone', $request->phone);

                return back()->with('status', 'A new OTP has been sent to your phone.');
            } catch (\Throwable $th) {
                // Log the error for debugging purposes
                // \Log::error($th);

                // Return back with an error message
                return back()->withErrors(['error' => 'There was an error sending the OTP. Please try again later.']);
            }
        } else {
            return back()->withErrors(['phone' => 'Phone number not found.']);
        }
    }
}
