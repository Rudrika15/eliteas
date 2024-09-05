<?php

namespace App\Http\Controllers\Admin;

use view;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Http\Controllers\Controller;

class MembershipTypeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $membershipType = MembershipType::where('status', 'Active')->paginate(10);
            return view('admin.membershiptype.index', compact('membershipType'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    // public function show(Request $request, $id)
    // {
    //     try {
    //         $businessCategory = BusinessCategory::findOrFail($id);
    //         return response()->json($businessCategory);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return view('servererror');
    //     }
    // }

    public function create()
    {
        try {
            $membershipType = MembershipType::all();
            return view('admin.membershiptype.create', compact('membershipType'));
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'membershipType' => 'required|unique:membership_types,membershipType',
        ]);

        try {
            $membershipType = new MembershipType();
            $membershipType->membershipType = $request->membershipType;
            $membershipType->amount = $request->amount;


            // $businessCategory->categoryIcon = $request->categoryIcon;

            $membershipType->status = 'Active';
            $membershipType->save();

            return redirect()->route('membershipType.index')->with('success', 'Membership Type Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $membershipType = MembershipType::find($id);
            return view('admin.membershiptype.edit', compact('membershipType'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            // 'id' => 'required|exists:membership_types,id',
            // 'membershipType' => 'required|unique:membership_types,membershipType',
            // 'categoryIcon' => 'required',
        ]);

        try {
            $membershipType = MembershipType::find($request->id);

            $membershipType->membershipType = $request->membershipType;
            $membershipType->amount = $request->amount;

            $membershipType->status = 'Active';
            $membershipType->save();

            return redirect()->route('membershipType.index')->with('success', 'Membership Type details updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('membershipType.index')->with('error', 'Failed to update Membership Type details.');
        }
    }


    public function delete($id)
    {
        try {
            $membershipType = MembershipType::find($id);

            // if (!$membershipType) {
            //     return redirect()->route('bCategory.index')->with('error', 'Business Category not found.');
            // }

            $membershipType->status = 'Deleted';
            $membershipType->save();

            return redirect()->route('membershipType.index')->with('success', 'Business Category deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('membershipType.index')->with('error', 'Failed to delete Business Category.');
        }
    }
}
