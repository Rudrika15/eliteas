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
                ->with(['members' => function ($query) {
                    $query->select('id', 'userId', 'firstName', 'lastName', 'profilePhoto')
                        ->with(['user:id,email']);
                }])->get();

            // check if there are any connections
            if ($connections->isEmpty()) {
                return Utils::sendResponse([], 'No pending connections requests', 200);
            }

            return Utils::sendResponse(['connections' => $connections], 'My Connections Requests retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
    public function ConnectionsRequests(Request $request)
    {
        try {

            $userId = Auth::user()->id;

            $connections = Connection::whereHas('members', function ($query) use ($userId) {
                $query->where('userId', $userId);
            })->where('status', 'Pending')
                ->with(['members' => function ($query) {
                    $query->select('id', 'userId', 'firstName', 'lastName', 'profilePhoto')
                        ->with(['user:id,email']);
                }])
                ->get();

            // check if there are any connections
            if ($connections->isEmpty()) {
                return Utils::sendResponse([], 'No pending connections requests', 200);
            }

            return Utils::sendResponse(['connections' => $connections], 'My Connections Requests retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function myConnections(Request $request)
    {
        try {
            $connections = Connection::where('userId', Auth::user()->id)
                ->where('status', 'Accepted')
                ->with(['members' => function ($query) {
                    $query->select('id', 'userId', 'firstName', 'lastName', 'profilePhoto')
                        ->with(['user:id,email']);
                }])
                ->get();
            return Utils::sendResponse(['connections' => $connections], 'My Connections retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function sendRequest(Request $request)
    {
        try {

            $userId = Auth::user()->id;
            $memberId = $request->input('memberId');

            $isExist = Connection::where('memberId', $memberId)->where('userId', $userId)->first();

            if ($isExist) {
                return Utils::sendResponse(['message' => 'You are already sent the request'], 200);
            }

            $connections = new Connection();
            $connections->memberId = $memberId;
            $connections->userId = $userId;
            $connections->save();

            return Utils::sendResponse([$memberId => $connections, 'message' => 'Connection Request sent Successfully'], 200);
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
                ->with(['user', 'circle', 'connections' => function ($q) {
                    $q->where('userId', Auth::user()->id);
                }])
                ->get()
                ->map(function ($member) {
                    $status = $member->connections->isEmpty() ? null : $member->connections->first()->status;
                    $member['status'] = $status == 'Accepted' ? 'Connected' : ($status == 'Pending' ? 'Pending' : null);
                    unset($member['connections']);
                    return $member;
                });

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

    public function removeConnection(Request $request)
    {
        try {
            $connection = Connection::find($request->input('connectionId'));

            if (!$connection) {
                return Utils::errorResponse(['error' => 'Connection not found.'], 'Not Found', 404);
            }

            $connection->delete();

            return Utils::sendResponse(['message' => 'Connection Removed Successfully.'], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function viewMemberProfile(Request $request)
    {
        try {
            $member = Member::where('id', $request->input('memberId'))
                ->with('user', 'circle', 'billingAddress', 'contactDetails', 'topsProfile')
                ->first();

            return Utils::sendResponse([
                'message' => 'Member Profile',
                'member' => $member
            ], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }
}
