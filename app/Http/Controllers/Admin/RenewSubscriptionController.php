<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RenewSubscription;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class RenewSubscriptionController extends Controller
{
    public function index()
    {
        try {
            return response()->json(RenewSubscription::orderByDesc('created_at')->paginate(15));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'userId' => ['required', 'integer', 'exists:users,id'],
                'renewedBy' => ['nullable', 'integer', 'exists:users,id'],
                'renewalDate' => ['nullable', 'date'],
                'subscriptionId' => ['nullable', 'integer'],
                'amount' => ['nullable', 'numeric'],
                'status' => ['nullable', 'string'],
            ]);

            $record = RenewSubscription::create($data);

            return response()->json($record, 201);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $record = RenewSubscription::findOrFail($id);

            return response()->json($record);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $record = RenewSubscription::findOrFail($id);

            $data = $request->validate([
                'userId' => ['sometimes', 'integer', 'exists:users,id'],
                'renewedBy' => ['nullable', 'integer', 'exists:users,id'],
                'renewalDate' => ['nullable', 'date'],
                'subscriptionId' => ['nullable', 'integer'],
                'amount' => ['nullable', 'numeric'],
                'status' => ['nullable', 'string'],
            ]);

            $record->update($data);

            return response()->json($record);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $record = RenewSubscription::findOrFail($id);
            $record->delete();

            return response()->json(null, 204);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json(['error' => 'Server error'], 500);
        }
    }
}
