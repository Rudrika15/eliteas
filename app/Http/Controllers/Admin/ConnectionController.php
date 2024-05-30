<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
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
        return response()->json(['message' => 'Connection request sent successfully']);
    }

    public function connectionRequests()
    {

        $userId = Auth::user()->id;


        $connections = Connection::whereHas('member', function ($query) use ($userId) {
            $query->where('memberId', $userId);
        })->with('member')
            ->where('status', 'Pending')
            ->get();

        return view('admin.connection.connections', compact('connections'));
    }

    public function myConnections()
    {
        $userId = Auth::id();

        // Fetch connections where the authenticated user is either the userId or memberId
        $connections = Connection::where(function ($query) use ($userId) {
            $query->where('userId', $userId)
                ->orWhere('memberId', $userId);
        })
        ->where('status', 'Accepted')
        ->with(['user:id,firstName,lastName,email'])
        ->get();

        // Include connected user's details for convenience
        $connections->each(function ($connection) {
            $connection->connectedUser = $connection->connected_user;
        });

        return view('admin.connection.myConnection', compact('connections'));
    }



    public function accept($id)
    {
        $connection = Connection::find($id);
        $connection->status = "Accepted";
        $connection->save();
        return \redirect()->route('connection.myConnections')
            ->with('success', 'Accepted Successfully');
    }
    public function reject($id)
    {
        $connection = Connection::find($id);
        $connection->status = "Rejected";
        $connection->save();
        return \redirect()->route('connection.myConnections')
            ->with('success', 'Rejected Successfully');
    }

    public function removeConnection($id)
    {
        $connection = Connection::find($id);
        $connection->delete();
        return \redirect()->route('connection.myConnections')
            ->with('success', 'Connection Removed Succefully');
    }
}
