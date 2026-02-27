<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\Circle;
use App\Models\MembersFormDetails;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MemberFormController extends Controller
{
    // public function create()
    // {
    //     $circles = Circle::where('status', 'active')->get();
    //     $categories = BusinessCategory::where('status', 'active')->get();

    //     $circleId = null;

    //     if (request()->has('cid')) {
    //         try {
    //             $circleId = Crypt::decryptString(request('cid'));
    //         } catch (DecryptException $e) {
    //             // Handle invalid cid
    //             return redirect()->back()->with('error', 'Invalid link.');
    //         }
    //     }

    //     return view('memberForm', compact('circles', 'categories', 'circleId'));
    // }

    public function encryptCircle(Request $request)
    {
        $id = $request->id;
        $name = $request->name;

        return response()->json([
            'id' => Crypt::encryptString($id),
            'name' => $name,
        ]);
    }

    public function showForm(Request $request)
    {
        try {
            $circleId = Crypt::decryptString($request->cid);
            $circleName = $request->cname; // plain
        } catch (\Exception $e) {
            abort(404); // invalid or missing ID
        }

        $circles = Circle::where('status', 'active')->get();
        $categories = BusinessCategory::where('status', 'active')->get();

        return view('memberForm', compact('circleId', 'circleName', 'circles', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'companyLogo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $memberDetails = new MembersFormDetails;
        $memberDetails->circleId = $request->circleId;
        $memberDetails->name = $request->name;
        $memberDetails->email = $request->email;
        $memberDetails->mobileNo = $request->mobileNo;
        $memberDetails->instaId = $request->instaId;
        $memberDetails->linkedinId = $request->linkedinId;
        $memberDetails->pre_intro = $request->pre_intro;
        $memberDetails->business_name = $request->business_name;
        $memberDetails->b_category_id = $request->b_category_id;
        $memberDetails->address = $request->address;
        $memberDetails->product_service = $request->product_service;
        $memberDetails->website = $request->website;
        $memberDetails->birthdate = $request->birthdate;
        $memberDetails->anniversaryDate = $request->anniversaryDate;

        if ($request->hasFile('companyLogo')) {
            $companyLogo = $request->file('companyLogo');
            $filename = time().'.'.$companyLogo->getClientOriginalExtension();
            $location = public_path('CompanyLogo');
            $companyLogo->move($location, $filename);
            $memberDetails->companyLogo = $filename;
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time().'.'.$photo->getClientOriginalExtension();
            $location = public_path('ProfilePhoto');
            $photo->move($location, $filename);
            $memberDetails->photo = $filename;
        }
        $memberDetails->save();

        return redirect()->back()->with('success', 'Your details saved successfully.');
    }
}
