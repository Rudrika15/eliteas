<?php

namespace App\Http\Controllers\Admin;

use App\Models\ErrorLog;
use App\Utils\ErrorLogger;
use App\Models\ErrorLogWeb;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorListController extends Controller
{

    // public function __construct()
    // {
    //     // Apply middleware for error log management permissions
    //     $this->middleware('permission:error-view', ['only' => ['index']]);
    //     $this->middleware('permission:error-edit', ['only' => ['updateErrorStatus']]);
    // }


    public function index()
    {
        try {
            $errorList = ErrorLog::orderBy('created_at', 'desc')->paginate(10);
            return view('admin.errorList.index', compact('errorList'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function updateErrorStatus(Request $request, $id)
    {
        try {
            // Try to find the error log by ID
            $errorLog = ErrorLog::find($id);

            if ($errorLog) {
                // Update the status
                $errorLog->status = $request->status;
                $errorLog->save();

                // Return success response
                return response()->json(['success' => true]);
            }

            // If not found, return a 404 response
            return response()->json(['success' => false, 'message' => 'Record not found'], 404);
        } catch (\Throwable $th) {
            // throw $th;
            // Log the exception details for debugging
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            // Return a response with error details
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the status'], 500);
        }
    }

    // public function logError(Request $request)
    // {
    //     try {
    //         // Validate incoming data
    //         $validatedData = $request->validate([
    //             'message' => 'required|string',
    //             'source' => 'required|string',
    //             'lineno' => 'required|integer',
    //             'colno' => 'required|integer',
    //             'url' => 'required|url',
    //             'method' => 'required|string',
    //             'user_agent' => 'required|string',
    //             'ip_address' => 'sometimes|ip', // You can pass the IP address from the frontend if needed
    //         ]);

    //         // Store error details in the database
    //         $errorLogs = new ErrorLogWeb();
    //         $errorLogs->error_message = $validatedData['message'];
    //         $errorLogs->error_file = $validatedData['source'];
    //         $errorLogs->error_line = $validatedData['lineno'];
    //         $errorLogs->url = $validatedData['url'];
    //         $errorLogs->method = $validatedData['method'];
    //         $errorLogs->ip_address = $request->ip(); // Get IP address from request
    //         $errorLogs->user_agent = $validatedData['user_agent'];
    //         $errorLogs->additiona_info = $request->input('additiona_info', 'None'); // Default to 'None' if not provided

    //         $errorLogs->save();

    //         return response()->json(['message' => 'Error logged successfully.'], 201);
    //     } catch (\Exception $exception) {
    //         return response()->json(['error' => 'Failed to log error. ' . $exception->getMessage()], 500);
    //     }
    // }
}
