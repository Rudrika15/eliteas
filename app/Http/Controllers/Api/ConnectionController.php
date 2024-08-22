<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
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
            $userId = Auth::user()->id;


            $connections = Connection::where('memberId', $userId)
                ->where('status', 'Pending')
                ->with([
                    'user' => function ($query) {
                        $query->select('id', 'email', 'firstName', 'lastName');
                    },
                    'members' => function ($query) {
                        $query->select('id', 'userId', 'profilePhoto');
                    }
                ])
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
    public function ConnectionsRequests(Request $request)
    {
        try {

            $userId = Auth::user()->id;


            $connections = Connection::where('memberId', $userId)
                ->where('status', 'Pending')
                ->with([
                    'user' => function ($query) {
                        $query->select('id', 'email', 'firstName', 'lastName');
                    },
                    'members' => function ($query) {
                        $query->select('id', 'userId', 'profilePhoto');
                    }
                ])
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
            $userId = Auth::id();

            // Fetch connections where the authenticated user is either the userId or memberId
            $connections = Connection::where(function ($query) use ($userId) {
                $query->where('userId', $userId)
                    ->orWhere('memberId', $userId);
            })
                ->where('status', 'Accepted')
                // ->with(['user:id,firstName,lastName,email', 'member:id,userId,profilePhoto'])
                ->with(['member' => function ($query) {
                    $query->select('id', 'userId', 'profilePhoto')
                        ->with('user:id,email,firstName,lastName');
                }])
                ->get();

            // Include connected user's details for convenience
            // $connections->each(function ($connection) {
            //     $connection->connectedUser = $connection->connected_user;
            // });
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
            $connections->status = 'Pending';
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
            $members = User::whereHas('member', function ($q) use ($find) {
                $q->where('firstName', 'like', '%' . $find . '%')
                    ->orWhere('lastName', 'like', '%' . $find . '%')
                    ->orWhereHas('circle', function ($q) use ($find) {
                        $q->where('circleName', 'like', '%' . $find . '%');
                    });
            })
                ->with(['member', 'member.circle', 'member.connections' => function ($q) {
                    $q->where('userId', Auth::user()->id);
                }])
                ->get();
            // ->map(function ($member) {
            //     $connection = $member->connections->first();
            //     $status = $connection ? $connection->status : null;
            //     $member['status'] = $status == 'Accepted' ? 'Connected' : ($status == 'Pending' ? 'Pending' : null);
            //     // unset($member['connections']);
            //     return $member;
            // });

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

            $member = Member::where('userId', $request->input('userId'))
                ->with('user', 'circle', 'billingAddress', 'contactDetails', 'topsProfile', 'connections', 'bCategory')
                ->first();

            if ($member) {
                // Determine the status of the connection
                $status = $member->connections->isEmpty() ? null : $member->connections->first()->status;
                $member->status = $status == 'Accepted' ? 'Connected' : ($status == 'Pending' ? 'Pending' : null);

                // Get businessCategoryName
                $member->businessCategoryName = $member->bCategory ? $member->bCategory->categoryName : null;
            }

            return Utils::sendResponse([
                'message' => 'Member Profile',
                'connectionStatus ' => $member ? $member->connections->first() : null,
                'member' => $member
            ], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }
}
