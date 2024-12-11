<li class="nav-item">
    {{-- <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide" style="color: #e76a35"></i><span>Admin</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a> --}}
    <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{ route('users.index') }}">
                <i class="bi bi-person" style="color: #e76a35"></i>
                <span>User</span>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{ route('franchise.index') }}">
                <i class="bi bi-person-vcard" style="color: #e76a35"></i>
                <span>Franchise</span>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{route('members.index')}}">
                <i class="bi bi-person"></i>
                <span>Member Profile</span>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{ route('roles.index') }}">
                <i class="bi bi-shield" style="color: #e76a35"></i>
                <span>Roles</span>
            </a>
        </li> --}}

    </ul>
</li><!-- End Components Nav -->


{{-- Master Menu --}}



{{-- Master Menu End --}}

<!-- End Components Nav -->

{{-- <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#region-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-globe" style="color: #e76a35"></i><span>Region</span><i class="bi bi-chevron-down ms-auto"
            style="color: #e76a35"></i>
    </a>
    <ul id="region-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('country.index') }}">
                <i class="bi bi-globe" style="color: #e76a35"></i>
                <span>Country</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('state.index') }}">
                <i class="bi bi-flag" style="color: #e76a35"></i>
                <span>State</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('city.index') }}">
                <i class="bi bi-buildings" style="color: #e76a35"></i>
                <span>City</span>
            </a>
        </li>
    </ul>
</li><!-- End Forms Nav --> --}}

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('franchise.index') }}">
        <i class="bi bi-person-vcard" style="color: #e76a35"></i>
        <span style="color: #1d2856">Franchise</span>
    </a>
</li>



{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('testimonials.indexAdmin') }}">
        <i class="bi bi-person" style="color: #e76a35"></i>
        <span style="color: #1d2856">Testimonial</span>
    </a>
</li> --}}

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#allActivity-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person-gear" style="color: #e76a35"></i><span>All Activity</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>
    <ul id="allActivity-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('testimonials.indexAdmin') }}">
                <i class="bi bi-person" style="color: #e76a35"></i>
                <span style="color: #1d2856">Testimonial</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('activity.ibm') }}">
                <i class="bi bi-person" style="color: #e76a35"></i>
                <span style="color: #1d2856">IBM</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('activity.refrence') }}">
                <i class="bi bi-person" style="color: #e76a35"></i>
                <span style="color: #1d2856">References</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('activity.businesses') }}">
                <i class="bi bi-person" style="color: #e76a35"></i>
                <span style="color: #1d2856">Business Slip</span>
            </a>
        </li>

    </ul>
</li>


<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#event-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person-gear" style="color: #e76a35"></i><span>Event</span><i class="bi bi-chevron-down ms-auto"
            style="color: #e76a35"></i>
    </a>
    <ul id="event-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('event.index') }}">
                <i class="bi bi-person-gear" style="color: #e76a35"></i>
                <span>Event Master</span>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link " href="{{ route('conquer.events.index') }}">
                <i class="bi bi-person-gear" style="color: #e76a35"></i>
                <span>Conquer Event Master</span>
            </a>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link " href="{{ route('eventRegisterList') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Event Register List</span>
            </a>
        </li> --}}


    </ul>
</li><!-- End Tables Nav -->



<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#training-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person-gear" style="color: #e76a35"></i><span>Training</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>
    <ul id="training-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('trainer.index') }}">
                <i class="bi bi-person-gear" style="color: #e76a35"></i>
                <span>Trainer Master</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('training.index') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Training</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('trainer.list') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Trainer List</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{ route('trainerMaster.trainingRegisterView') }}">
                <i class="bi bi-gear-wide-connected" style="color: #e76a35"></i>
                <span>Training Register List</span>
            </a>
        </li>

    </ul>
</li><!-- End Tables Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#circle-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-plus-circle-dotted" style="color: #e76a35"></i><span>Circle</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>
    <ul id="circle-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{ route('bCategory.index') }}">
                <i class="bi bi-plus-circle" style="color: #e76a35"></i>
                <span>Business Category</span>
            </a>
        </li> --}}



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

        {{-- <li class="nav-item">
            <a class="nav-link " href="{{route('circlemeeting.index')}}">
                <i class="bi bi-people"></i>
                <span>Circle Meeting</span>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{route('circlecall.index')}}">
                <i class="bi bi-mic"></i>
                <span>Circle Meeting 1:1</span>
            </a>
        </li> --}}

        {{-- <li class="nav-item">
            <a class="nav-link " href="{{route('refGiver.index')}}">
                <i class="bi bi-person"></i>
                <span>Reference Giver</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{route('busGiver.index')}}">
                <i class="bi bi-person"></i>
                <span>Circle Member Business</span>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{route('meetingmember.index')}}">
                <i class="bi bi-person"></i>
                <span>Meeting Member</span>
            </a>
        </li> --}}
    </ul>
</li>


<li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('circle.index') }}">
        <i class="bi bi-plus-circle-dotted" style="color: #e76a35"></i>
        <span>Circle List</span>
    </a>
</li>

{{-- <li class="nav-item">
    <a class="nav-link collapsed " href="{{ route('circle.index') }}">
        <i class="bi bi-file-earmark-text" style="color: #e76a35"></i>
        <span>Report</span>
    </a>
</li> --}}


<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gear" style="color: #e76a35"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"
            style="color: #e76a35"></i>
    </a>

    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('users.index') }}">
                <i class="bi bi-person" style="color: #e76a35"></i>
                <span>Admin User</span>
            </a>
        </li>
    </ul>

    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('roles.index') }}">
                <i class="bi bi-shield" style="color: #e76a35"></i>
                <span>Roles</span>
            </a>
        </li>
    </ul>

    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('permission.index') }}">
                <i class="bi bi-person-vcard" style="color: #e76a35"></i>
                <span style="color: #1d2856">Permissions</span>
            </a>
        </li>
    </ul>

    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('template.index') }}">
                <i class="bi bi-image" style="color: #e76a35"></i>
                <span>Template</span>
            </a>
        </li>
    </ul>

    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('coupon.index') }}">
                <i class="bi bi-ticket-perforated" style="color: #e76a35"></i>
                <span>Coupon</span>
            </a>
        </li>
    </ul>

    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('circletype.index') }}">
                <i class="bi bi-plus-circle" style="color: #e76a35"></i>
                <span>Circle Type</span>
            </a>
        </li>
    </ul>

    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('eventType.index') }}">
                <i class="bi bi-calendar-event" style="color: #e76a35"></i>
                <span>Event Type</span>
            </a>
        </li>
    </ul>

    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('slot.index') }}">
                <i class="bi bi-clock" style="color: #e76a35"></i>
                <span>Slot</span>
            </a>
        </li>
    </ul>


    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('membershipType.index') }}">
                <i class="bi bi-globe" style="color: #e76a35"></i>
                <span>Membership Type</span>
            </a>
        </li>
    </ul>
    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('tCategory.index') }}">
                <i class="bi bi-globe" style="color: #e76a35"></i>
                <span>Training Category</span>
            </a>
        </li>
    </ul>
    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('bCategory.index') }}">
                <i class="bi bi-plus-circle" style="color: #e76a35"></i>
                <span>Business Category</span>
            </a>
        </li>
    </ul>
    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('country.index') }}">
                <i class="bi bi-globe" style="color: #e76a35"></i>
                <span>Country</span>
            </a>
        </li>
    </ul>
    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('state.index') }}">
                <i class="bi bi-flag" style="color: #e76a35"></i>
                <span>State</span>
            </a>
        </li>
    </ul>
    <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('city.index') }}">
                <i class="bi bi-buildings" style="color: #e76a35"></i>
                <span>City</span>
            </a>
        </li>
    </ul>


</li>


<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#payment-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-currency-rupee" style="color: #e76a35"></i><span>Payment Management</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>

    <ul id="payment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('allPayments.index') }}">
                <i class="bi bi-currency-rupee" style="color: #e76a35"></i>
                <span style="color: #1d2856">Payment History</span>
            </a>
        </li>
    </ul>

    <ul id="payment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed " href="{{ route('monthlyPayments.index') }}">
                <i class="bi bi-currency-rupee" style="color: #e76a35"></i>
                <span style="color: #1d2856">Manage Monthly Payment</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-currency-rupee" style="color: #e76a35"></i><span>Report</span><i
            class="bi bi-chevron-down ms-auto" style="color: #e76a35"></i>
    </a>

    <ul id="report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.report.ibm') }}">
                <i class="bi bi-file-earmark-text" style="color: #e76a35"></i>
                <span class="text-blue">IBM Report</span>
            </a>
        </li>
    </ul>

    <ul id="report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.report.reference') }}">
                <i class="bi bi-file-earmark-text" style="color: #e76a35"></i>
                <span class="text-blue">Reference Report</span>
            </a>
        </li>
    </ul>

    <ul id="report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.report.business') }}">
                <i class="bi bi-file-earmark-text" style="color: #e76a35"></i>
                <span class="text-blue">Business Report</span>
            </a>
        </li>
    </ul>

</li>



<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('subscription.memberSubscription.admin') }}">
        <i class="bi bi-substack" style="color: #e76a35"></i>
        <span class="text-blue">Member Subscriptions</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('visitors.index') }}">
        <i class="bi bi-people" style="color: #e76a35"></i>
        <span class="text-blue">Visitors List</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('visitor.index') }}">
        <i class="bi bi-people" style="color: #e76a35"></i>
        <span class="text-blue">Visitors</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('userList') }}">
        <i class="bi bi-people" style="color: #e76a35"></i>
        <span class="text-blue">User List</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('errorList') }}">
        <i class="bi bi-exclamation-triangle" style="color: red"></i>
        <span class="text-blue">Error Log List</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('updateApp.edit') }}">
        <i class="bi bi-arrow-up-circle" style="color: #e76a35"></i>
        <span style="color: #1d2856">App Version Update</span>
    </a>
</li>



<!-- End Forms Nav -->