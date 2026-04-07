<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\User;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class TestimonialController extends Controller
{
    public function myTestimonials(Request $request)
    {
        try {
            $authUser = Auth::user();
            if (! $authUser) {
                return Utils::errorResponse('Unauthorized', 'Unauthorized', 401);
            }

            $myTestimonials = Testimonial::where('userId', $authUser->id)->with('receiver')->get();

            return Utils::sendResponse([$myTestimonials], 'My Testimonials retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $authUser = Auth::user()->member->id;
            if (! $authUser) {
                return Utils::errorResponse('Unauthorized', 'Unauthorized', 401);
            }

            $receivedTestimonial = Testimonial::where('memberId', $authUser)->with('sender')->get();

            return Utils::sendResponse([$receivedTestimonial], 'Recieved Testimonials retrieved successfully', 200);
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
                'message' => 'required',
                'date' => 'required|date'
            ]);

            $testimonial = new Testimonial;
            $testimonial->userId = Auth::user()->id;
            $testimonial->memberId = $request->circlePersonId;
            $testimonial->message = $request->message;
            $testimonial->status = 'Active';
            // $testimonial->uploadedDate = Carbon::now()->toDateString();
            $testimonial->uploadedDate = $request->date;
            $testimonial->save();

            // Send notification to the specified user
            $circlePersonId = $request->input('circlePersonId');
            $user = User::find($circlePersonId);

            if ($user && $user->fcm_token) {
                $title = 'Testimonial';
                $body = $user->firstName . ' ' . $user->lastName . ' has Created Testimonial about you.';

                $serviceAccountPath = storage_path('app/public/ubn_notification.json');
                $factory = (new Factory)->withServiceAccount($serviceAccountPath);
                $messaging = $factory->createMessaging();

                $message = CloudMessage::withTarget('token', $user->fcm_token)
                    ->withNotification(Notification::create($title, $body));

                try {
                    $messaging->send($message);
                    Log::info('Notification sent to token: ' . $user->fcm_token);
                    // $notificationSent = true;
                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Log::error('Token not found: ' . $user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
                    Log::error('Invalid argument error with token: ' . $user->fcm_token);
                } catch (\Exception $e) {
                    Log::error('General error sending to token: ' . $user->fcm_token . '. Error: ' . $e->getMessage());
                }
            } else {
                Log::error('No FCM token found for user ID: ' . $circlePersonId);
            }

            return Utils::sendResponse($testimonial, 'Testimonial created successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $testimonial = Testimonial::find($id);
            if (! $testimonial) {
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
            if (! $testimonial) {
                return Utils::errorResponse('Testimonial not found', 'Not Found', 404);
            }
            $testimonial->restore();

            return Utils::sendResponse(null, 'Testimonial restored successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function updateTestimonial(Request $request, $id)
    {
        try {
            $authUser = Auth::user();
            if (! $authUser) {
                return Utils::errorResponse('Unauthorized', 'Unauthorized', 401);
            }

            $request->validate([
                'circlePersonId' => 'required',
                'message' => 'required',
                'date' => 'required|date'
            ]);

            $testimonial = Testimonial::find($id);

            if (! $testimonial) {
                return Utils::errorResponse('Testimonial not found', 'Not Found', 404);
            }

            // Optional: ensure user owns testimonial
            if ($testimonial->userId !== $authUser->id) {
                return Utils::errorResponse('Forbidden', 'You cannot update this testimonial', 403);
            }

            $testimonial->userId = $authUser->id;
            $testimonial->memberId = $request->circlePersonId;
            $testimonial->message = $request->message;
            $testimonial->uploadedDate = $request->date;
            $testimonial->status = 'Active';
            $testimonial->save();

            return Utils::sendResponse($testimonial, 'Testimonial updated successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function deleteTestimonial($id)
    {
        try {
            // $authUser = Auth::user();
            // if (! $authUser) {
            //     return Utils::errorResponse('Unauthorized', 'Unauthorized', 401);
            // }

            $testimonial = Testimonial::where('id', $id)
                // ->where('status', 'Archived')
                ->first();

            if (! $testimonial) {
                return Utils::errorResponse('Testimonial not found or not archived', 'Not Found', 404);
            }

            $testimonial->status = 'Deleted';
            $testimonial->save();

            return Utils::sendResponse(null, 'Testimonial deleted successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }
}
