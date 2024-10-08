<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use Illuminate\Http\Request;

class AllActivityController extends Controller
{

    function __construct()
    {
        // Applying middleware based on the specific methods for IBM, Reference, and Business.
        $this->middleware('permission:ibm-list|ibm-create|ibm-edit|ibm-delete', ['only' => ['ibm']]);
        $this->middleware('permission:reference-list|reference-create|reference-edit|reference-delete', ['only' => ['reference']]);
        $this->middleware('permission:business-list|business-create|business-edit|business-delete', ['only' => ['business']]);
    }
    public function ibm()
    {
        $ibms = CircleCall::where('status', 'Active')->paginate(10);
        return view('admin.allactivity.ibm', compact('ibms'));
    }

    public function refrence()
    {
        $refrences = CircleMeetingMembersReference::where('status', 'Active')->paginate(10);
        return view('admin.allactivity.reference', compact('refrences'));
    }

    public function business()
    {
        $businesses = CircleMeetingMembersBusiness::where('status', 'Active')->paginate(10);
        return view('admin.allactivity.businessSlip', compact('businesses'));
    }
}
