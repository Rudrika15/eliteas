<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Member;
use App\Models\Connection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function receivedConnectionsRequests(Request $request)
    {
        try {
            $connections = Connection::where('userId', Auth::user()->id)
            ->where('status', 'Pending')
            ->get();
            return Utils::sendResponse(['connections' => $connections], 'My Connections retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
    public function myConnections(Request $request)
    {
        try {
            $connections = Connection::where('userId', Auth::user()->id)
            ->where('status', 'Accepted')
            ->get();
            return Utils::sendResponse(['connections' => $connections], 'My Connections retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function sendRequest(Request $request)
    {
        try{

            $userId = Auth::user()->id;
            $memberId = $request->input('memberId');

            $connections = new Connection();
            $connections->memberId = $memberId;
            $connections->userId = $userId;
            $connections->save();

            return Utils::sendResponse(['message' => 'Connection Request sent Successfully'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function search(Request $request)
    {
        try {
            $find = $request->input('find');
            $members = Member::where('firstName', 'like', '%' . $find . '%')
                ->orWhere('lastName', 'like', '%' . $find . '%')
                ->orWhereHas('circle', function ($q) use ($find) {
                    $q->where('circleName', 'like', '%' . $find . '%');
                })
                ->with('user', 'circle')
                ->get();

            $message = "Search results for '$find'";

            return Utils::sendResponse([
                'message' => $message,
                'members' => $members
            ], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }

    public function requestAction(Request $request)
    {
        try {
            $connection = Connection::find($request->input('connectionId'));
            $connection->status = $request->input('action');
            $connection->save();
            return Utils::sendResponse(['message' => 'Connection Request Action done Successfully.'], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }



    
}
