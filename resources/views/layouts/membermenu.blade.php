<li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('circlecall.index') }}">
        <i class="bi bi-mic text-orange"></i>
        <span class="text-blue">Circle Meeting 1:1</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('refGiver.index') }}">
        <i class="bi bi-person  text-orange"></i>
        <span class="text-blue">Reference Giver</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('busGiver.index') }}">
        <i class="bi bi-building text-orange"></i>
        <span class="text-blue">Circle Member Business</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('testimonial.index') }}">
        <i class="bi bi-chat-quote text-orange"></i>
        <span class="text-blue">Testimonial</span>
    </a>
</li>
{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('connection.index') }}">
        <i class="bi bi-person-heart" style="color: #e76a35"></i>
        <span style="color: #1d2865;">Connection Request</span>
    </a>
</li> --}}



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
        <a class="nav-link " href="{{ route('subscription.memberSubscription') }}">
            <i class="bi bi-substack" style="color: #e76a35"></i>
            <span class="text-blue">My Subscriptions</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('myAllPayments.index') }}">
            <i class="bi bi-currency-rupee" style="color: #e76a35"></i>
            <span class="text-blue">My Payment History</span>
        </a>
    </li>

    @if(Auth::user()->hasRole('Attendance Handler'))
    <li class="nav-item">
        <a class="nav-link " href="{{ route('attendance.meetingSchedules') }}">
            <i class="bi bi-person-video2" style="color: #e76a35"></i>
            <span class="text-blue">C M Attendances</span>
        </a>
    </li>
    @endif

</li><!-- End Tables Nav -->
