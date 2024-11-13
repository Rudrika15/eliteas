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
            <i class="bi bi-person-gear" style="color: #e76a35"></i><span>My Circle Activity</span><i
                class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
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
            <i class="bi bi-plus-circle-dotted" style="color: #e76a35"></i><span>Circle</span><i
                class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
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
        <i class="bi bi-plus-circle-dotted" style="color: #e76a35"></i><span>Activity</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
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
            <a class="nav-link collapsed " href="{{ route('circleWiseLeaderboard.index') }}">
                <i class="bi bi-chat-quote text-orange"></i>
                <span class="text-blue">Circle Leaderboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('circleWiseLeaderboard.index') }}">
                <i class="bi bi-chat-quote text-orange"></i>
                <span class="text-blue">Specific Ask</span>
            </a>
        </li>
    </ul>
</li>



<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#connection-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person-heart" style="color: #e76a35"></i><span>Connection</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>
    <ul id="connection-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.connectionRequests') }}">
                <i class="bi bi-person-heart" style="color: #e76a35"></i>
                <span>Connection Request</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('connection.myConnections') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>My Connection</span>
            </a>
        </li>

    </ul>

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

@if (Auth::user()->hasRole('Circle Admin'))
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('circleAdminPaymentHistory.index') }}">
            <i class="bi bi-cash-stack" style="color: #e76a35"></i>
            <span class="text-blue">All Member Payment History</span>
        </a>
    </li>
@endif


@if (Auth::user()->hasRole('SP'))
    <li class="nav-item">
        <a class="nav-link collapsed " href="{{ route('monthlyPayments.index') }}">
            <i class="bi bi-currency-rupee" style="color: #e76a35"></i>
            <span style="color: #1d2856">Manage Monthly Payment</span>
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
