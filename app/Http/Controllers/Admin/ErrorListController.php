<?php

namespace App\Http\Controllers\Admin;

use App\Models\ErrorLog;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorListController extends Controller
{
    public function index()
    {
        try {
            $errorList = ErrorLog::orderBy('created_at', 'desc')->paginate(5);
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
}
