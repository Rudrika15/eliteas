<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SpecificAsk;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;

class SpecificAskController extends Controller
{
    public function allIndexApi()
    {
        try {
            $specificasks = SpecificAsk::get();
            return Utils::sendResponse(['specificasks' => $specificasks], 'Specific Ask retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function indexApi()
    {
        try {
            $specificasks = SpecificAsk::where('askBy', Auth::user()->id)->get();
            return Utils::sendResponse(['specificasks' => $specificasks], 'Specific Ask retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }




    public function createApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ask' => 'required|string',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $specificAsk = new SpecificAsk();
            $specificAsk->askBy = Auth::id();
            $specificAsk->ask = $request->ask;
            $specificAsk->status = "Active";
            $specificAsk->save();

            return Utils::sendResponse(['specificAsk' => $specificAsk], 'Specific Ask Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }



    public function updateApi(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ask' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $specificasks = SpecificAsk::find($id);

            if (!$specificasks) {
                return Utils::errorResponse(['error' => 'Ask not found.'], 'Not Found', 404);
            }

            $specificasks->askBy = Auth::user()->id;
            $specificasks->ask = $request->ask;
            $specificasks->status = 'Active';
            $specificasks->save();

            return Utils::sendResponse(['specificasks' => $specificasks], 'Ask Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function deleteApi(Request $request, $id)
    {
        try {
            $specificasks = SpecificAsk::find($id);

            if (!$specificasks) {
                return Utils::errorResponse(['error' => 'ask not found.'], 'Not Found', 404);
            }

            $specificasks->status = 'Deleted';
            $specificasks->save();

            return Utils::sendResponse([], 'Ask Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
