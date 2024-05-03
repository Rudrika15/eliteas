@extends('layouts.master')

@section('title', 'UBN - Update Profile')
@section('content')

    {{-- Message --}}
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                {{-- <i class="fa fa-times"></i> --}}
            </button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                {{-- <i class="fa fa-times"></i> --}}
            </button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif


    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Your Profile</h5>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="memberForm" enctype="multipart/form-data" method="post"
            action="{{ route('member.update', $member->userId) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $member->id }}">
            <div class="accordion" id="accordionExample">
                <!-- Section 1 -->
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Personal Information
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ $member->title ?? '-' }}"
                                            placeholder="title">
                                        <label for="title">Title</label>
                                        @error('title')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('firstName') is-invalid @enderror"
                                            id="firstName" name="firstName" value="{{ $member->firstName ?? '-' }}"
                                            placeholder="First Name">
                                        <label for="firstName">First Name</label>
                                        @error('firstName')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('lastName') is-invalid @enderror"
                                            id="lastName" name="lastName" value="{{ $member->lastName ?? '-' }}"
                                            placeholder="Last Name">
                                        <label for="lastName">Last Name</label>
                                        @error('lastName')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('suffix') is-invalid @enderror"
                                            id="suffix" name="suffix" value="{{ $member->suffix ?? '-' }}"
                                            placeholder="Suffix">
                                        <label for="suffix">Suffix</label>
                                        @error('suffix')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('displayName') is-invalid @enderror" id="displayName"
                                            name="displayName" value="{{ $member->displayName ?? '-' }}"
                                            placeholder="Display Name">
                                        <label for="displayName">Display Name</label>
                                        @error('displayName')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="gender"
                                                value="male" checked>
                                            <label class="form-check-label" for="gender">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="gender"
                                                value="female" checked>
                                            <label class="form-check-label" for="gender">
                                                Female
                                            </label>
                                        </div>
                                        @error('gender')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('companyName') is-invalid @enderror"
                                            id="companyName" name="companyName"
                                            value="{{ $member->companyName ?? '-' }}" placeholder="Company Name">
                                        <label for="companyName">Company Name</label>
                                        @error('companyName')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section 2 -->
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Product/Service Description
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('gstRegiState') is-invalid @enderror"
                                            id="gstRegiState" name="gstRegiState"
                                            value="{{ $member->gstRegistate ?? '-' }}" placeholder="gstRegiState">
                                        <label for="gstRegiState">GST Registered State</label>
                                        @error('gstRegiState')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('gStinPan') is-invalid @enderror"
                                            id="gStinPan" name="gStinPan" value="{{ $member->gStinPan ?? '-' }}"
                                            placeholder="GSTIN / PAN">
                                        <label for="gStinPan">GSTIN / PAN </label>
                                        @error('gStinPan')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('industry') is-invalid @enderror"
                                            id="industry" name="industry" value="{{ $member->industry ?? '-' }}"
                                            placeholder="Industry">
                                        <label for="industry">Industry</label>
                                        @error('industry')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('classification') is-invalid @enderror"
                                            id="classification" name="classification"
                                            value="{{ $member->classification ?? '-' }}" placeholder="Classification">
                                        <label for="classification">Classification</label>
                                        @error('classification')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section 3 -->
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            Speciality
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('chapter') is-invalid @enderror"
                                            id="chapter" name="chapter" value="{{ $member->chapter ?? '-' }}"
                                            placeholder="Chapter">
                                        <label for="chapter">Chapter</label>
                                        @error('chapter')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="date"
                                            class="form-control @error('renewalDueDate') is-invalid @enderror"
                                            id="renewalDueDate" name="renewalDueDate"
                                            value="{{ $member->renewalDueDate ?? '-' }}" placeholder="GSTIN / PAN">
                                        <label for="renewalDueDate">Renewal Due Date </label>
                                        @error('renewalDueDate')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('membershipStatus') is-invalid @enderror"
                                            id="membershipStatus" name="membershipStatus"
                                            value="{{ $member->membershipStatus ?? '-' }}"
                                            placeholder="membershipStatus">
                                        <label for="membershipStatus">Membership Status</label>
                                        @error('membershipStatus')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="longText"
                                            class="form-control @error('myBusiness') is-invalid @enderror"
                                            id="myBusiness" name="myBusiness" value="{{ $member->myBusiness ?? '-' }}"
                                            placeholder="myBusiness">
                                        <label for="myBusiness">My Business</label>
                                        @error('myBusiness')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="longText"
                                            class="form-control @error('keyWords') is-invalid @enderror" id="keyWords"
                                            name="keyWords" value="{{ $member->keyWords ?? '-' }}"
                                            placeholder="keyWords">
                                        <label for="keyWords">Keywords (Comma Seperated)</label>
                                        @error('keyWords')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section 4 -->
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                            Profile
                        </button>
                    </h2>

                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <h3>Which address should appear on your public profile?</h3>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="addressShow"
                                                id="mainAddress" value="mainAddress" checked>
                                            <label class="form-check-label" for="mainAddress">
                                                Main Address
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="addressShow"
                                                id="billing" value="billing" checked>
                                            <label class="form-check-label" for="billing">
                                                Billing
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="addressShow"
                                                id="none" value="none" checked>
                                            <label class="form-check-label" for="none">
                                                None
                                            </label>
                                        </div>
                                        @error('addressShow')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('username') is-invalid @enderror" id="username"
                                            name="username" value="{{ $member->username ?? '-' }}"
                                            placeholder="username">
                                        <label for="username">Username</label>
                                        @error('username')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('language') is-invalid @enderror" id="language"
                                            name="language" value="{{ $member->language ?? '-' }}"
                                            placeholder="Language">
                                        <label for="language">Language </label>
                                        @error('language')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('timeZone') is-invalid @enderror" id="timeZone"
                                            name="timeZone" value="{{ $member->timeZone ?? '-' }}"
                                            placeholder="timeZone">
                                        <label for="timeZone">Timezone</label>
                                        @error('timeZone')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-label-group mt-3">
                                        <label for="profilePhoto" class="fw-bold">Profile Photo <sup
                                                class="text-danger">*</sup></label>
                                        <input type="file" class="form-control" id="profilePhoto" name="profilePhoto"
                                            accept="image/*" onchange="previewPhoto(event)">
                                        <img id="photoPreview" src="default.jpg" class="mt-2" width="100px"
                                            height="100px">
                                        @error('profilePhoto')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-label-group mt-3">
                                        <label for="companyLogo" class="fw-bold">Company Logo <sup
                                                class="text-danger">*</sup></label>
                                        <input type="file" class="form-control" id="companyLogo" name="companyLogo"
                                            accept="image/*" onchange="previewPhoto(event)">
                                        <img id="logoPreview" src="default.jpg" class="mt-2" width="100px"
                                            height="100px">
                                        @error('companyLogo')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="receiveUpdates"
                                            name="receiveUpdates" value="Yes">
                                        <label class="form-check-label" for="receiveUpdates">
                                            I would like to receive updates from BNI about its networking, events,
                                            promotions and special offers.
                                        </label>
                                        @error('receiveUpdates')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="shareRevenue"
                                            name="shareRevenue" value="Yes">
                                        <label class="form-check-label" for="shareRevenue">
                                            I would like to share my Revenue Received data with my BNI Director.
                                        </label>
                                        @error('shareRevenue')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('webSite') is-invalid @enderror"
                                            id="webSite" name="webSite" value="{{ $member->webSite ?? '-' }}"
                                            placeholder="webSite">
                                        <label for="webSite">Website</label>
                                        @error('webSite')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="showWebsite"
                                            name="showWebsite" value="Yes">
                                        <label class="form-check-label" for="showWebsite">
                                            If Checked the public will be able to search for your services
                                        </label>
                                        @error('showWebsite')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('socialLinks') is-invalid @enderror"
                                            id="socialLinks" name="socialLinks"
                                            value="{{ $member->socialLinks ?? '-' }}" placeholder="socialLinks">
                                        <label for="socialLinks">Social Network Links</label>
                                        @error('socialLinks')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="showSocialLinks"
                                            name="showSocialLinks" value="Yes">
                                        <label class="form-check-label" for="showSocialLinks">
                                            If Checked the public will be able to search for your services
                                        </label>
                                        @error('showSocialLinks')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section 5 -->
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                            Contact Details
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">

                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('billingAddress') is-invalid @enderror"
                                            id="billingAddress" name="billingAddress"
                                            value="{{ $contactDetails->billingAddress ?? '-' }}"
                                            placeholder="billingAddress">
                                        <label for="billingAddress">Billing Address</label>
                                        @error('billingAddress')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="showMeOnPublicWeb"
                                            name="showMeOnPublicWeb" value="Yes">
                                        <label class="form-check-label" for="showMeOnPublicWeb">
                                            If Checked the public will be able to search for your services
                                        </label>
                                        @error('showMeOnPublicWeb')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ $contactDetails->phone ?? '-' }}"
                                            placeholder="phone">
                                        <label for="phone">Phone </label>
                                        @error('phone')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="showPhone" name="showPhone"
                                            value="Yes">
                                        <label class="form-check-label" for="showPhone">
                                            Show this on my public profile
                                        </label>
                                        @error('showPhone')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('directNo') is-invalid @enderror" id="directNo"
                                            name="directNo" value="{{ $contactDetails->directNo ?? '-' }}"
                                            placeholder="directNo">
                                        <label for="directNo">Direct Number</label>
                                        @error('directNo')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="showDirectNo"
                                            name="showDirectNo" value="Yes">
                                        <label class="form-check-label" for="showDirectNo">
                                            Show this on my public profile
                                        </label>
                                        @error('showDirectNo ')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('home') is-invalid @enderror"
                                            id="home" name="home" value="{{ $contactDetails->home ?? '-' }}"
                                            placeholder="home">
                                        <label for="home">Home</label>
                                        @error('home')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('mobileNo') is-invalid @enderror"
                                                id="mobileNo" name="mobileNo"
                                                value="{{ $contactDetails->mobileNo ?? '-' }}" placeholder="Mobile No">
                                            <label for="mobileNo">Mobile No</label>
                                            @error('mobileNo')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 d-flex align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="showMobileNo"
                                                name="showMobileNo" value="Yes">
                                            <label class="form-check-label" for="showMobileNo">
                                                Show this on my public profile
                                            </label>
                                            @error('showMobileNo')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('pager') is-invalid @enderror"
                                            id="pager" name="pager" value="{{ $contactDetails->pager ?? '-' }}"
                                            placeholder="pager">
                                        <label for="pager">Pager</label>
                                        @error('pager')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('voiceMail') is-invalid @enderror" id="voiceMail"
                                            name="voiceMail" value="{{ $contactDetails->voiceMail ?? '-' }}"
                                            placeholder="voiceMail">
                                        <label for="voiceMail">Voice Mail</label>
                                        @error('voiceMail')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('tollFree') is-invalid @enderror" id="tollFree"
                                            name="tollFree" value="{{ $contactDetails->tollFree ?? '-' }}"
                                            placeholder="tollFree">
                                        <label for="tollFree">Toll Free</label>
                                        @error('tollFree')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="showTollFree"
                                            name="showTollFree" value="Yes">
                                        <label class="form-check-label" for="showTollFree">
                                            Show this on my public profile
                                        </label>
                                        @error('showTollFree')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('fax') is-invalid @enderror"
                                            id="fax" name="fax" value="{{ $contactDetails->fax ?? '-' }}"
                                            placeholder="fax">
                                        <label for="fax">Fax</label>
                                        @error('fax')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="showFax" name="showFax"
                                            value="Yes">
                                        <label class="form-check-label" for="showFax">
                                            Show this on my public profile
                                        </label>
                                        @error('showFax')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ $contactDetails->email ?? '-' }}"
                                            placeholder="email">
                                        <label for="email">Email</label>
                                        @error('email')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="showEmail" name="showEmail"
                                            value="Yes">
                                        <label class="form-check-label" for="showEmail">
                                            Show this on my public profile
                                        </label>
                                        @error('billingAddress')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section 6 -->
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                            Billing Address
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('bAddressLine1') is-invalid @enderror"
                                            id="bAddressLine1" name="bAddressLine1"
                                            value="{{ $billing->bAddressLine1 ?? '-' }}"
                                            placeholder="Billing Address Line 1">
                                        <label for="bAddressLine1">Address Line 1</label>
                                        @error('bAddressLine1')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('bAddressLine2') is-invalid @enderror"
                                            id="bAddressLine2" name="bAddressLine2"
                                            value="{{ $billing->bAddressLine2 ?? '-' }}" placeholder="bAddressLine2">
                                        <label for="bAddressLine2">Address Line 2 </label>
                                        @error('bAddressLine2')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('bCity') is-invalid @enderror"
                                            id="bCity" name="bCity" value="{{ $billing->bCity ?? '-' }}"
                                            placeholder="bCity">
                                        <label for="bCity">City</label>
                                        @error('bCity')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('bState') is-invalid @enderror"
                                            id="bState" name="bState" value="{{ $billing->bState ?? '-' }}"
                                            placeholder="bState">
                                        <label for="bState">State</label>
                                        @error('bState')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('bCountry') is-invalid @enderror" id="bCountry"
                                            name="bCountry" value="{{ $billing->bCountry ?? '-' }}"
                                            placeholder="bCountry">
                                        <label for="bCountry">Country</label>
                                        @error('bCountry')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('bPinCode') is-invalid @enderror" id="bPinCode"
                                            name="bPinCode" value="{{ $billing->bPinCode ?? '-' }}"
                                            placeholder="bPinCode">
                                        <label for="bPinCode">Pin Code</label>
                                        @error('bPinCode')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section 7 -->
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingSeven">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                            Address
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('addressLine1') is-invalid @enderror"
                                            id="addressLine1" name="addressLine1"
                                            value="{{ $contactDetails->addressLine1 ?? '-' }}"
                                            placeholder="Billing Address Line 1">
                                        <label for="addressLine1">Address Line 1</label>
                                        @error('addressLine1')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('addressLine2') is-invalid @enderror"
                                            id="addressLine2" name="addressLine2"
                                            value="{{ $contactDetails->addressLine2 ?? '-' }}"
                                            placeholder="addressLine2">
                                        <label for="addressLine2">Address Line 2 </label>
                                        @error('addressLine2')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                                            id="city" name="city" value="{{ $contactDetails->city ?? '-' }}"
                                            placeholder="city">
                                        <label for="city">City</label>
                                        @error('city')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('state') is-invalid @enderror"
                                            id="state" name="state" value="{{ $contactDetails->state ?? '-' }}"
                                            placeholder="state">
                                        <label for="state">State</label>
                                        @error('state')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('country') is-invalid @enderror"
                                            id="country" name="country" value="{{ $contactDetails->country ?? '-' }}"
                                            placeholder="country">
                                        <label for="country">Country</label>
                                        @error('country')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('pinCode') is-invalid @enderror"
                                            id="pinCode" name="pinCode" value="{{ $contactDetails->pinCode ?? '-' }}"
                                            placeholder="pinCode">
                                        <label for="pinCode">Pin Code</label>
                                        @error('pinCode')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section 8 -->
                <div class="accordion-item mt-3">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                            Tops Profile
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('idealRef') is-invalid @enderror" id="idealRef"
                                            name="idealRef" value="{{ $tops->idealRef ?? '-' }}"
                                            placeholder="Ideal Refferance">
                                        <label for="idealRef">Ideal Referral</label>
                                        @error('idealRef')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('topProduct') is-invalid @enderror"
                                            id="topProduct" name="topProduct" value="{{ $tops->topProduct ?? '-' }}"
                                            placeholder="topProduct">
                                        <label for="topProduct">Top Product</label>
                                        @error('topProduct')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('topProblemSolved') is-invalid @enderror"
                                            id="topProblemSolved" name="topProblemSolved"
                                            value="{{ $tops->topProbleSolved ?? '-' }}" placeholder="topProblemSolved">
                                        <label for="topProblemSolved">Top Problem Solved</label>
                                        @error('topProblemSolved')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('myFavBNIStory') is-invalid @enderror"
                                            id="myFavBNIStory" name="myFavBNIStory"
                                            value="{{ $tops->myFavBNIStory ?? '-' }}" placeholder="myFavBNIStory">
                                        <label for="myFavBNIStory">My Favourite BNI Story</label>
                                        @error('myFavBNIStory')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control @error('myIdealRefPartner') is-invalid @enderror"
                                            id="myIdealRefPartner" name="myIdealRefPartner"
                                            value="{{ $tops->myIdealRefPartner ?? '-' }}"
                                            placeholder="myIdealRefPartner">
                                        <label for="myIdealRefPartner">My Ideal Refferal Partner</label>
                                        @error('myIdealRefPartner')
                                            <div class="invalid-tooltip">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Section 9 -->
                    <div class="accordion-item mt-3">
                        <h2 class="accordion-header" id="headingNine">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                GAINS Profile
                            </button>
                        </h2>
                        <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('goals') is-invalid @enderror" id="goals"
                                                name="goals" value="{{ $member->goals ?? '-' }}" placeholder="Goals">
                                            <label for="goals">Goals</label>
                                            @error('goals')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('accomplishment') is-invalid @enderror"
                                                id="accomplishment" name="accomplishment"
                                                value="{{ $member->accomplishment ?? '-' }}"
                                                placeholder="accomplishment">
                                            <label for="accomplishment">Accomplishment</label>
                                            @error('accomplishment')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('interests') is-invalid @enderror"
                                                id="interests" name="interests" value="{{ $member->interests ?? '-' }}"
                                                placeholder="interests">
                                            <label for="interests">Interests</label>
                                            @error('interests')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('networks') is-invalid @enderror"
                                                id="networks" name="networks" value="{{ $member->networks ?? '-' }}"
                                                placeholder="networks">
                                            <label for="networks">Networks</label>
                                            @error('networks')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('skills') is-invalid @enderror" id="skills"
                                                name="skills" value="{{ $member->skills ?? '-' }}"
                                                placeholder="skills">
                                            <label for="skills">Skills</label>
                                            @error('skills')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Section 10 -->
                    <div class="accordion-item mt-3">
                        <h2 class="accordion-header" id="headingTen">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTen" aria-expanded="true" aria-controls="collapseTen">
                                Weekly Presentation
                            </button>
                        </h2>
                        <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('weeklyPresent1') is-invalid @enderror"
                                                id="weeklyPresent1" name="weeklyPresent1"
                                                value="{{ $tops->weeklyPresent1 ?? '-' }}" placeholder="weeklyPresent1">
                                            <label for="weeklyPresent1">Weekly Presentation 1</label>
                                            @error('weeklyPresent1')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('weeklyPresent2') is-invalid @enderror"
                                                id="weeklyPresent2" name="weeklyPresent2"
                                                value="{{ $tops->weeklyPresent2 ?? '-' }}" placeholder="weeklyPresent2">
                                            <label for="weeklyPresent2">Weekly Presentation 2</label>
                                            @error('weeklyPresent2')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Section 11 -->
                    <div class="accordion-item mt-3">
                        <h2 class="accordion-header" id="headingEleven">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEleven" aria-expanded="true" aria-controls="collapseEleven">
                                My Bios
                            </button>
                        </h2>
                        <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('yearsInBusiness') is-invalid @enderror"
                                                id="yearsInBusiness" name="yearsInBusiness"
                                                value="{{ $tops->yearsInBusiness ?? '-' }}"
                                                placeholder="yearsInBusiness">
                                            <label for="yearsInBusiness">Years In Business</label>
                                            @error('yearsInBusiness')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('prevJobs') is-invalid @enderror"
                                                id="prevJobs" name="prevJobs" value="{{ $tops->prevJobs ?? '-' }}"
                                                placeholder="prevJobs">
                                            <label for="prevJobs">Previous Types of Jobs</label>
                                            @error('prevJobs')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('spouse') is-invalid @enderror" id="spouse"
                                                name="spouse" value="{{ $tops->spouse ?? '-' }}" placeholder="spouse">
                                            <label for="spouse">Spouse</label>
                                            @error('spouse')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('children') is-invalid @enderror"
                                                id="children" name="children" value="{{ $tops->children ?? '-' }}"
                                                placeholder="children">
                                            <label for="children">Children</label>
                                            @error('children')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('pets') is-invalid @enderror" id="pets"
                                                name="pets" value="{{ $tops->pets ?? '-' }}" placeholder="pets">
                                            <label for="pets">Pets</label>
                                            @error('pets')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('hobbiesInterests') is-invalid @enderror"
                                                id="hobbiesInterests" name="hobbiesInterests"
                                                value="{{ $tops->hobbiesInterests ?? '-' }}"
                                                placeholder="hobbiesInterests">
                                            <label for="hobbiesInterests">Hobbies & Interests</label>
                                            @error('hobbiesInterests')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('cityofRes') is-invalid @enderror"
                                                id="cityofRes" name="cityofRes" value="{{ $tops->cityofRes ?? '-' }}"
                                                placeholder="cityofRes">
                                            <label for="cityofRes">City of Residence</label>
                                            @error('cityofRes')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('yearsInCity') is-invalid @enderror"
                                                id="yearsInCity" name="yearsInCity"
                                                value="{{ $tops->yearsInCity ?? '-' }}" placeholder="yearsInCity">
                                            <label for="yearsInCity">Years In City</label>
                                            @error('yearsInCity')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('myBurningDesire') is-invalid @enderror"
                                                id="myBurningDesire" name="myBurningDesire"
                                                value="{{ $tops->myBurningDesire ?? '-' }}"
                                                placeholder="myBurningDesire">
                                            <label for="myBurningDesire">My Burning Desire</label>
                                            @error('myBurningDesire')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('dontKnowAboutMe') is-invalid @enderror"
                                                id="dontKnowAboutMe" name="dontKnowAboutMe"
                                                value="{{ $tops->dontKnowAboutMe ?? '-' }}"
                                                placeholder="dontKnowAboutMe">
                                            <label for="dontKnowAboutMe">Something No One Here Knows About
                                                Me</label>
                                            @error('dontKnowAboutMe')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text"
                                                class="form-control @error('mKeyToSuccess') is-invalid @enderror"
                                                id="mKeyToSuccess" name="mKeyToSuccess"
                                                value="{{ $tops->mKeyToSuccess ?? '-' }}" placeholder="mKeyToSuccess">
                                            <label for="mKeyToSuccess">My Key To Success</label>
                                            @error('mKeyToSuccess')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
        </form><!-- End floating Labels Form -->
    </div>


    <script>
        function previewPhoto(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var img = document.getElementById('photoPreview');
                img.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>

    <script>
        function previewPhoto(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var img = document.getElementById('logoPreview');
                img.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>

@endsection
