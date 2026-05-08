<?php

namespace App\Http\Controllers;

use App\Mail\MeetingInvitation as MailMeetingInvitation;
use App\Models\BusinessCategory;
use App\Models\Circle;
use App\Models\MemberGallery;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\City;
use App\Models\Post;
use App\Models\Connection;
use App\Models\ContactDetails;
use App\Models\Event;
use App\Models\EventRegister;
use App\Models\Landmark;
use App\Models\MeetingInvitation;
use App\Models\Member;
use App\Models\Message;
use App\Models\MonthlyPayment;
use App\Models\Notifications;
use App\Models\Schedule;
use App\Models\TemplateMaster;
use App\Models\Testimonial;
use App\Models\Training;
use App\Models\TrainingRegister;
use App\Models\User;
use App\Models\VisitorEventRegister;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:home-index', ['only' => ['index']]);
        $this->middleware('permission:home-training-register', ['only' => ['trainingRegister']]);
        $this->middleware('permission:home-event-register', ['only' => ['eventRegister']]);
        $this->middleware('permission:home-invitation', ['only' => ['invitation']]);
        $this->middleware('permission:home-invitation-pay', ['only' => ['invitationPay']]);
        $this->middleware('permission:home-find-member', ['only' => ['findMember']]);
        $this->middleware('permission:home-search', ['only' => ['search']]);
        $this->middleware('permission:home-found-person-details', ['only' => ['foundPersonDetails']]);
        $this->middleware('permission:home-accepted', ['only' => ['accepted']]);
        $this->middleware('permission:home-rejected', ['only' => ['rejected']]);
        // $this->middleware('permission:connection-request-received', ['only' => ['connectionRequests']]);
        $this->middleware('permission:home-userDetails', ['only' => ['userDetails']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // public function index()
    // {
    //     $count = Schedule::where('status', 'Active')->count();
    //     $currentDate = Carbon::now()->toDateString();

    //     $currentDate = Carbon::now();

    //     $nearestTraining = Training::where('status', 'Active')
    //         ->whereDate('date', '>=', $currentDate)
    //         ->whereHas('trainers.user')
    //         ->with('trainers.user')
    //         ->whereHas('trainersTrainings.user')
    //         // ->with('trainersTrainings.user')
    //         // ->whereNotNull('data') // Add this line to filter out records where 'data' is not null
    //         ->orderBy('date', 'asc')
    //         ->first();

    //     $businessCategory = BusinessCategory::where('status', 'Active')->get();

    //     $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)->get();

    //     if ($nearestTraining) {
    //         $findRegister = TrainingRegister::where('userId', Auth::user()->id)
    //             ->where('trainingId', $nearestTraining->id)
    //             ->where('trainerId', $nearestTraining->trainersTrainings->user->id)
    //             ->get();
    //     } else {
    //         $findRegister = [];
    //     }

    //     if (!Auth::user()->hasRole('Admin')) {
    //         // business category

    //         $testimonials = Testimonial::where('memberId', Auth::user()->member->id)->with('sender')->orderBy('id', 'DESC')->take(3)->get();
    //         $myCircle = Auth::user()->member->circleId;
    //         $meeting = Schedule::where('circleId', Auth::user()->member->circleId)
    //             ->with('circle.members')
    //             ->with('circle.franchise')
    //             ->where('status', 'Active')
    //             ->where('date', '>=', \today())
    //             ->first();

    //         if ($meeting) {
    //             $meeting->date = Carbon::parse($meeting->date);
    //         } else {
    //             return view('home', ['meeting' => 'No meeting found for now']);
    //         }

    //         $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)
    //             ->where('meetingId', $meeting->id)
    //             ->get();

    //         // Determine the table name based on the slug

    //         //max 1:1 call
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $circlecalls = CircleCall::with(['member', 'meetingPerson'])
    //             ->where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //             ->whereMonth('date', $previousMonth)
    //             ->get();

    //         $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) {
    //             return [
    //                 'member' => $group->first()->member,
    //                 'count' => $group->count()
    //             ];
    //         })->sortByDesc('count')->first(); // Return only the first (highest count) record

    //         //max business
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //             ->whereMonth('date', $previousMonth)
    //             ->get();

    //         $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) {
    //             $user = $group->first()->users;
    //             $member = $user->member()->select('circleId', 'businessCategoryId', 'profilePhoto')->first();
    //             $circle = Circle::find($member->circleId);
    //             $businessCategory = BusinessCategory::find($member->businessCategoryId);

    //             return [
    //                 'user' => $user,
    //                 'member' => $member,
    //                 'amount' => $group->sum('amount'),
    //                 'count' => $group->count(),
    //                 'circle' => [
    //                     'id' => $circle->id,
    //                     'circleName' => $circle->circleName,
    //                 ],
    //                 'businessCategory' => [
    //                     'id' => $businessCategory->id,
    //                     'categoryName' => $businessCategory->categoryName,
    //                 ],
    //             ];
    //         })->sortByDesc('amount')->first();

    //         //reference

    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //             ->whereYear('created_at', $previousYear)
    //             ->whereMonth('created_at', $previousMonth)
    //             ->get()
    //             ->groupBy('referenceGiverId')
    //             ->map(function ($group) {

    //                 $referenceGiverId = $group->first()->referenceGiverId ?? null;

    //                 if ($referenceGiverId === null) {
    //                     return null;
    //                 }

    //                 $user = User::find($referenceGiverId);

    //                 if ($user && $user->status === 'Active') {
    //                     $member = Member::where('userId', $referenceGiverId)->where('status', 'Active')->first();

    //                     return [
    //                         'user' => $user,
    //                         'count' => $group->count(),
    //                         'businessCategoryId' => $member ? $member->businessCategoryId : null,
    //                         'businessCategory' => $member ? $member->bcategory->categoryName : null,
    //                         'circleId' => $member ? $member->circleId : null,
    //                         'circle' => $member ? $member->circle->circleName : null,
    //                         'profilePhoto' => $member ? $member->profilePhoto : null,
    //                     ];
    //                 }

    //                 return null;
    //             })
    //             ->filter()
    //             ->sortByDesc('count')
    //             ->first();

    //         //chat Module
    //         // $chat = Message::where('senderId', Auth::user()->id)
    //         //     ->orWhere('receiverId', Auth::user()->id)
    //         //     ->get();

    //         return view('home', compact('count', 'circlecalls', 'busGiver', 'refGiver', 'nearestTraining', 'findRegister', 'testimonials', 'meeting', 'businessCategory', 'myInvites'));
    //     }
    //     return view('home', compact('count', 'nearestTraining',  'businessCategory', 'myInvites', 'findRegister'));
    // }
    protected function authenticated(Request $request, $user)
    {
        $member = Member::where('userId', $user->id)->first();

        if (!$member || !$member->terms_accepted) {
            return redirect()->route('terms.preview');
        }

        return redirect()->route('home');
    }
    public function count()
    {
        $authUser = auth()->user();
        $authId = $authUser->id;
        $membersCount = Member::where('status', 'Active')->count();
        $circleCount = Circle::where('status', 'Active')->count();
        $cityCount = Member::where('status', 'Active')
            ->whereNotNull('cityId')
            ->distinct('cityId')
            ->count('cityId');

        $pendingCount = Connection::where('memberId', Auth::id())
            ->where('recordStatus', 'Active')
            ->where('status', 'Pending')
            ->count();
        $receivedRequests = Connection::whereHas('member', function ($query) use ($authUser) {
            $query->where('memberId', $authUser->id);
        })
            ->with('member')
            ->where('recordStatus', 'Active')
            ->where('status', 'Pending')
            ->paginate(4);

        $notifications = Notifications::latest()->get()->filter(function ($notification) use ($authUser) {
            $data = json_decode($notification->data, true);
            $type = $data['type'] ?? null;
            // Connection Request -> Show to Receiver
            if ($type == 'connection_request') {
                return isset($data['memberId']) && $data['memberId'] == $authUser->id;
            }
            // Accept or Reject -> Show to Original Sender
            if ($type == 'connection_accept' || $type == 'connection_reject') {
                return isset($data['memberId']) && $data['memberId'] == $authUser->id;
            }
            if ($type == 'chat_message') {
                return isset($data['memberId']) && $data['memberId'] == $authUser->id;
            }
            return false;
        })->map(function ($notification) {
            $data = json_decode($notification->data, true);
            $notification->type = $data['type'] ?? null;
            $notification->connection_id = $data['connection_id'] ?? null;
            // sender = who performed action
            $notification->sender = User::find($data['userId'] ?? null);
            // receiver = who receives notification
            $notification->receiver = User::find($data['memberId'] ?? null);
            return $notification;
        });

        $notificationCount = $notifications->where('is_read', false)->count();
        // $posts = Post::with([
        //     'user.member',
        //     'media'
        // ])
        //     ->withCount(['likes', 'comments'])
        //     ->latest()
        //     ->take(8)
        //     ->get();
        $posts = Post::where('status', 'Active')
            ->whereNotNull('attachment')
            ->where('attachment', '!=', '')
            ->with(['user.member', 'media'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->take(8)
            ->get();
        // $cityCount = Circle::where('status', 'Active')
        //     ->select('cityId')
        //     ->distinct()
        //     ->count('cityId');

        return view('layouts.master', compact('membersCount', 'circleCount', 'cityCount', 'pendingCount', 'notificationCount', 'notifications', 'authId', 'receivedRequests', 'posts'));
    }
    public function index()
    {
        try {

            if (Auth::user()->hasRole('Digital Member')) {
                // Digital Member Dashboard View
                return view('home')->with(['message', 'Digital Member Dashboard Coming Soon...', 'show_profile_popup' => true]);
            }

            $membersCount = Member::where('status', 'Active')->count();
            $circleCount = Circle::where('status', 'Active')->count();
            $pendingCount = Connection::where('memberId', Auth::id())
                ->where('recordStatus', 'Active')
                ->where('status', 'Pending')
                ->count();
            // $cityCount = Circle::where('status', 'Active')
            //     ->select('cityId')
            //     ->distinct()
            //     ->count('cityId');

            $count = Schedule::where('status', 'Active')->count();
            $currentDate = Carbon::now()->format('Y-m-d');
            // $currentDatee = Carbon::now()->format('d-m-Y');

            $nearestTraining = Training::where('status', 'Active')
                ->where('trainingStatus', 'Publish')
                // Only show trainings that are scheduled in the future (i.e. date is greater than today's date)
                ->whereDate('date', '>', $currentDate)
                ->orderBy('date', 'asc')
                ->whereHas('trainers.user')
                ->with('trainers.user')
                ->whereHas('trainersTrainings.user')
                ->get();

            $businessCategory = BusinessCategory::where('status', 'Active')->get();

            // $auth = Auth::user();
            // $member = Member::where('userId', $auth->id)->first();

            $birthdaysToday = Member::whereMonth('birthDate', Carbon::today()->month)
                ->whereDay('birthDate', Carbon::today()->day)
                ->get();
            $templates = TemplateMaster::with('TemplateDetail')->get();

            $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)->get();


            // if ($nearestTraining) {
            //     $findRegister = TrainingRegister::where('userId', Auth::user()->id)
            //         ->where('trainingId', $nearestTraining->id)
            //         // ->where('trainerId', $nearestTraining->trainersTrainings->user->id)
            //         ->get();
            // } else {
            //     $findRegister = [];
            // }

            if (! Auth::user()->hasRole('Admin')) {
                $testimonials = Testimonial::where('memberId', Auth::user()->member->id)
                    ->where('status', 'Active')
                    ->with('sender')
                    ->orderBy('id', 'DESC')
                    ->take(3)
                    ->get();

                $birthdaysToday = Member::whereMonth('birthDate', Carbon::today()->month)
                    ->whereDay('birthDate', Carbon::today()->day)
                    ->get();

                $templates = TemplateMaster::with('TemplateDetail')->where('status', 'Active')->first();

                $myCircle = Auth::user()->member->circleId;
                $meeting = Schedule::where('circleId', Auth::user()->member->circleId)
                    ->with('circle.members')
                    ->with('circle.franchise')
                    ->where('status', 'Active')
                    ->where('date', '>=', \today())
                    ->first();

                if ($meeting) {
                    $meeting->date = Carbon::parse($meeting->date);
                    $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->member->id)
                        ->where('meetingId', $meeting->id)
                        ->get();

                    $signedUrl = URL::signedRoute('visitor.form', [
                        'slug' => $meeting->cm_slug,
                        'meetingId' => $meeting->id,
                        'ref' => auth()->user()->member->id,
                    ]);
                } else {
                    $signedUrl = '';
                    // $categoryNames = '';
                    // return view('home', ['meeting', 'categoryNames' => 'No meeting found for now']);
                }

                $previousMonth = Carbon::now()->subMonth()->month;
                $previousYear = Carbon::now()->subMonth()->year;

                // leaderboard code start

                // $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                //     ->where('status', 'Active')
                //     ->whereYear('date', $previousYear)
                //     ->whereMonth('date', $previousMonth)
                //     ->get();

                // $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) {
                //     return [
                //         'member' => $group->first()->member,
                //         'count' => $group->count()
                //     ];
                // })->sortByDesc('count')->first();

                // $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                //     ->whereYear('date', $previousYear)
                //     ->whereMonth('date', $previousMonth)
                //     ->get();

                // $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) {
                //     $user = $group->first()->users;
                //     $member = $user->member()->select('circleId', 'businessCategoryId', 'profilePhoto')->first();
                //     $circle = Circle::find($member->circleId);
                //     $businessCategory = BusinessCategory::find($member->businessCategoryId);

                //     return [
                //         'user' => $user,
                //         'member' => $member,
                //         'amount' => $group->sum('amount'),
                //         'count' => $group->count(),
                //         'circle' => [
                //             'id' => $circle->id,
                //             'circleName' => $circle->circleName,
                //         ],
                //         'businessCategory' => [
                //             'id' => $businessCategory->id,
                //             'categoryName' => $businessCategory->categoryName,
                //         ],
                //     ];
                // })->sortByDesc('amount')->first();

                // $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                //     ->whereYear('created_at', $previousYear)
                //     ->whereMonth('created_at', $previousMonth)
                //     ->get()
                //     ->groupBy('referenceGiverId')
                //     ->map(function ($group) {
                //         $referenceGiverId = $group->first()->referenceGiverId ?? null;

                //         if ($referenceGiverId === null) {
                //             return null;
                //         }

                //         $user = User::find($referenceGiverId);

                //         if ($user && $user->status === 'Active') {
                //             $member = Member::where('userId', $referenceGiverId)->where('status', 'Active')->first();

                //             return [
                //                 'user' => $user,
                //                 'count' => $group->count(),
                //                 'businessCategoryId' => $member ? $member->businessCategoryId : null,
                //                 'businessCategory' => $member ? $member->bcategory->categoryName : null,
                //                 'circleId' => $member ? $member->circleId : null,
                //                 'circle' => $member ? $member->circle->circleName : null,
                //                 'profilePhoto' => $member ? $member->profilePhoto : null,
                //             ];
                //         }

                //         return null;
                //     })
                //     ->filter()
                //     ->sortByDesc('count')
                //     ->first();

                // Get the authenticated user
                // $authUser = auth()->user();

                // // Retrieve the member record for the authenticated user
                // $member = Member::where('userId', $authUser->id)->where('status', 'Active')->first();

                // if (!$member) {
                //     return response()->json(['message' => 'Member not found'], 404);
                // }

                // // Get the circle ID
                // $circleId = $member->circleId;

                // // Get the city ID from the circles table
                // $cityId = Circle::where('id', $circleId)->value('cityId');

                // if (!$cityId) {
                //     return response()->json(['message' => 'City not found'], 404);
                // }

                // $authId = Auth::id(); // Get authenticated user ID

                // // Fetch the authenticated user's circle ID from the Members table
                // $authMember = Member::where('userId', $authId)->first();
                // $authCircleId = $authMember ? $authMember->circleId : null;

                // // Get Circle Calls
                // $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                //     ->whereHas('member', function ($query) use ($cityId) {
                //         $query->whereHas('circle', function ($q) use ($cityId) {
                //             $q->where('cityId', $cityId);
                //         });
                //     })
                //     ->where('status', 'Active')
                //     ->whereYear('date', $previousYear)
                //     ->whereMonth('date', $previousMonth)
                //     ->get()
                //     ->groupBy('memberId')
                //     ->map(function ($group) {
                //         return [
                //             'member' => $group->first()->member,
                //             'count' => $group->count()
                //         ];
                //     })
                //     ->sortByDesc('count')
                //     ->first();

                // // Get Business Giver
                // $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                //     ->whereYear('date', $previousYear)
                //     ->whereMonth('date', $previousMonth)
                //     ->whereHas('users.member.circle', function ($query) use ($cityId) {
                //         $query->where('cityId', $cityId);
                //     })
                //     ->get()
                //     ->groupBy('businessGiverId')
                //     ->map(function ($group) {
                //         $user = $group->first()->users;
                //         $member = $user->member()->select('circleId', 'businessCategoryId', 'profilePhoto')->first();
                //         $circle = Circle::find($member->circleId);
                //         $businessCategory = BusinessCategory::find($member->businessCategoryId);

                //         return [
                //             'user' => $user,
                //             'member' => $member,
                //             'amount' => $group->sum('amount'),
                //             'count' => $group->count(),
                //             'circle' => [
                //                 'id' => $circle->id,
                //                 'circleName' => $circle->circleName,
                //             ],
                //             'businessCategory' => [
                //                 'id' => $businessCategory->id,
                //                 'categoryName' => $businessCategory->categoryName,
                //             ],
                //         ];
                //     })
                //     ->sortByDesc('amount')
                //     ->first();

                // // Get Reference Giver
                // $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                //     ->whereYear('created_at', $previousYear)
                //     ->whereMonth('created_at', $previousMonth)
                //     ->whereHas('refGiver', function ($query) use ($cityId) {
                //         $query->whereHas('circle', function ($subQuery) use ($cityId) {
                //             $subQuery->where('cityId', $cityId);
                //         });
                //     })
                //     ->get()
                //     ->groupBy('referenceGiverId')
                //     ->map(function ($group) {
                //         $referenceGiverId = $group->first()->referenceGiverId ?? null;

                //         if ($referenceGiverId === null) {
                //             return null;
                //         }

                //         $user = User::find($referenceGiverId);

                //         if ($user && $user->status === 'Active') {
                //             $member = Member::where('userId', $referenceGiverId)->where('status', 'Active')->first();

                //             return [
                //                 'user' => $user,
                //                 'count' => $group->count(),
                //                 'businessCategoryId' => $member ? $member->businessCategoryId : null,
                //                 'businessCategory' => $member ? $member->bcategory->categoryName : null,
                //                 'circleId' => $member ? $member->circleId : null,
                //                 'circle' => $member ? $member->circle->circleName : null,
                //                 'profilePhoto' => $member ? $member->profilePhoto : null,
                //             ];
                //         }

                //         return null;
                //     })
                //     ->filter()
                //     ->sortByDesc('count')
                //     ->first();

                $authUser = auth()->user();

                // Retrieve the member record for the authenticated user
                $member = Member::where('userId', $authUser->id)
                    ->where('status', 'Active')
                    ->first();

                if (! $member) {
                    return response()->json(['message' => 'Member not found'], 404);
                }

                // Get the circle ID
                $circleId = $member->circleId;

                // Get the city ID from the circles table
                $cityId = Circle::where('id', $circleId)->value('cityId');

                if (! $cityId) {
                    return response()->json(['message' => 'City not found'], 404);
                }

                $authId = auth()->id(); // Get authenticated user ID

                // Fetch the authenticated user's circle ID from the Members table
                $authMember = Member::where('userId', $authId)->first();
                $authCircleId = $authMember ? $authMember->circleId : null;

                // Get previous month and year
                $previousYear = now()->subMonth()->year;
                $previousMonth = now()->subMonth()->month;

                // Get Circle Calls
                $circlecalls = CircleCall::with(['member.circle', 'member.bCategory', 'meetingPerson'])
                    ->whereHas('member.circle', function ($query) use ($cityId) {
                        $query->where('cityId', $cityId);
                    })
                    ->where('status', 'Active')
                    ->whereYear('date', $previousYear)
                    ->whereMonth('date', $previousMonth)
                    ->get()
                    ->groupBy('memberId')
                    ->map(function ($group) {
                        return [
                            'member' => $group->first()->member,
                            'count' => $group->count(),
                        ];
                    })
                    ->sortByDesc('count')
                    ->first();

                // Get Business Giver
                $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                    ->whereYear('date', $previousYear)
                    ->whereMonth('date', $previousMonth)
                    ->whereHas('users.member.circle', function ($query) use ($cityId) {
                        $query->where('cityId', $cityId);
                    })
                    ->get()
                    ->groupBy('businessGiverId')
                    ->map(function ($group) {
                        $user = $group->first()->users;
                        $member = Member::with(['circle', 'bCategory'])
                            ->where('userId', $user->id)
                            ->where('status', 'Active')
                            ->first();

                        if (! $member) {
                            return null;
                        }

                        return [
                            'member' => $member,
                            'amount' => $group->sum('amount'),
                            'count' => $group->count(),
                        ];
                    })
                    ->filter()
                    ->sortByDesc('amount')
                    ->first();

                // Get Reference Giver
                $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                    ->whereYear('created_at', $previousYear)
                    ->whereMonth('created_at', $previousMonth)
                    ->whereHas('refGiver.circle', function ($query) use ($cityId) {
                        $query->where('cityId', $cityId);
                    })
                    ->get()
                    ->groupBy('referenceGiverId')
                    ->map(function ($group) {
                        $referenceGiverId = $group->first()->referenceGiverId ?? null;

                        if (! $referenceGiverId) {
                            return null;
                        }

                        $member = Member::with(['circle', 'bCategory'])
                            ->where('userId', $referenceGiverId)
                            ->where('status', 'Active')
                            ->first();

                        if (! $member) {
                            return null;
                        }

                        return [
                            'member' => $member,
                            'count' => $group->count(),
                        ];
                    })
                    ->filter()
                    ->sortByDesc('count')
                    ->first();

                if ($circlecalls && isset($circlecalls['member']) && $circlecalls['member']) {
                    $circlecalls['member']->loadMissing(['circle', 'bCategory']);
                    $this->setConnectionStatusForMember($circlecalls['member'], $authId, $authCircleId);
                }

                if ($busGiver && isset($busGiver['member']) && $busGiver['member']) {
                    $busGiver['member']->loadMissing(['circle', 'bCategory']);
                    $this->setConnectionStatusForMember($busGiver['member'], $authId, $authCircleId);
                }

                if ($refGiver && isset($refGiver['member']) && $refGiver['member']) {
                    $refGiver['member']->loadMissing(['circle', 'bCategory']);
                    $this->setConnectionStatusForMember($refGiver['member'], $authId, $authCircleId);
                }

                // Get Highest Induction
                $induction = Member::where('status', 'Active')
                    ->whereYear('created_at', $previousYear)
                    ->whereMonth('created_at', $previousMonth)
                    ->whereNotNull('sponsoredBy')
                    ->get()
                    ->groupBy('sponsoredBy')
                    ->map(function ($group) use ($cityId) {
                        $sponsorId = $group->first()->sponsoredBy;

                        if (! $sponsorId) {
                            return null;
                        }

                        $member = Member::with(['circle', 'bCategory'])
                            ->where('id', $sponsorId)
                            ->where('status', 'Active')
                            ->whereHas('circle', function ($query) use ($cityId) {
                                $query->where('cityId', $cityId);
                            })
                            ->first();

                        if (! $member) {
                            return null;
                        }

                        return [
                            'member' => $member,
                            'count' => $group->count(),
                        ];
                    })
                    ->filter()
                    ->sortByDesc('count')
                    ->first();

                if ($induction && isset($induction['member']) && $induction['member']) {
                    $induction['member']->loadMissing(['circle', 'bCategory']);
                    $this->setConnectionStatusForMember($induction['member'], $authId, $authCircleId);
                }

                // Leaderboard code end

                // leaderboard code end

                // monthly payment

                $monthlyPayments = MonthlyPayment::where('memberId', Auth::user()->member->id)
                    ->where('status', 'unpaid')
                    ->get()
                    ->groupBy('month');

                // Sum the total unpaid amounts
                $totalAmountDue = $monthlyPayments->map(function ($group) {
                    return $group->sum('amount');
                })->sum();

                $nearestEvents = Event::where('eventStatus', 'Publish')
                    ->where('status', 'Active')
                    ->whereDate('event_date', '>=', $currentDate)
                    ->orderBy('event_date', 'asc')
                    ->get();

                // $totalRegisterCount = isset($nearestEvents->id) ? VisitorEventRegister::where('eventId', $nearestEvents->id)->count() + EventRegister::where('eventId', $nearestEvents->id)->count() : 0;
                // $totalRegisterCount = VisitorEventRegister::where('eventId', $nearestEvents->id)->count() + EventRegister::where('eventId', $nearestEvents->id)->count();

                // if ($nearestEvents) {
                //     $findEventRegister = EventRegister::where('memberId', Auth::user()->member->id)
                //         ->where('eventId', $nearestEvents->id)
                //         ->get();
                // } else {
                //     $findEventRegister = [];
                // }

                // $registeredMembers = EventRegister::where('eventId', $nearestEvents->id)
                //     ->get();

                $today = Carbon::today()->format('m-d');
                $todaysBirthdays = Member::whereRaw("DATE_FORMAT(birthDate, '%m-%d') = ?", [$today])->get();

                $today = Carbon::today()->format('m-d');

                // Fetch users whose birthdays match today's date
                $todaysBirthdays = Member::whereRaw("DATE_FORMAT(birthdate, '%m-%d') = ?", [$today])->get();

                // Generate images for each user with a birthday today
                foreach ($todaysBirthdays as $user) {
                    $this->generateBirthdayWishImage($user);
                }

                $membersCount = Member::where('status', 'Active')->count();
                $circleCount = Circle::where('status', 'Active')->count();
                $pendingCount = Connection::where('memberId', Auth::id())
                    ->where('recordStatus', 'Active')
                    ->where('status', 'Pending')
                    ->count();
                $receivedRequests = Connection::whereHas('member', function ($query) use ($authUser) {
                    $query->where('memberId', $authUser->id);
                })
                    ->with('member')
                    ->where('recordStatus', 'Active')
                    ->where('status', 'Pending')
                    ->paginate(10);

                $notifications = Notifications::latest()->get()->filter(function ($notification) use ($authUser) {
                    $data = json_decode($notification->data, true);
                    $type = $data['type'] ?? null;
                    // Connection Request -> Show to Receiver
                    if ($type == 'connection_request') {
                        return isset($data['memberId']) && $data['memberId'] == $authUser->id;
                    }
                    // Accept or Reject -> Show to Original Sender
                    if ($type == 'connection_accept' || $type == 'connection_reject') {
                        return isset($data['memberId']) && $data['memberId'] == $authUser->id;
                    }
                    if ($type == 'chat_message') {
                        return isset($data['memberId']) && $data['memberId'] == $authUser->id;
                    }
                    if ($type == 'reference_created') {
                        return isset($data['memberId']) && $data['memberId'] == $authUser->id;
                    }

                    return false;
                })->map(function ($notification) {
                    $data = json_decode($notification->data, true);
                    $notification->type = $data['type'] ?? null;
                    $notification->connection_id = $data['connection_id'] ?? null;
                    // sender = who performed action
                    $notification->sender = User::find($data['userId'] ?? null);
                    // receiver = who receives notification
                    $notification->receiver = User::find($data['memberId'] ?? null);
                    return $notification;
                });

                $notificationCount = $notifications->where('is_read', false)->count();
                // $posts = Post::with([
                //     'user.member',
                //     'media'
                // ])
                //     ->withCount(['likes', 'comments'])
                //     ->latest()
                //     ->take(8) // show 8 posts on dashboard
                //     ->get();
                $posts = Post::where('status', 'Active')
                    ->whereNotNull('attachment')
                    ->where('attachment', '!=', '')
                    ->with(['user.member', 'media'])
                    ->withCount(['likes', 'comments'])
                    ->latest()
                    ->take(8)
                    ->get();
                // dd($receivedRequests);
                // $authUserId = Auth::user()->member->userId;
                // $circleId = Member::where('userId', $authUserId)->value('circleId');
                // $businessCategoryId = Circle::where('id', $circleId)->value('businessCategoryId');
                // // $categoryName = BusinessCategory::where('id', $businessCategoryId)->value('categoryName');

                // $authUserId = Auth::user()->member->userId;
                // $circleId = Member::where('userId', $authUserId)->value('circleId');

                // $businessCategoryId = Circle::where('id', $circleId)->value('businessCategoryId');
                // $businessCategoryIdArray = explode(',', $businessCategoryId);

                // $businessCategories = BusinessCategory::whereIn('id', json_decode($businessCategoryId))->get();

                // $categoryNames = $businessCategories->pluck('categoryName');

                $authUserId = Auth::user()->member->userId;
                $circleId = Member::where('userId', $authUserId)->value('circleId');

                $businessCategoryId = Circle::where('id', $circleId)->value('businessCategoryId');

                // Decode JSON properly instead of explode
                $businessCategoryIdArray = $businessCategoryId ? json_decode($businessCategoryId, true) : [];

                $businessCategories = collect(); // Default empty collection

                if (! empty($businessCategoryIdArray)) {
                    $businessCategories = BusinessCategory::whereIn('id', $businessCategoryIdArray)->get();
                }
                $city = City::where('status', 'Active')->get();


                $missingFields = [];

                if (Auth::check()) {

                    $member = Member::where('userId', Auth::id())->first();
                    $user = Auth::user();
                    $contact = ContactDetails::where('memberId', $member->id ?? 0)->first();

                    // ✅ Helper function (VERY IMPORTANT)
                    function isEmptyField($value)
                    {
                        if (is_null($value)) return true;

                        $value = trim((string)$value);

                        return $value === '' || $value === '-' || strtolower($value) === 'null';
                    }
                    if ($member) {

                        // ================= MEMBER =================

                        if (isEmptyField($member->title)) {
                            $missingFields[] = 'Title';
                        }

                        if (isEmptyField($member->firstName)) {
                            $missingFields[] = 'First Name';
                        }

                        if (isEmptyField($member->lastName)) {
                            $missingFields[] = 'Last Name';
                        }

                        if (isEmptyField($member->gender)) {
                            $missingFields[] = 'Gender';
                        }

                        // if (isEmptyField($member->birthDate)) {
                        //     $missingFields[] = 'Birth Date';
                        // }

                        if (isEmptyField($member->companyName)) {
                            $missingFields[] = 'Company Name';
                        }

                        if (isEmptyField($member->webSite)) {
                            $missingFields[] = 'Website';
                        }

                        // if (isEmptyField($member->gstinPan)) {
                        //     $missingFields[] = 'GST/PAN';
                        // }

                        $landmarks = collect();

                        if (!empty($member->cityId)) {
                            $landmarks = Landmark::where('cityId', $member->cityId)->pluck('name');
                        }

                        if (isEmptyField($member->landmark)) {
                            $missingFields[] = 'Landmark';
                        }

                        if (empty($member->profilePhoto) || !file_exists(public_path('ProfilePhoto/' . $member->profilePhoto))) {
                            $missingFields[] = 'Profile Photo';
                        }
                        if (empty($member->companyLogo) || !file_exists(public_path('CompanyLogo/' . $member->companyLogo))) {
                            $missingFields[] = 'Company Logo';
                        }

                        // ================= KEYWORDS =================
                        $keywords = [];

                        if (!empty($member->keyWords)) {
                            $decoded = json_decode($member->keyWords, true);
                            if (is_array($decoded)) {
                                $keywords = array_filter($decoded);
                            }
                        }

                        if (empty($keywords)) {
                            $missingFields[] = 'Keywords';
                        }
                    }

                    // ================= USER =================

                    if (isEmptyField($user->email)) {
                        $missingFields[] = 'Email';
                    }

                    if (isEmptyField($user->contactNo)) {
                        $missingFields[] = 'Contact Number';
                    }

                    // ================= CONTACT =================

                    if ($contact) {

                        if (isEmptyField($contact->addressLine1)) {
                            $missingFields[] = 'Address Line 1';
                        }

                        if (isEmptyField($contact->addressLine2)) {
                            $missingFields[] = 'Address Line 2';
                        }
                    } else {

                        $missingFields[] = 'Address Line 1';
                        $missingFields[] = 'Address Line 2';
                    }
                }
                // $latestCircleMembers = Member::with('circle')->where('status', 'Active')->where('membershipType', 'Supreme - Yearly')->orderBy('created_at', 'desc')->take(4)->get();
                $latestCircleMembers = Member::with(['circle', 'user', 'bCategory', 'sponsored'])
                    ->where('status', 'Active')
                    ->where('membershipType', 'Supreme - Yearly')
                    ->orderBy('created_at', 'desc')
                    ->take(4)
                    ->get()
                    ->map(function ($member) use ($authUserId) {

                        $connection = Connection::where(function ($q) use ($authUserId, $member) {
                            $q->where('userId', $authUserId)
                                ->where('memberId', $member->userId);
                        })->orWhere(function ($q) use ($authUserId, $member) {
                            $q->where('userId', $member->userId)
                                ->where('memberId', $authUserId);
                        })->first();

                        if ($connection) {

                            if ($connection->status === 'Accepted') {
                                $member->connection_status = 'Accepted';
                            } else {
                                // 🔥 KEY LOGIC
                                if ($connection->userId == $authUserId) {
                                    $member->connection_status = 'Requested'; // YOU sent
                                } else {
                                    $member->connection_status = 'Pending'; // received
                                }
                            }
                        } else {
                            $member->connection_status = 'Not Connected';
                        }

                        return $member;
                    });
                $latestDigitalMembers = Member::with('circle')->where('status', 'Active')->where('membershipType', 'Digital Membership')->orderBy('created_at', 'desc')->take(4)->get();

                // dd($missingFields);
                $categoryNames = $businessCategories->pluck('categoryName');

                return view('home', compact('circleCount', 'authCircleId', 'categoryNames', 'membersCount', 'signedUrl', 'birthdaysToday', 'templates', 'count', 'monthlyPayments', 'totalAmountDue', 'nearestEvents', 'circlecalls', 'busGiver', 'refGiver', 'induction', 'nearestTraining', 'testimonials', 'meeting', 'businessCategory', 'myInvites', 'todaysBirthdays', 'pendingCount', 'receivedRequests', 'notifications', 'notificationCount', 'posts', 'missingFields', 'member', 'city', 'landmarks', 'latestCircleMembers', 'latestDigitalMembers'));
            }

            return view('home', compact('circleCount', 'membersCount', 'count', 'nearestTraining', 'businessCategory', 'myInvites', 'birthdaysToday', 'templates', 'pendingCount'));
        } catch (\Throwable $th) {
            // Log the error
            throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view or message
            return view('servererror')->with('error', 'Failed to load the dashboard');
        }
    }

    public function birthday($id)
    {
        $person = Member::where('userId', $id)->first();
        $templates = TemplateMaster::all();

        // $template = TemplateMaster::with('TemplateDetail')->get();
        return view('admin.birthday.index', compact('person', 'templates'));
    }

    private function generateBirthdayWishImage($member)
    {
        $width = 800;
        $height = 400;

        // Create a blank image
        $image = imagecreatetruecolor($width, $height);

        // Define colors
        $backgroundColor = imagecolorallocate($image, 255, 235, 59); // Yellow
        $textColor = imagecolorallocate($image, 51, 51, 51); // Dark Gray

        // Fill the background
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);

        // Set birthday text
        $text = "Happy Birthday, {$member->firstName}!";
        $fontSize = 5;

        // Calculate text positioning to center it
        $textWidth = imagefontwidth($fontSize) * strlen($text);
        $textX = ($width - $textWidth) / 2;
        $textY = ($height / 2) - (imagefontheight($fontSize) / 2);

        // Add text using built-in GD font
        imagestring($image, $fontSize, $textX, $textY, $text, $textColor);

        // Define the directory path
        $directoryPath = public_path('birthday_images');

        // Check if the directory exists; if not, create it
        if (! is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        // Save the image
        $path = "{$directoryPath}/{$member->id}_birthday.png";
        imagepng($image, $path);

        // Free up memory
        imagedestroy($image);
    }

    private function setConnectionStatusForMember($member, $authUserId, $authCircleId)
    {
        if (! $member) {
            return;
        }

        $connection = Connection::where(function ($query) use ($authUserId, $member) {
            $query->where('userId', $authUserId)
                ->where('memberId', $member->userId)
                ->orWhere(function ($query) use ($authUserId, $member) {
                    $query->where('userId', $member->userId)
                        ->where('memberId', $authUserId);
                });
        })->first();

        if (! $connection) {
            $member->connection_status = 'Not Connected';

            return;
        }

        $status = $connection->status;
        if ($status === 'Accepted') {
            $member->connection_status = 'Connected';

            return;
        }

        if ($status === null || $status === '') {
            $member->connection_status = 'Pending';

            return;
        }

        $member->connection_status = $status;
    }

    public function trainingRegister($trainingId)
    {
        try {
            $register = new TrainingRegister;
            $register->userId = Auth::user()->id;
            $register->trainingId = $trainingId;
            // $register->trainerId = $trainerId;
            $register->save();

            return redirect()->back()->with('success', 'Training Registered Successfully');
        } catch (\Throwable $th) {
            // Log the error
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to register for the training. Please try again.');
        }
    }

    public function eventRegister($eventId, Request $request)
    {
        try {
            $eventregister = new EventRegister;
            $eventregister->userId = Auth::user()->id;
            $eventregister->eventId = $eventId;
            $eventregister->personName = $request->personName;
            $eventregister->personEmail = $request->personEmail;
            $eventregister->personContact = $request->personContact;
            $eventregister->save();

            return redirect()->back()->with('success', 'Event Registered Successfully');
        } catch (\Throwable $th) {
            // Log the error
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to register for the Event. Please try again.');
        }
    }

    public function invitation(Request $request)
    {
        try {
            $request->validate([
                'personName' => 'required',
                'personEmail' => 'required',
                'personContact' => 'required|max:10',
                'businessCategoryId' => 'required',
            ]);

            if (strlen($request->personContact) <= 10) {
                $invitation = new MeetingInvitation;
                $invitation->meetingId = $request->meetingId;
                $invitation->invitedMemberId = Auth::user()->id;
                $invitation->personName = $request->personName;
                $invitation->personEmail = $request->personEmail;
                $invitation->personContact = $request->personContact;
                $invitation->businessCategoryId = $request->businessCategoryId;
                $invitation->save();
            }

            $fees = Schedule::where('id', $request->meetingId)->with('circle.city')->first();
            $personName = $request->personName;
            $personEmail = $request->personEmail;
            $invitedPerson = User::where('id', Auth::user()->id)->first();
            $invitedPersonFirstName = $invitedPerson->firstName;
            $invitedPersonLastName = $invitedPerson->lastName;
            $amount = $fees->circle->city->amount;
            $data = [
                'personName' => $personName,
                'personEmail' => $personEmail,
                'invitedPersonFirstName' => $invitedPersonFirstName,
                'invitedPersonLastName' => $invitedPersonLastName,
                'amount' => $amount,
            ];

            if (isset($invitation)) {
                Mail::to($request->personEmail)->send(new MailMeetingInvitation($data));

                return redirect()->back()->with('success', 'Invitation Sent Successfully');
            }

            return redirect()->back()->with('error', 'Please Enter Correct Number');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->back()->with('error', 'An error occurred while sending the invitation. Please try again.');
        }
    }

    public function invitationPay($firstName, $lastName, $amount)
    {
        try {
            $amounts = $amount;
            $data = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'amount' => $amount,
            ];
            if (! session()->has('data')) {
                session(['data' => $data]);
            }

            return view('invitationPay', compact('data'));
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to load invitation payment details. Please try again.');
        }
    }

    public function findMember()
    {
        try {
            return view('find');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to load member search page. Please try again.');
        }
    }

    // public function search(Request $request)
    // {
    //     try {
    //         $query = $request->input('query');
    //         $authId = Auth::id(); // Get authenticated user ID

    //         // Fetch the authenticated user's circle ID from the Members table
    //         $authMember = Member::where('userId', $authId)->first();
    //         $authCircleId = $authMember ? $authMember->circleId : null;

    //         $members = Member::where('userId', '!=', $authId)
    //             ->where('status', 'Active')
    //             ->where(function ($q) use ($query) {
    //                 $q->where('firstName', 'like', '%' . $query . '%')
    //                     ->orWhere('lastName', 'like', '%' . $query . '%')
    //                     ->orWhere('keyWords', 'like', '%' . $query . '%');
    //             })
    //             ->with(['user', 'circle', 'bCategory'])
    //             ->get();

    //         // Add connection status for each member
    //         $members->map(function ($member) use ($authId, $authCircleId) {
    //             // Check if the member is in the same circle
    //             if ($authCircleId !== null && $member->circleId == $authCircleId) {
    //                 $member->connection_status = 'Connected';
    //             } else {
    //                 // Fetch actual connection status
    //                 $connection = Connection::where(function ($query) use ($authId, $member) {
    //                     $query->where('userId', $authId)->where('memberId', $member->userId)
    //                         ->orWhere(function ($query) use ($authId, $member) {
    //                             $query->where('userId', $member->userId)->where('memberId', $authId);
    //                         });
    //                 })->first();

    //                 $member->connection_status = $connection ? $connection->status : 'Not Connected';
    //             }

    //             // If connection exists and is 'Accepted', always mark as 'Connected'
    //             if ($member->connection_status !== 'Connected' && isset($connection) && $connection->status === 'Accepted') {
    //                 $member->connection_status = 'Connected';
    //             }

    //             $member->induction_count = Member::where('sponsoredBy', $member->id)->count() ?? 0;
    //         });

    //         return response()->json([
    //             'message' => "Search results for '$query'",
    //             'members' => $members,
    //         ]);
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return response()->json(['error' => 'Failed to perform search. Please try again.'], 500);
    //     }
    // }

    // public function search(Request $request)
    // {
    //     try {
    //         $query = $request->input('query');
    //         $authId = Auth::id(); // Get authenticated user ID

    //         // Fetch the authenticated user's circle ID from the Members table
    //         $authMember = Member::where('userId', $authId)->first();
    //         $authCircleId = $authMember ? $authMember->circleId : null;

    //         $members = Member::where('userId', '!=', $authId)
    //             ->whereNotNull('circleId')     // ✅ circleId is NOT NULL
    //             ->where('status', 'Active')
    //             ->where(function ($q) use ($query) {
    //                 $q->where('firstName', 'like', '%' . $query . '%')
    //                     ->orWhere('lastName', 'like', '%' . $query . '%')
    //                     ->orWhere('keyWords', 'like', '%' . $query . '%');
    //             })
    //             ->with(['user', 'circle', 'bCategory'])
    //             ->get();

    //         // Add connection status for each member
    //         $members->map(function ($member) use ($authId, $authCircleId) {
    //             if ($authCircleId !== null && $member->circleId == $authCircleId) {
    //                 $member->connection_status = 'Connected';
    //             } else {
    //                 $connection = Connection::where(function ($query) use ($authId, $member) {
    //                     $query->where('userId', $authId)->where('memberId', $member->userId)
    //                         ->orWhere(function ($query) use ($authId, $member) {
    //                             $query->where('userId', $member->userId)->where('memberId', $authId);
    //                         });
    //                 })->first();

    //                 $member->connection_status = $connection ? $connection->status : 'Not Connected';
    //             }

    //             if ($member->connection_status !== 'Connected' && isset($connection) && $connection->status === 'Accepted') {
    //                 $member->connection_status = 'Connected';
    //             }

    //             $member->induction_count = Member::where('sponsoredBy', $member->id)->count() ?? 0;
    //         });

    //         return response()->json([
    //             'message' => "Search results for '$query'",
    //             'members' => $members,
    //         ]);
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return response()->json(['error' => 'Failed to perform search. Please try again.'], 500);
    //     }
    // }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $authId = Auth::id(); // Get authenticated user ID

            // Fetch the authenticated user's circle ID from the Members table
            $authMember = Member::where('userId', $authId)->first();
            $authCircleId = $authMember ? $authMember->circleId : null;

            $normalized = strtolower(trim($query));

            if ($normalized === 'digital member') {
                $members = Member::where('userId', '!=', $authId)
                    ->where('status', 'Active')
                    ->whereNull('circleId')
                    ->with(['user', 'circle', 'bCategory'])
                    ->get();
            } else {
                $members = Member::where('userId', '!=', $authId)
                    ->where('status', 'Active')
                    ->where(function ($q) use ($query) {
                        $q->where('firstName', 'like', '%' . $query . '%')
                            ->orWhere('lastName', 'like', '%' . $query . '%')
                            ->orWhere('keyWords', 'like', '%' . $query . '%');
                    })
                    ->with(['user', 'circle', 'bCategory'])
                    ->get();
            }

            // ✅ Add connection status and induction count
            $members->map(function ($member) use ($authId, $authCircleId) {
                // Connection by same circle
                $connection = null;
                if ($authCircleId !== null && $member->circleId == $authCircleId) {
                    $member->connection_status = 'Connected';
                } else {
                    $connection = Connection::where(function ($query) use ($authId, $member) {
                        $query->where('userId', $authId)
                            ->where('memberId', $member->userId)
                            ->orWhere(function ($query) use ($authId, $member) {
                                $query->where('userId', $member->userId)
                                    ->where('memberId', $authId);
                            });
                    })->first();

                    $member->connection_status = $connection ? $connection->status : 'Not Connected';
                }

                // Force "Connected" if accepted connection found
                if ($member->connection_status !== 'Connected' && isset($connection) && $connection->status === 'Accepted') {
                    $member->connection_status = 'Connected';
                }
                if ($member->connection_status !== 'Connected') {
                    if ($member->user) {
                        $member->user->email = null;
                        $member->user->contactNo = null;
                    }
                }
                // Count inductions sponsored by this member
                $member->induction_count = Member::where('sponsoredBy', $member->id)->count() ?? 0;
            });

            return response()->json([
                'message' => "Search results for '$query'",
                'members' => $members,
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json(['error' => 'Failed to perform search. Please try again.'], 500);
        }
    }

    // digital member serarch

    public function digitalMemberSearch(Request $request)
    {
        try {
            $query = $request->input('query');
            $authId = Auth::id(); // Get authenticated user ID

            // Fetch the authenticated user's circle ID from the Members table
            $authMember = Member::where('userId', $authId)->first();
            $authCircleId = $authMember ? $authMember->circleId : null;

            $members = Member::where('userId', '!=', $authId)
                ->whereNull('circleId')       // circleId is NULL
                ->whereNotNull('cityId')      // cityId is NOT NULL
                ->where('status', 'Active')
                ->where(function ($q) use ($query) {
                    $q->where('firstName', 'like', '%' . $query . '%')
                        ->orWhere('lastName', 'like', '%' . $query . '%')
                        ->orWhere('keyWords', 'like', '%' . $query . '%');
                })
                ->with(['user', 'city', 'bCategory'])
                ->get();

            // Add connection status for each member
            $members->map(function ($member) use ($authId, $authCircleId) {
                // Check if the member is in the same circle
                if ($authCircleId !== null && $member->circleId == $authCircleId) {
                    $member->connection_status = 'Connected';
                } else {
                    $connection = Connection::where(function ($query) use ($authId, $member) {
                        $query->where('userId', $authId)->where('memberId', $member->userId)
                            ->orWhere(function ($query) use ($authId, $member) {
                                $query->where('userId', $member->userId)->where('memberId', $authId);
                            });
                    })->first();

                    $member->connection_status = $connection ? $connection->status : 'Not Connected';
                }

                // If connection exists and is 'Accepted', mark as Connected
                if ($member->connection_status !== 'Connected' && isset($connection) && $connection->status === 'Accepted') {
                    $member->connection_status = 'Connected';
                }

                $member->induction_count = Member::where('sponsoredBy', $member->id)->count() ?? 0;
            });

            return response()->json([
                'message' => "Search results for '$query'",
                'members' => $members,
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json(['error' => 'Failed to perform search. Please try again.'], 500);
        }
    }

    // public function search(Request $request)
    // {
    //     try {
    //         $query = $request->input('query');
    //         $authId = Auth::id(); // Get authenticated user ID

    //         $members = Member::where('userId', '!=', $authId)
    //             ->where('status', 'Active')
    //             ->where(function ($q) use ($query) {
    //                 $q->where('firstName', 'like', '%' . $query . '%')
    //                     ->orWhere('lastName', 'like', '%' . $query . '%')
    //                     ->orWhere('keyWords', 'like', '%' . $query . '%');
    //             })
    //             ->with(['user', 'circle', 'bCategory'])
    //             ->get();

    //         // Add connection status for each member
    //         $members->map(function ($member) use ($authId) {
    //             $connection = Connection::where(function ($query) use ($authId, $member) {
    //                 $query->where('userId', $authId)->where('memberId', $member->id)
    //                     ->orWhere(function ($query) use ($authId, $member) {
    //                         $query->where('userId', $member->id)->where('memberId', $authId);
    //                     });
    //             })->first();

    //             // Set connection status
    //             $member->connection_status = $connection ? $connection->status : 'Not Connected';
    //         });

    //         return response()->json([
    //             'message' => "Search results for '$query'",
    //             'members' => $members,
    //         ]);
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return response()->json(['error' => 'Failed to perform search. Please try again.'], 500);
    //     }
    // }
    // public function search(Request $request)
    // {
    //     try {

    //         $query = $request->input('query');
    //         $members = Member::where('userId', '!=', Auth::user()->id)
    //             ->where('status', 'Active')
    //             ->where(function ($q) use ($query) {
    //                 $q
    //                     ->where('firstName', 'like', '%' . $query . '%')
    //                     ->orWhere('lastName', 'like', '%' . $query . '%')
    //                     ->orWhere('keyWords', 'like', '%' . $query . '%');
    //             })
    //             // ->whereHas('circle', function ($q) use ($query) {
    //             //     $q->where('circleName', 'like', '%' . $query . '%');
    //             // })
    //             ->with('user', 'circle', 'bCategory')
    //             ->get();

    //         // $members = Member::where('keyWords', 'like', '%' . $query . '%')->get();

    //         $message = "Search results for '$query'";

    //         return response()->json([
    //             'message' => $message,
    //             'members' => $members,
    //         ]);
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         // throw $th;
    //         ErrorLogger::logError($th, request()->fullUrl());

    //         // Return with an error message
    //         return response()->json(['error' => 'Failed to perform search. Please try again.'], 500);
    //     }
    // }

    // public function foundPersonDetails($id)
    // {
    //     try {
    //         $aid = Auth::id(); // Get the ID of the authenticated user
    //         $member = Member::find($id);

    //         // Find connection based on the authenticated user's ID and member ID
    //         $connection = Connection::where('userId', $aid)
    //             ->orWhere('memberId', $aid)
    //             ->first();

    //         $memberStatus = Connection::where('memberId', $aid)
    //             ->orWhere('userId', $aid)
    //             ->first();

    //         // Alternatively, if you want to get all connections related to the authenticated user:
    //         // $connections = Connection::where('userId', $aid)->get();

    //         return view('foundPersonDetails', compact('member', 'connection', 'memberStatus'));
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         // In case of an error, redirect to servererror view
    //         return view('servererror');
    //     }
    // }

    public function foundPersonDetails($id)
    {
        try {
            $authId = Auth::id();
            $member = Member::with('circle')->find($id); // include relationship to avoid N+1

            if (! $member) {
                return redirect()->back()->with('error', 'Member not found.');
            }

            $authMember = Member::where('userId', $authId)->first();
            $userCircleId = $authMember ? $authMember->circleId : null;
            $memberCircleId = $member->circleId;

            $memberInduction = Member::where('sponsoredBy', $id)->count();

            // Get all connections between the authenticated user and the found member
            $connections = Connection::where(function ($query) use ($authId, $member) {
                $query->where('userId', $authId)->where('memberId', $member->userId)
                    ->orWhere(function ($query) use ($authId, $member) {
                        $query->where('userId', $member->userId)->where('memberId', $authId);
                    });
            })->get();

            $connection = $connections->first(); // Single connection (if needed in the view)

            // Determine connection status
            if ($userCircleId !== null && $memberCircleId == $userCircleId) {
                $member->connection_status = 'Connected';
            } elseif ($connection && $connection->status === 'Accepted') {
                $member->connection_status = 'Connected';
            } else {
                $member->connection_status = $connection ? $connection->status : 'Not Connected';
            }
            $testimonials = Testimonial::with(['user', 'sender'])->where('memberId', $member->userId)->latest()->get();

            $memberGallery = MemberGallery::where('memberId', $member->id)->where('status', 'Active')->latest()->get();
            return view('foundPersonDetails', compact(
                'member',
                'connections',
                'connection',
                'userCircleId',
                'memberCircleId',
                'memberInduction',
                'testimonials',
                'memberGallery'
            ));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return view('servererror');
        }
    }

    public function accepted($id)
    {
        try {
            $connection = Connection::findOrFail($id);
            $connection->status = 'Accepted';
            $connection->save();

            return redirect()->back()->with('success', 'Connection request accepted');
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to accept connection request. Please try again.');
        }
    }

    public function rejected($id)
    {
        try {
            $connection = Connection::findOrFail($id);
            $connection->status = 'Rejected';
            $connection->save();

            return redirect()->back()->with('error', 'Connection request rejected');
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to reject connection request. Please try again.');
        }
    }


    // public function notifications()
    // {
    //     try {
    //         // Get the authenticated user's ID
    //         $userId = Auth::user()->id;

    //         // Query to get connection requests
    //         $receivedRequests = Connection::whereHas('member', function ($query) use ($userId) {
    //             $query->where('memberId', $userId);
    //         })
    //             ->with('member')
    //             ->where('status', 'Pending')
    //             ->paginate(10);
    //         $pendingCount = Connection::where('memberId', $userId)
    //             ->where('recordStatus', 'Active')
    //             ->where('status', 'Pending')
    //             ->count();
    //         // return $receivedRequests;
    //         // Return the view with the connections data
    //         return view('layouts.connectionRequests', compact('receivedRequests', 'pendingCount'));
    //     } catch (\Throwable $th) {
    //         // Log the error using the ErrorLogger utility
    //         ErrorLogger::logError($th, request()->fullUrl());

    //         // Return a custom error view or redirect with an error message
    //         return view('servererror');
    //     }
    // }
    public function notifications()
    {
        try {

            $userId = Auth::id();

            $notifications = Notifications::latest()->get()->filter(function ($notification) use ($userId) {

                $data = json_decode($notification->data, true);

                if (is_string($data)) {
                    $data = json_decode($data, true);
                }

                if (!$data) return false;
                $type = $data['type'] ?? null;

                $memberId = isset($data['memberId']) ? (int)$data['memberId'] : null;
                $senderId = isset($data['userId']) ? (int)$data['userId'] : null;

                // // Connection Request -> Show to Receiver
                // if ($type == 'connection_request') {
                //     return $memberId === (int)$userId;
                // }

                // // Accept or Reject -> Show to Original Sender
                // if ($type == 'connection_accept' || $type == 'connection_reject') {
                //     return $memberId === (int)$userId;
                // }
                // // 🔥 FIXED CHAT MESSAGE LOGIC
                // if ($type == 'chat_message') {
                //     return $memberId === $userId || $senderId === $userId;
                // }
                if ($type == 'connection_request') {
                    return $memberId === $userId;
                }

                if (in_array($type, ['connection_accept', 'connection_reject'])) {
                    return $memberId === $userId;
                }

                if ($type == 'chat_message') {
                    return $memberId === $userId;
                }
                if ($type == 'reference_created') {
                    return $memberId === $userId;
                }

                return false;
            })->map(function ($notification) {

                $data = json_decode($notification->data, true);

                $notification->type = $data['type'] ?? null;
                $notification->connection_id = $data['connection_id'] ?? null;

                // sender = who performed action
                $notification->sender = User::find($data['userId'] ?? null);

                // receiver = who receives notification
                $notification->receiver = User::find($data['memberId'] ?? null);

                return $notification;
            });

            $notificationCount = $notifications->where('is_read', false)->count();

            return view('layouts.connectionRequests', compact('notifications', 'notificationCount'));
        } catch (\Throwable $th) {

            ErrorLogger::logError($th, request()->fullUrl());

            return view('servererror');
        }
    }
    public function markAsRead($id)
    {

        $notification = Notifications::find($id);

        if (!$notification) {
            return redirect()->back();
        }

        // ✅ Mark as read
        if (!$notification->is_read) {
            $notification->is_read = 1;
            $notification->save();
        }

        $data = json_decode($notification->data, true);
        $type = $data['type'] ?? null;

        if ($type === 'connection_request') {
            return redirect()->route('connection.myConnections', [
                'tab' => 'received'
            ]);
        }

        if ($type === 'connection_accept' || $type === 'connection_reject') {
            return redirect()->route('connection.myConnections', [
                'tab' => 'connections'
            ]);
        }
        if ($type === 'chat_message') {
            return redirect()->route('chat.index', [
                'userId' => $data['userId'] ?? null
            ]);
        }
        if ($type === 'reference_created') {
            return redirect()->route('chat.index', [
                'userId' => $data['userId'] ?? null
            ]);
        }

        return redirect()->back();
    }

    public function userDetails()
    {
        try {
            $ip = request()->ip(); // Dynamic IP address get
            $ipData = \Location::get($ip);

            return view('location', compact('ipData'));
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return view('location', ['ipData' => null])->with('error', 'Failed to retrieve location information. Please try again.');
        }
    }
}
