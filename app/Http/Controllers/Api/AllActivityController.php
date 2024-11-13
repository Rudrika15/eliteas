<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SpecificAsk;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\Member;
use App\Models\CircleCall;
use Carbon\Carbon;

class AllActivityController extends Controller
{
    public function ibmVp(Request $request)
    {
        try {
            $userId = auth()->user()->id;

            // Get member.id and circleId based on the authenticated user's id
            $member = Member::select('id', 'circleId')
                ->where('userId', $userId)
                ->first();

            if (!$member) {
                return Utils::errorResponse([], 'Member not found', 404);
            }

            $circleId = $member->circleId;

            // Get start and end dates from request
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Fetch circle calls with optional date filtering
            $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                ->where('status', 'Active')
                ->whereHas('member', function ($query) use ($circleId) {
                    $query->where('circleId', $circleId);
                })
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date', [$startDate, $endDate]);
                })
                ->get();

            return Utils::sendResponse(['circlecalls' => $circlecalls], 'Circle Calls retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function refrenceVp(Request $request)
    {
        try {
            $userId = auth()->user()->id;

            // Get member.id and circleId based on the authenticated user's id
            $member = Member::select('id', 'circleId')
                ->where('userId', $userId)
                ->first();

            if (!$member) {
                return Utils::errorResponse([], 'Member not found', 404);
            }

            $circleId = $member->circleId;

            // Query references with optional date filtering
            $query = CircleMeetingMembersReference::with(['members'])
                ->where('status', 'Active')
                ->whereHas('members', function ($query) use ($circleId) {
                    $query->where('circleId', $circleId);
                });

            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $references = $query->get();

            return Utils::sendResponse(['references' => $references], 'References retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function businessVp(Request $request)
    {
        try {
            $userId = auth()->user()->id;

            // Get member.id and circleId based on the authenticated user's id
            $member = Member::select('id', 'circleId')
                ->where('userId', $userId)
                ->first();

            if (!$member) {
                return Utils::errorResponse([], 'Member not found', 404);
            }

            $circleId = $member->circleId;

            // Query businesses with optional date filtering
            $query = CircleMeetingMembersBusiness::with(['members'])
                ->where('status', 'Active')
                ->whereHas('member', function ($query) use ($circleId) {
                    $query->where('circleId', $circleId);
                });

            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $businesses = $query->paginate(10);

            return Utils::sendResponse(['businesses' => $businesses], 'Businesses retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
