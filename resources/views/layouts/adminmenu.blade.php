<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{route('users.index')}}">
                <i class="bi bi-person"></i>
                <span>User</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{route('franchise.index')}}">
                <i class="bi bi-person-vcard"></i>
                <span>Franchise</span>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link " href="{{route('members.index')}}">
                <i class="bi bi-person"></i>
                <span>Member Profile</span>
            </a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link " href="{{route('roles.index')}}">
                <i class="bi bi-shield"></i>
                <span>Roles</span>
            </a>
        </li>

    </ul>
</li><!-- End Components Nav -->


<!-- End Components Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#region-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-globe"></i><span>Region</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="region-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{route('country.index')}}">
                <i class="bi bi-globe"></i>
                <span>Country</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{route('state.index')}}">
                <i class="bi bi-flag"></i>
                <span>State</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{route('city.index')}}">
                <i class="bi bi-buildings"></i>
                <span>City</span>
            </a>
        </li>
    </ul>
</li><!-- End Forms Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#training-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person-gear"></i><span>Training</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="training-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{route('trainer.index')}}">
                <i class="bi bi-person-gear"></i>
                <span>Trainer Master</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{route('training.index')}}">
                <i class="bi bi-gear-wide-connected"></i>
                <span>Training</span>
            </a>
        </li>

    </ul>
</li><!-- End Tables Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#circle-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-plus-circle-dotted"></i><span>Circle</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="circle-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{route('bCategory.index')}}">
                <i class="bi bi-plus-circle"></i>
                <span>Business Category</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{route('circletype.index')}}">
                <i class="bi bi-plus-circle"></i>
                <span>Circle Type</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{route('circle.index')}}">
                <i class="bi bi-plus-circle-dotted"></i>
                <span>Circle</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " href="{{route('circlemember.index')}}">
                <i class="bi bi-plus-circle-dotted"></i>
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