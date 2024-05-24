<?php

namespace App\Http\Controllers\Api;

use App\Models\AllPayments;
use Illuminate\Http\Request;
use App\Models\MemberSubscriptions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MyPaymentController extends Controller
{
    public function myPaymentHistory(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $payments = AllPayments::where('memberId', $userId)
                ->where('status', 'Active')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $payments,
                'message' => 'Payments retrieved successfully'
            ], 200);
        } catch (\Throwable $th) {
            // Log the error for debugging
            Log::error('Error retrieving payments:', ['error' => $th->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error. Please try again later.'
            ], 500);
        }
    }

    // public function myPaymentHistory(Request $request)
    // {
    //     try {
    //         $userId = $request->user()->id;
    //         $payments = AllPayments::where('userId', $userId)
    //             ->where('status', 'Active')
    //             ->get();

    //         return response()->json([
    //             'success' => true,
    //             'data' => $payments,
    //             'message' => 'Payments retrieved successfully'
    //         ], 200);
    //     } catch (\Illuminate\Database\QueryException $ex) {
    //         // Log the error for debugging
    //         Log::error('Database query error retrieving payments:', ['error' => $ex->getMessage()]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Database query error. Please try again later.'
    //         ], 500);
    //     } catch (\Exception $ex) {
    //         // Log the error for debugging
    //         Log::error('General error retrieving payments:', ['error' => $ex->getMessage()]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Server error. Please try again later.'
    //         ], 500);
    //     } catch (\Throwable $th) {
    //         // Log the error for debugging
    //         Log::error('Unexpected error retrieving payments:', ['error' => $th->getMessage()]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Unexpected error. Please try again later.'
    //         ], 500);
    //     }
    // }

}
