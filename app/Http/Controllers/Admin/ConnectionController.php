<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\Connection;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{

    public function __construct()
    {
        // Apply middleware for connection-related permissions
        $this->middleware('permission:connection-connect', ['only' => ['connect']]);
        $this->middleware('permission:connection-requests', ['only' => ['connectionRequests']]);
        $this->middleware('permission:connection-view', ['only' => ['myConnections']]);
        $this->middleware('permission:connection-accept', ['only' => ['accept']]);
        $this->middleware('permission:connection-reject', ['only' => ['reject']]);
        $this->middleware('permission:connection-remove', ['only' => ['removeConnection']]);
    }


    public function connect(Request $request)
    {
        $memberId = $request->input('memberId');
        $userId = Auth::user()->id;

        // $connection = Connection::where('memberId', $memberId)
        //     ->orWhere('userId', $userId)
        //     ->first();

        //     if ($connection) {

        //         return response()->json(['message' => 'You are already sent']);
        //     }

        $connection = new Connection();
        $connection->memberId = $memberId;
        $connection->userId = $userId;
        $connection->save();

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Connection request sent successfully!'
        ]);
    }

    public function connectionRequests()
    {
        try {
            // Get the authenticated user's ID
            $userId = Auth::user()->id;

            // Query to get connection requests
            $connections = Connection::whereHas('member', function ($query) use ($userId) {
                $query->where('memberId', $userId);
            })
                ->with('member')
                ->where('status', 'Pending')
                ->paginate(10);

            // Return the view with the connections data
            return view('admin.connection.connections', compact('connections'));
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a custom error view or redirect with an error message
            return view('servererror');
        }
    }


    // public function myConnections()
    // {
    //     $userId = Auth::id();

    //     // Fetch connections where the authenticated user is either the userId or memberId
    //     $connections = Connection::where(function ($query) use ($userId) {
    //         $query->where('userId', $userId)
    //             ->orWhere('memberId', $userId);
    //     })
    //         ->where('status', 'Accepted')
    //         ->with(['user:id,firstName,lastName,email'])
    //         ->paginate(10);

    //     // Include connected user's details for convenience
    //     $connections->each(function ($connection) {
    //         $connection->connectedUser = $connection->connected_user;
    //     });

    //     return view('admin.connection.myConnection', compact('connections'));
    // }
    public function myConnections()
    {
        try {
            $userId = Auth::id();

            // Fetch connections where the authenticated user is either the userId or memberId
            $connections = Connection::where(function ($query) use ($userId) {
                $query->where('userId', $userId)
                    ->orWhere('memberId', $userId);
            })
                ->where('status', 'Accepted')
                ->with(['user:id,firstName,lastName,email'])
                ->paginate(10);

            // Include connected user's details for convenience
            $connections->each(function ($connection) {
                $connection->connectedUser = $connection->connected_user;
            });

            // Fetch circleId from member table based on the userId
            $circleId = Member::where('userId', $userId)->pluck('circleId')->first();

            // Fetch all members with the same circleId
            $myConnections = Member::where('circleId', $circleId)->where('userId', '!=', $userId)->paginate(10);

            return view('admin.connection.myConnection', compact('connections', 'myConnections'));
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, request()->fullUrl());

            return view('servererror');
        }
    }




    public function accept($id)
    {
        try {
            $connection = Connection::findOrFail($id);

            $connection->status = "Accepted";
            $connection->save();

            return redirect()->route('connection.myConnections')
                ->with('success', 'Accepted Successfully');
        } catch (\Throwable $th) {
            // throw $th;

            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('connection.myConnections')
                ->with('error', 'Failed to accept connection.');
        }
    }

    public function reject($id)
    {
        try {
            $connection = Connection::findOrFail($id);

            $connection->status = "Rejected";
            $connection->save();

            return redirect()->route('connection.myConnections')
                ->with('success', 'Rejected Successfully');
        } catch (\Throwable $th) {
            // throw $th;

            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('connection.myConnections')
                ->with('error', 'Failed to reject connection.');
        }
    }

    public function removeConnection($id)
    {
        try {
            $connection = Connection::findOrFail($id);

            $connection->delete();

            return redirect()->route('connection.myConnections')
                ->with('success', 'Connection Removed Successfully');
        } catch (\Throwable $th) {
            // throw $th;

            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('connection.myConnections')
                ->with('error', 'Failed to remove connection.');
        }
    }
}
