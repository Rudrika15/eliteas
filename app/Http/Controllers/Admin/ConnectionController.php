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

        $connection = new Connection();
        $connection->memberId = $memberId;
        $connection->userId = $userId;
        $connection->save();
        return response()->json(['message' => 'Connection request processed successfully']);
    }

    public function myConnections()
    {

        $userId = Auth::user()->id;

        $connections = Connection::whereHas('members', function ($query) use ($userId) {
            $query->where('userId', $userId);
        })->with('members')
            ->get();

        return view('connections', compact('connections'));
    }
    public function accept($id)
    {
        $connection = Connection::find($id);
        $connection->status = "Accepted";
        $connection->save();
        return \redirect()->route('connection.index')
            ->with('success', 'Accepted Successfully');
    }
    public function reject($id)
    {
        $connection = Connection::find($id);
        $connection->status = "Rejected";
        $connection->save();
        return \redirect()->route('connection.index')
            ->with('success', 'Rejected Successfully');
    }
}
