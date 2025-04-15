{{-- <li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('circlecall.index') }}">
        <i class="bi bi-mic text-orange"></i>
        <span class="text-blue">Business Meet</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('refGiver.index') }}">
        <i class="bi bi-person  text-orange"></i>
        <span class="text-blue">Reference</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('busGiver.index') }}">
        <i class="bi bi-building text-orange"></i>
        <span class="text-blue">Business Slip</span>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('connection.index') }}">
        <i class="bi bi-person-heart" style="color: #e76a35"></i>
        <span style="color: #1d2865;">Connection Request</span>
    </a>
</li> --}}

{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('chat.index') }}">
        <i class="bi bi-chat" style="color: #e76a35"></i>
        <span class="text-blue">My Chats</span>
    </a>
</li> --}}

@role('Vice President')
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#allActivityVp-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-person-gear" style="color: #e76a35"></i><span>My Circle Activity</span><i class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
        </a>
        <ul id="allActivityVp-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('testimonials.indexAdmin') }}">
                <i class="bi bi-person" style="color: #e76a35"></i>
                <span style="color: #1d2856">Testimonial</span>
            </a>
        </li> --}}

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('activity.ibmVp') }}">
                    <i class="bi bi-person" style="color: #e76a35"></i>
                    <span style="color: #1d2856">IBM</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('activity.refrenceVp') }}">
                    <i class="bi bi-person" style="color: #e76a35"></i>
                    <span style="color: #1d2856">References</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('activity.businessesVp') }}">
                    <i class="bi bi-person" style="color: #e76a35"></i>
                    <span style="color: #1d2856">Business Slip</span>
                </a>
            </li>

        </ul>
    </li>
@endrole

@role('Circle Admin')
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#circle-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-plus-circle-dotted" style="color: #e76a35"></i><span>Circle</span><i class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
        </a>
        <ul id="circle-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li class="nav-item">
                <a class="nav-link " href="{{ route('circle.index') }}">
                    <i class="bi bi-plus-circle-dotted" style="color: #e76a35"></i>
                    <span>Circle List</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link " href="{{ route('circlemember.index') }}">
                    <i class="bi bi-plus-circle-dotted" style="color: #e76a35"></i>
                    <span>Circle Member</span>
                </a>
            </li>
        </ul>
    </li>
@endrole



<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#activity-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-plus-circle-dotted" style="color: #e76a35"></i><span>Activity</span><i class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>
    <ul id="activity-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('circlecall.index') }}">
                <i class="bi bi-mic text-orange"></i>
                <span class="text-blue">IBM</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('refGiver.index') }}">
                <i class="bi bi-person  text-orange"></i>
                <span class="text-blue">References</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('busGiver.index') }}">
                <i class="bi bi-building text-orange"></i>
                <span class="text-blue">Business Slip</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('testimonial.index') }}">
                <i class="bi bi-chat-quote text-orange"></i>
                <span class="text-blue">Testimonial</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('specificask.index') }}">
                <i class="bi bi-chat-quote text-orange"></i>
                <span class="text-blue">Specific Ask</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('chat.index') }}">
        <i class="bi bi-chat" style="color: #e76a35"></i>
        <span class="text-blue">My Chats</span>
    </a>
</li>

<a class="nav-link collapsed" href="{{ route('member.eventIndex') }}">
    <i class="bi bi-calendar-event" style="color: #e76a35"></i>
    <span style="color: #1d2865 ;">Event</span>
</a>

<a class="nav-link collapsed" href="{{ route('trainingFeedback.memberIndex') }}">
    <i class="bi bi-calendar-event" style="color: #e76a35"></i>
    <span style="color: #1d2865 ;">Training</span>
</a>

<li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('circleWiseLeaderboard.index') }}">
        <i class="bi bi-chat-quote text-orange"></i>
        <span class="text-blue">Circle Leaderboard</span>
    </a>
</li>

{{-- <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#connection-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person-heart" style="color: #e76a35"></i><span>My Network</span><i class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>
    <ul id="connection-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.circleList') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Circle</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.categoryList') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Category</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.connectionRequests') }}">
                <i class="bi bi-person-heart" style="color: #e76a35"></i>
                <span>Received Connection Request</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.sentConnectionRequests') }}">
                <i class="bi bi-person-heart" style="color: #e76a35"></i>
                <span>Sent Connection Request</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.myConnections') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>My Connection</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.myCircleConnections') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>My Circle Connection</span>
            </a>
        </li>

    </ul>
</li> --}}


<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#Newconnection-nav" data-bs-toggle="collapse" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" height="15px" viewBox="0 -960 960 960" width="15px" fill="#e76a35">
            <path d="M234-40q-47.5 0-80.75-33.25T120-154q0-47.5 33.25-80.75T234-268q14 0 24.5 2.5T280-258l85-106q-19-23-29-52.5t-5-61.5l-121-41q-15 25-39.5 39T114-466q-47.5 0-80.75-33.25T0-580q0-47.5 33.25-80.75T114-694q47.5 0 80.75 33.25T228-580v4l122 42q18-32 43.5-49t56.5-24v-129q-39-11-61.5-43T366-846q0-47.5 33.25-80.75T480-960q47.5 0 80.75 33.25T594-846q0 35-23 67t-61 43v129q31 7 57 24t44 49l121-42v-4q0-47.5 33.25-80.75T846-694q47.5 0 80.75 33.25T960-580q0 47.5-33.25 80.75T846-466q-32 0-57-14t-39-39l-121 41q5 32-4.5 61.5T595-364l85 106q11-5 21.5-7.5t24.06-2.5Q774-268 807-234.75T840-154q0 47.5-33.25 80.75T726-40q-47.5 0-80.75-33.25T612-154q0-20 5.5-36t15.5-31l-85-106q-32.13 17-68.56 17Q443-310 411-327l-84 107q10 15 15.5 30.5T348-154q0 47.5-33.25 80.75T234-40ZM114.04-526q22.96 0 38.46-15.54 15.5-15.53 15.5-38.5 0-22.96-15.54-38.46-15.53-15.5-38.5-15.5Q91-634 75.5-618.46 60-602.93 60-579.96 60-557 75.54-541.5q15.53 15.5 38.5 15.5Zm120 426q22.96 0 38.46-15.54 15.5-15.53 15.5-38.5 0-22.96-15.54-38.46-15.53-15.5-38.5-15.5-22.96 0-38.46 15.54-15.5 15.53-15.5 38.5 0 22.96 15.54 38.46 15.53 15.5 38.5 15.5Zm246-692q22.96 0 38.46-15.54 15.5-15.53 15.5-38.5 0-22.96-15.54-38.46-15.53-15.5-38.5-15.5-22.96 0-38.46 15.54-15.5 15.53-15.5 38.5 0 22.96 15.54 38.46 15.53 15.5 38.5 15.5Zm.46 422q37.5 0 63.5-26.5t26-64q0-37.5-26.1-63.5T480-550q-37 0-63.5 26.1T390-460q0 37 26.5 63.5t64 26.5Zm245.54 270q22.96 0 38.46-15.54 15.5-15.53 15.5-38.5 0-22.96-15.54-38.46-15.53-15.5-38.5-15.5-22.96 0-38.46 15.54-15.5 15.53-15.5 38.5 0 22.96 15.54 38.46 15.53 15.5 38.5 15.5Zm120-426q22.96 0 38.46-15.54 15.5-15.53 15.5-38.5 0-22.96-15.54-38.46-15.53-15.5-38.5-15.5-22.96 0-38.46 15.54-15.5 15.53-15.5 38.5 0 22.96 15.54 38.46 15.53 15.5 38.5 15.5ZM480-846ZM114-580Zm366 120Zm366-120ZM234-154Zm492 0Z" />
        </svg> &nbsp; &nbsp;
        <span style="color: #1d2856">Networks</span><i class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>
    <ul id="Newconnection-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.circleList') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Circle</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.categoryList') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Category</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.myConnections') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Connection</span>
            </a>
        </li>
    </ul>
</li>

{{-- <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#event-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-calendar-check" style="color: #e76a35"></i><span>Event</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>
    <ul id="event-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.connectionRequests') }}">
                <i class="bi bi-calendar-check" style="color: #e76a35"></i>
                <span>Slot Booking</span>
            </a>
        </li>
    </ul>
</li> --}}


<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('subscription.memberSubscription') }}">
        <i class="bi bi-star" style="color: #e76a35"></i>
        <span class="text-blue">My Subscriptions</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('myAllPayments.index') }}">
        <i class="bi bi-currency-rupee" style="color: #e76a35"></i>
        <span class="text-blue">My Payment History</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('help.userView') }}">
        <i class="bi bi-question-circle" style="color: #e76a35"></i>
        <span class="text-blue">Help</span>
    </a>
</li>


{{-- <li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('activity.allActivityByCircle') }}">
        <i class="bi bi-currency-rupee" style="color: #e76a35"></i>
        <span style="color: #1d2856">All Acitivity</span>
    </a>
</li> --}}


{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('errorList') }}">
        <i class="bi bi-exclamation-triangle" style="color: red"></i>
        <span class="text-blue">Error Log List</span>
    </a>
</li> --}}


@if (Auth::user()->hasRole('Attendance Handler'))
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('attendance.meetingSchedules') }}">
            <i class="bi bi-person-video2" style="color: #e76a35"></i>
            <span class="text-blue">C M Attendances</span>
        </a>
    </li>
@endif

@if (Auth::user()->hasRole('Circle Director'))
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('circleAdminPaymentHistory.index') }}">
            <i class="bi bi-cash-stack" style="color: #e76a35"></i>
            <span class="text-blue">All Member Payment History</span>
        </a>
    </li>
@endif


@if (Auth::user()->hasRole('ST'))
    <li class="nav-item">
        <a class="nav-link collapsed " href="{{ route('monthlyPaymentsByRole.index') }}">
            <i class="bi bi-currency-rupee" style="color: #e76a35"></i>
            <span style="color: #1d2856">Manage Monthly Payment</span>
        </a>
    </li>
@endif


@if (Auth::user()->hasRole('Circle Director'))
    <li class="nav-item">
        <a class="nav-link collapsed " href="{{ route('visitors.RoleWiseIndex') }}">
            <i class="bi bi-people-fill" style="color: #e76a35"></i>
            <span style="color: #1d2856">Visitor List</span>
        </a>
    </li>
@endif


@if (Auth::user()->hasRole('VC'))
    || (Auth::user()->hasRole('Admin'))
    <li class="nav-item">
        <a class="nav-link collapsed " href="{{ route('activity.allActivityByCircle') }}">
            <i class="bi bi-currency-rupee" style="color: #e76a35"></i>
            <span style="color: #1d2856">All Acitivity</span>
        </a>
    </li>
@endif

</li><!-- End Tables Nav -->
