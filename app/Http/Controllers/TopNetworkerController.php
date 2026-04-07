<?php

namespace App\Http\Controllers;

use App\Models\CircleMeetingMembersBusiness;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopNetworkerController extends Controller
{
    public function index()
    {
        // Top Influencers (Inductions > 8)
        // Using 'sponsees' relationship which counts members sponsored by this member
        $topInfluencers = Member::withCount('sponsees')
            ->having('sponsees_count', '>', 4)
            ->orderByDesc('sponsees_count')
            ->with(['circle', 'bCategory'])
            ->where('status', 'Active')
            ->get();

        // Crorepati Givers (Business Given > 1 Crore)
        // Group by businessGiverId and sum amount
        // businessGiverId in CircleMeetingMembersBusiness corresponds to userId in Member table
        // We need to fetch the member details using the relationship
        $crorepatiGiversRaw = CircleMeetingMembersBusiness::select('businessGiverId', DB::raw('SUM(amount) as total_amount'))
            ->where('status', 'Active')
            ->groupBy('businessGiverId')
            ->having('total_amount', '>', 10000000)
            ->orderByDesc('total_amount')
            ->with(['businessGiverMember' => function ($query) {
                // businessGiverMember relation in CircleMeetingMembersBusiness model links to Member via userId
                $query->select('id', 'userId', 'firstName', 'lastName', 'profilePhoto', 'companyName', 'circleId', 'businessCategoryId');
                $query->with('circle:id,circleName', 'bCategory:id,categoryName');
            }])
            ->get();

        // Filter out if member is null (e.g. user deleted but business record exists)
        // And attach the member object to the item for easier access in view if needed
        $crorepatiGivers = $crorepatiGiversRaw->filter(function ($item) {
            return $item->businessGiverMember != null;
        });

        return view('member.topNetworkers.index', compact('topInfluencers', 'crorepatiGivers'));
    }
}
