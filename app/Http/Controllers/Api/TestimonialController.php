<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        try {
            $authUser = Auth::user();
            if (!$authUser) {
                return Utils::errorResponse('Unauthorized', 'Unauthorized', 401);
            }

            $testimonials = Testimonial::where('memberId', $authUser->member->id)->with('sender')->get();
            $myTestimonials = Testimonial::where('userId', $authUser->id)->with('receiver')->get();

            return Utils::sendResponse([$testimonials], 'Testimonials retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function myTestimonials(Request $request)
    {
        try {
            $authUser = Auth::user();
            if (!$authUser) {
                return Utils::errorResponse('Unauthorized', 'Unauthorized', 401);
            }

            $myTestimonials = Testimonial::where('userId', $authUser->id)->with('receiver')->get();

            return Utils::sendResponse([$myTestimonials], 'My Testimonials retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function indexAdmin()
    {
        try {
            $testimonials = Testimonial::all();
            return Utils::sendResponse($testimonials, 'Testimonials retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'circlePersonId' => 'required',
                'message' => 'required'
            ]);

            $testimonial = new Testimonial();
            $testimonial->userId = Auth::user()->id;
            $testimonial->memberId = $request->circlePersonId;
            $testimonial->message = $request->message;
            $testimonial->status = 'Active';
            $testimonial->uploadedDate = Carbon::now()->toDateString();
            $testimonial->save();

            return Utils::sendResponse($testimonial, 'Testimonial created successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }


    public function destroy($id)
    {
        try {
            $testimonial = Testimonial::find($id);
            if (!$testimonial) {
                return Utils::errorResponse('Testimonial not found', 'Not Found', 404);
            }
            $testimonial->delete();

            return Utils::sendResponse(null, 'Testimonial deleted successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }


    public function archives()
    {
        try {
            $testimonials = Testimonial::onlyTrashed()->get();
            return Utils::sendResponse($testimonials, 'Archived testimonials retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function restore($id)
    {
        try {
            $testimonial = Testimonial::withTrashed()->find($id);
            if (!$testimonial) {
                return Utils::errorResponse('Testimonial not found', 'Not Found', 404);
            }
            $testimonial->restore();

            return Utils::sendResponse(null, 'Testimonial restored successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }
}
