<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\CircleCall;
use App\Utils\ErrorLogger;
use App\Models\CircleMember;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class CircleCallController extends Controller
{

    public function __construct()
    {
        // Apply middleware for circle call-related permissions
        $this->middleware('permission:circle-call-view', ['only' => ['index', 'view']]);
        $this->middleware('permission:circle-call-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:circle-call-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:circle-call-delete', ['only' => ['delete']]);
        $this->middleware('permission:get-member-by-circle', ['only' => ['getMembersByCircle']]);
        $this->middleware('permission:get-circle', ['only' => ['getCircle']]);
        $this->middleware('permission:get-circle-members', ['only' => ['getCircleMembers']]);
        $this->middleware('permission:get-member', ['only' => ['getMember']]);
        $this->middleware('permission:get-member-for-ref', ['only' => ['getMemberForRef']]);
        $this->middleware('permission:get-member-for-ref-Giver', ['only' => ['getMemberForRefGiver']]);
    }


    // public function index(Request $request)
    // {
    //     try {
    //         $circlecall = CircleCall::with('member')
    //             ->where('memberId', Auth::user()->id)
    //             ->with('meetingPerson')
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->paginate(10);

    //         $callWith = CircleCall::with('member')
    //             ->where('meetingPersonId', Auth::user()->id)
    //             ->with('member')
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->paginate(10);


    //         $circles = Circle::where('status', 'Active')->orderBy('circleName', 'asc')->get();

    //         $circleMember = Member::with('circle')
    //             ->where('status', 'Active')
    //             ->get(); // Ensure 'circleId' is included


    //         // return $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)->where('status', 'Active')->get(['date']);
    //         $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)
    //             ->where('status', 'Active')
    //             ->where('date')
    //             ->pluck('date'); // Pluck all 'date' values from the query result

    //         $lastDate = Schedule::where('circleId', Auth::user()->member->circle->id)
    //             ->where('date', '<', now())
    //             ->orderBy('date', 'desc')
    //             ->pluck('date')
    //             ->first();

    //         return view('admin.circlecall.index', compact('circlecall', 'callWith', 'circles', 'scheduleDate', 'lastDate', 'circleMember'));
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError($th, $request->fullUrl());
    //         return view('servererror');
    //     }
    // }


    public function index(Request $request)
    {
        try {
            $circlecall = CircleCall::with('member')
                ->where('memberId', Auth::user()->id)
                ->with('meetingPerson')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            $callWith = CircleCall::with('member')
                ->where('meetingPersonId', Auth::user()->id)
                ->with('member')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            // ✅ If user has "Member" role
            if (Auth::user()->hasRole('Member')) {

                $circles = Circle::where('status', 'Active')
                    ->orderBy('circleName', 'asc')
                    ->get();

                $circleMember = Member::with('circle')
                    ->where(function ($query) {
                        $query->where('status', 'Active')
                            ->orWhere('firstName', 'UBN');
                    })
                    ->where('userId', '!=', auth()->id())
                    ->orderBy('firstName', 'asc')
                    ->get();


                $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                    ->where('status', 'Active')
                    ->pluck('date');

                $lastDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                    ->where('date', '<', now())
                    ->orderBy('date', 'desc')
                    ->pluck('date')
                    ->first();

                return view('admin.circlecall.index', compact(
                    'circlecall',
                    'callWith',
                    'circles',
                    'scheduleDate',
                    'lastDate',
                    'circleMember'
                ));
            }

            // ✅ If user has "Digital Member" role
            elseif (Auth::user()->hasRole('Digital Member')) {

                $userCityId = Auth::user()->member->cityId;

                $circleMember = Member::whereNull('circleId')
                    ->where('cityId', $userCityId)
                    ->where('status', 'Active')
                    ->get();

                $cities = City::where('status', 'Active')
                    ->orderBy('cityName', 'asc')
                    ->get();

                return view('admin.circlecall.index', compact(
                    'cities',
                    'circlecall',
                    'callWith',
                    'circleMember'
                ));
            }

            // Default unauthorized
            return redirect()->back()->with('error', 'Unauthorized access.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }



    //For show single data
    public function view(Request $request, $id)
    {
        try {
            //
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function create(Request $request)
    {
        try {
            $circles = Circle::where('status', 'Active')->orderBy('circleName', 'asc')->get();

            $circleMember = Member::with('circle')
                ->where(function ($query) {
                    $query->where('status', 'Active')
                        ->orWhere('firstName', 'UBN');
                })
                ->orderBy('firstName', 'asc')
                ->get();


            // return $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)->where('status', 'Active')->get(['date']);
            $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                ->where('status', 'Active')
                ->where('date')
                ->pluck('date'); // Pluck all 'date' values from the query result

            $lastDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                ->where('date', '<', now())
                ->orderBy('date', 'desc')
                ->pluck('date')
                ->first();

            return view('admin.circlecall.create', compact('circles', 'circleMember', 'scheduleDate', 'lastDate'));
        } catch (\Throwable $th) {
            throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    // public function getMembersByCircle(Request $request)
    // {
    //     $circleId = $request->input('circleId');

    //     if ($circleId) {
    //         $members = Member::where('circleId', $circleId)
    //             ->with('user')
    //             ->where('status', 'Active')
    //             ->orderBy('firstName', 'asc')
    //             ->where('userId', '!=', Auth::id())
    //             ->get(['id', 'userId', 'firstName', 'lastName']); // Adjust fields as needed

    //         return response()->json(['members' => $members]);
    //     }

    //     return response()->json(['members' => []]);
    // }


    public function getMembersByCircle(Request $request)
    {
        $circleId = $request->circleId;

        $members = Member::with('circle')
            ->where(function ($query) use ($circleId) {
                $query->where('circleId', $circleId)
                    ->where('status', 'Active')
                    ->where('userId', '<>', Auth::id()) // exclude the authenticated user
                    ->orWhere('firstName', 'UBN'); // always include UBN
            })
            ->orderBy('firstName', 'asc')
            ->get();

        return response()->json([
            'members' => $members
        ]);
    }




    function getCircle(Request $request): JsonResponse
    {
        $query = $request->input('q');

        $circles = Circle::where('circleName', 'LIKE', '%' . $query . '%')
            ->where('status', 'Active') // Add condition to get only active circles
            ->get();

        $userCircle = Member::where('userId', Auth::user()->id)->with('circle')->first();

        $userCircleName = $userCircle ? $userCircle->circle->circleName : null;

        return response()->json([
            'circles' => $circles,
            'userCircleName' => $userCircleName,
        ]);
    }



    public function getCircleMembers(Request $request, $circleId = null)
    {

        $circleId = $circleId ?: $request->input('circleId');

        if (!$circleId) {
             return '';
        }

        $members = Member::where('circleId', $circleId)
        ->where('status', 'Active') // members table
        ->whereHas('user', function ($q) {
        $q->where('status', 'Active') // users table
          ->whereHas('roles', function ($q) {
              $q->whereIn('name', ['Member', 'Trainer']);
          });
        })
        ->with(['user', 'contact', 'city', 'bCategory', 'circle'])
        ->where('userId', '!=', Auth::id())
        ->get();

        $authId = Auth::id();
        $authCircleId = Member::where('userId', $authId)->value('circleId');

        $connections = Connection::where('userId', $authId)
            ->orWhere('memberId', $authId)
            ->get();

        $connMap = [];
        foreach ($connections as $conn) {
            $otherId = ($conn->userId == $authId) ? $conn->memberId : $conn->userId;
            $connMap[$otherId] = $conn->status;
        }

        foreach ($members as $member) {
            $member->connection_status = $connMap[$member->userId] ?? null;
        }

        return view('partials.member-cards', compact('members', 'authCircleId'))->render();
    }

    function getMember(Request $request): JsonResponse
    {
        $query = $request->input('q');
        $all = $request->input('all');

        $data = [];

        $myCircle = Member::where('userId', Auth::user()->id)->with('circle')->first();

        // Search all members if the checkbox is checked
        if ($all) {
            $data = User::whereHas('roles', function ($q) {
                $q->where('name', 'Member');
            })
                ->where('firstName', 'LIKE', '%' . $query . '%')
                ->where('id', '!=', Auth::user()->id)
                ->with('member.circle') // Include circle information
                ->get();
        } else {
            $data = User::whereHas('roles', function ($q) {
                $q->where('name', 'Member');
            })
                ->whereHas('member', function ($q) use ($myCircle) {
                    $q->where('circleId', $myCircle->circle->id);
                })
                ->where('firstName', 'LIKE', '%' . $query . '%')
                ->where('id', '!=', Auth::user()->id)
                ->with('member.circle') // Include circle information
                ->get();
        }
        return response()->json($data);
    }

    function getMemberForRef(Request $request): JsonResponse
    {
        $query = $request->input('q');

        $data = [];

        $data = User::whereHas('roles', function ($q) {
            $q->where('name', 'Member');
        })
            ->where('firstName', 'LIKE', '%' . $query . '%')
            ->where('id', '!=', Auth::user()->id)
            ->with('member.circle') // Include circle information
            ->get();


        return response()->json($data);
    }


    function getMemberForRefGiver(Request $request): JsonResponse
    {
        $query = $request->input('q');

        $data = [];

        $data = User::whereHas('roles', function ($q) {
            $q->where('name', 'Member');
        })
            ->where('firstName', 'LIKE', '%' . $query . '%')
            ->where('id', '!=', Auth::user()->id)
            ->with('member.circle')
            ->get();


        return response()->json($data);
    }


    // public function store(Request $request)
    // {
    //     // return $request;

    //     $validator = Validator::make($request->all(), [
    //         // 'meetingPersonId' => 'required',
    //         'meetingPlace' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
    //         'date' => 'required',
    //         'remarks' => 'required',
    //         'meetingImage' => 'mimes:jpeg,jpg,png,gif|max:2048',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     try {
    //         $circlecall = new CircleCall();
    //         $circlecall->memberId = Auth::user()->id;
    //         $circlecall->meetingPersonId = $request->meetingPersonId;
    //         $circlecall->meetingPlace = $request->meetingPlace;

    //         if ($request->meetingImage) {
    //             $circlecall->meetingImage = time() . '.' . $request->meetingImage->extension();
    //             $request->meetingImage->move(public_path('meetingImage'), $circlecall->meetingImage);
    //         }

    //         $circlecall->date = $request->date;
    //         $circlecall->remarks = $request->remarks;
    //         $circlecall->status = 'Active';


    //         $circlecall->save();

    //         return redirect()->route('circlecall.index')->with('success', 'Data Added Successfully!');
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError(
    //             $th,
    //             $request->fullUrl()
    //         );

    //         return view('servererror');
    //     }
    // }


    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'meetingPlace' => 'required',
    //         'date' => 'required',
    //         'remarks' => 'required',

    //         // 'meetingImage' => 'mimes:jpeg,jpg,png,gif|max:5120', // Allow 5MB for upload
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     try {
    //         $circlecall = new CircleCall();
    //         $circlecall->memberId = Auth::user()->id;
    //         $circlecall->meetingPersonId = $request->meetingPersonId;
    //         $circlecall->meetingPlace = $request->meetingPlace;

    //         if ($request->hasFile('meetingImage')) {
    //             $image = $request->file('meetingImage');
    //             $imageName = time() . '.' . $image->getClientOriginalExtension();

    //             // Create an image resource from the uploaded file
    //             $img = imagecreatefromjpeg($image->getPathname());

    //             // Resize image to a width of 800px, maintain aspect ratio
    //             $width = 800;
    //             $height = (imagesy($img) / imagesx($img)) * $width;
    //             $resizedImg = imagescale($img, $width, $height);

    //             // Save the resized image as a compressed JPEG
    //             imagejpeg($resizedImg, public_path('meetingImage/' . $imageName), 75); // 75 for quality

    //             // Check file size after compression
    //             if (filesize(public_path('meetingImage/' . $imageName)) > 2 * 1024 * 1024) {
    //                 return redirect()->back()->withErrors(['meetingImage' => 'Image could not be compressed below 2MB'])->withInput();
    //             }

    //             // Store image name in DB
    //             $circlecall->meetingImage = $imageName;
    //         }

    //         $circlecall->date = $request->date;
    //         $circlecall->remarks = $request->remarks;
    //         $circlecall->status = 'Active';

    //         $circlecall->save();

    //         return redirect()->route('circlecall.index')->with('success', 'Data Added Successfully!');
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, $request->fullUrl());
    //         return view('servererror');
    //     }
    // }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meetingPlace' => 'required',
            // 'date' => 'required|date',
            'remarks' => 'required',
            'meetingImage' => 'mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // ✅ Member से circleId लो
            $member = Member::where('userId', Auth::id())->first();

            if (!$member) {
                return redirect()->back()->withErrors(['error' => 'Member not found'])->withInput();
            }

            $circleId = $member->circleId;

            // // ✅ Schedule से latest meeting निकालो
            // $latestSchedule = Schedule::where('circleId', $circleId)
            //     ->whereDate('date', '<=', Carbon::today()) // ✅ केवल आज या उससे पहले की date
            //     ->orderBy('date', 'desc')
            //     ->first();

            // if ($latestSchedule) {
            //     if ($latestSchedule->lockUnlock === 'yes') {
            //         return redirect()->back()
            //             ->with('error', 'You cannot create a IBM because the last meeting (' . $latestSchedule->date . ') is locked.')
            //             ->withInput();
            //     }
            // }


            // ✅ Latest locked meeting निकालो
            // $latestLockedMeeting = Schedule::where('circleId', $circleId)
            //     ->where('lockUnlock', 'yes')
            //     ->orderBy('date', 'desc')
            //     ->first();

            // if ($latestLockedMeeting) {
            //     $lockedDate = Carbon::parse($latestLockedMeeting->date);

            //     // अगर user जो date भेज रहा है वो lockedDate से पहले या उसी दिन है → रोक दो
            //     if (Carbon::parse($request->date)->lte($lockedDate)) {
            //         return redirect()->back()
            //             ->with('error', 'You cannot create an IBM on or before ' . $lockedDate->format('d-m-Y') . ' because that meeting is locked.')
            //             ->withInput();
            //     }
            // }

            // ✅ अब आपका पुराना code
            $circlecall = new CircleCall();
            $circlecall->memberId = Auth::user()->id;
            $circlecall->meetingPersonId = $request->meetingPersonId;
            $circlecall->meetingPlace = $request->meetingPlace;

            if ($request->hasFile('meetingImage')) {

                $image = $request->file('meetingImage');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $path = $image->getPathname();

                // Detect MIME type
                $mime = mime_content_type($path);

                if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                    $img = imagecreatefromjpeg($path);
                } elseif ($mime === 'image/png') {
                    $img = imagecreatefrompng($path);
                } elseif ($mime === 'image/gif') {
                    $img = imagecreatefromgif($path);
                } else {
                    return back()->withErrors(['meetingImage' => 'Unsupported image format'])->withInput();
                }

                // Resize
                $width = 800;
                $height = (imagesy($img) / imagesx($img)) * $width;
                $resizedImg = imagescale($img, $width, $height);

                // Always save as JPG
                imagejpeg($resizedImg, public_path('meetingImage/' . $imageName), 75);

                // Check size
                if (filesize(public_path('meetingImage/' . $imageName)) > 2 * 1024 * 1024) {
                    return redirect()->back()->withErrors(['meetingImage' => 'Image could not be compressed below 2MB'])->withInput();
                }

                $circlecall->meetingImage = $imageName;
            }


            $circlecall->date = $request->date;
            $circlecall->remarks = $request->remarks;
            $circlecall->status = 'Active';
            // return $circlecall;

            $circlecall->save();

            return redirect()->route('circlecall.index')->with('success', 'Data Added Successfully!');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }



    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'meetingPlace' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
    //         'date' => 'required',
    //         'remarks' => 'required',
    //         // 'meetingImage' => 'mimes:jpeg,jpg,png,gif|max:5120', // Allow up to 5MB for initial upload
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     try {
    //         $circlecall = new CircleCall();
    //         $circlecall->memberId = Auth::user()->id;
    //         $circlecall->meetingPersonId = $request->meetingPersonId;
    //         $circlecall->meetingPlace = $request->meetingPlace;

    //         if ($request->hasFile('meetingImage')) {
    //             $image = $request->file('meetingImage');
    //             $imageName = time() . '.' . $image->getClientOriginalExtension();

    //             // Compress the image
    //             $compressedImage = Image::make($image->getPathname())
    //                 ->resize(800, null, function ($constraint) {
    //                     $constraint->aspectRatio();
    //                     $constraint->upsize();
    //                 }) // Resize while maintaining aspect ratio
    //                 ->encode('jpg', 75); // Compress to 75% quality

    //             // Check if the compressed image size is less than 2MB
    //             if (strlen($compressedImage) / 1024 > 2048) {
    //                 return redirect()->back()->withErrors(['meetingImage' => 'Image could not be compressed below 2MB'])->withInput();
    //             }

    //             // Save the compressed image to the public folder
    //             $compressedImage->save(public_path('meetingImage/' . $imageName));

    //             $circlecall->meetingImage = $imageName;
    //         }

    //         $circlecall->date = $request->date;
    //         $circlecall->remarks = $request->remarks;
    //         $circlecall->status = 'Active';

    //         $circlecall->save();

    //         return redirect()->route('circlecall.index')->with('success', 'Data Added Successfully!');
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError(
    //             $th,
    //             $request->fullUrl()
    //         );

    //         return view('servererror');
    //     }
    // }



    // public function edit(Request $request, $id)
    // {
    //     try {


    //         if (Auth::user()->role == 'Member') {

    //             $circlecall = CircleCall::find($id);
    //             $member = Member::where('status', '!=', 'Deleted')->orderBy('firstName', 'asc')->get();
    //             $circleMember = CircleMember::where('status', '!=', 'Deleted')->get();
    //             $circles = Circle::where('status', 'Active')->orderBy('circleName', 'asc')->get();

    //             // Fetch all 'date' values from the query result
    //             $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)
    //                 ->where('status', 'Active')
    //                 ->pluck('date');

    //             // Fetch the most recent date before the current date
    //             $lastDate = Schedule::where('circleId', Auth::user()->member->circle->id)
    //                 ->where('date', '<', now())
    //                 ->orderBy('date', 'desc')
    //                 ->pluck('date')
    //                 ->first();
    //         }


    //         if (Auth::user()->role == 'Digital Member') {
    //             $circlecall = CircleCall::find($id);
    //             $member = Member::where('status', '!=', 'Deleted')->where('circleId', null)->orderBy('firstName', 'asc')->get();
    //         }

    //         return view('admin.circlecall.edit', compact('circlecall', 'circlecall', 'circles', 'scheduleDate', 'lastDate', 'circleMember', 'member'));
    //         // return view('admin.circlecall._edit_form', compact('circlecall', 'circles', 'scheduleDate', 'lastDate', 'circleMember', 'member'));
    //     } catch (\Throwable $th) {
    //         // Log the error using the ErrorLogger utility
    //         ErrorLogger::logError($th, $request->fullUrl());

    //         // Return a custom error view
    //         return view('servererror');
    //     }
    // }


    public function edit(Request $request, $id)
    {
        try {

            Auth::user()->id;

            $circlecall = CircleCall::find($id);

            if (!$circlecall) {
                return redirect()->back()->with('error', 'Circle Call not found.');
            }

            if (Auth::user()->hasRole('Member')) {
                $member = Member::where('status', '!=', 'Deleted')
                    ->orderBy('firstName', 'asc')
                    ->get();

                $circleMember = CircleMember::where('status', '!=', 'Deleted')->get();

                $circles = Circle::where('status', 'Active')
                    ->orderBy('circleName', 'asc')
                    ->get();

                $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                    ->where('status', 'Active')
                    ->pluck('date');

                $lastDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                    ->where('date', '<', now())
                    ->orderBy('date', 'desc')
                    ->pluck('date')
                    ->first();

                return view('admin.circlecall.edit', compact(
                    'circlecall',
                    'circles',
                    'scheduleDate',
                    'lastDate',
                    'circleMember',
                    'member'
                ));
            }

            if (Auth::user()->hasRole('Digital Member')) {
                $circleMember = Member::where('status', 'Active')
                    ->where('userId', '!=', Auth::user()->id)
                    ->whereNull('circleId')
                    ->orderBy('firstName', 'asc')
                    ->get();

                $cities = City::where('status', 'Active')
                    ->orderBy('cityName', 'asc')
                    ->get();

                return view('admin.circlecall.edit', compact('circlecall', 'circleMember', 'cities'));
            }

            // Optional: fallback for other roles
            return redirect()->back()->with('error', 'Unauthorized access.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }




    public function update(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'meetingPlace' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
                'date' => 'required',
                'remarks' => 'required',
                'meetingImage' => 'mimes:jpeg,jpg,png,gif|max:2048',
            ]);

            $id = $request->id;
            $circlecall = CircleCall::find($id);
            $circlecall->meetingPersonId = $request->meetingPersonId;
            $circlecall->meetingPlace = $request->meetingPlace;

            if ($request->meetingImage) {
                $circlecall->meetingImage = time() . '.' . $request->meetingImage->extension();
                $request->meetingImage->move(public_path('meetingImage'), $circlecall->meetingImage);
            }

            $circlecall->remarks = $request->remarks;
            $circlecall->status = 'Active';

            $circlecall->save();

            return redirect()->route('circlecall.index')->with('success', 'Circle Call Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }


    function delete(Request $request, $id)
    {
        try {
            $call = CircleCall::find($id);
            $call->status = "Deleted";
            $call->save();

            return redirect()->route('circlecall.index')->with('Success', 'Circle call Deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function callNotify()
    {
        $users = User::where('fcm_token', '!=', null)->get();

        $title = 'Circle Call';
        $body = 'Circle Call Reminder';

        $serviceAccountPath = storage_path('app/public/ubn_notification.json');
        $factory = (new Factory)->withServiceAccount($serviceAccountPath);
        $messaging = $factory->createMessaging();

        foreach ($users as $user) {
            if ($user->fcm_token) {
                $message = CloudMessage::withTarget('token', $user->fcm_token)
                    ->withNotification(Notification::create($title, $body));
                try {
                    $messaging->send($message);
                    Log::info('Notification sent to token: ' . $user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Log::error('Token not found: ' . $user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
                    Log::error('Invalid argument error with token: ' . $user->fcm_token);
                } catch (\Exception $e) {
                    Log::error('General error sending to token: ' . $user->fcm_token . '. Error: ' . $e->getMessage());
                }
            }
        }
    }

    //digital member functions

    public function getMembersByCity($cityId)
    {
        try {
            $members = Member::where('status', 'Active')
                ->where('userId', '!=', Auth::id())
                ->where('circleId', null)
                ->where('cityId', $cityId)
                ->get(['id', 'userId', 'firstName', 'lastName']);

            return response()->json($members);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
