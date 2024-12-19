@extends('layouts.master')

@section('header', 'Visitor')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Visitor</h5>
            <a href="{{ route('visitors.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="visitorsForm" enctype="multipart/form-data" method="post" action="{{ route('visitors.update', $visitors->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $visitors->id }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="{{ $visitors->firstName }}">
                        <label for="firstName">First Name</label>
                        @error('firstName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="{{ $visitors->lastName }}">
                        <label for="lastName">Last Name</label>
                        @error('lastName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('mobileNo') is-invalid @enderror" id="mobileNo" name="mobileNo" value="{{ $visitors->mobileNo }}" placeholder="Mobile No" pattern="[0-9]{10}" oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" oninvalid="this.setCustomValidity('Please enter a valid 10-digit mobile number');" oninput="this.setCustomValidity('')">
                        <label for="mobileNo">Mobile No</label>
                        @error('mobileNo')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $visitors->email }}">
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="businessName" name="businessName" placeholder="Business Name" value="{{ $visitors->businessName }}">
                        <label for="businessName">Business Name</label>
                        @error('businessName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{ $visitors->city }}">
                        <label for="city">City</label>
                        @error('city')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('businessCategory') is-invalid @enderror" id="businessCategory" name="businessCategory">
                            <option value="" disabled>Select Business Category</option>
                            @foreach ($businessCategories as $businessCategoryData)
                                <option value="{{ $businessCategoryData->id }}" {{ old('businessCategory', $visitors->businessCategory) == $businessCategoryData->id ? 'selected' : '' }}>
                                    {{ $businessCategoryData->categoryName }}
                                </option>
                            @endforeach
                        </select>
                        <label for="businessCategory">Business Category</label>
                        @error('businessCategory')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="invitedBy" name="invitedBy" placeholder="Invited By" value="{{ $visitors->invitedBy }}">
                        <label for="invitedBy">Referred By</label>
                        @error('invitedBy')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3 mt-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <textarea class="form-control" id="otherDetails" name="otherDetails" placeholder="otherDetails">{{ $visitors->otherDetails }}</textarea>
                            <label for="otherDetails">Other Details</label>
                            @error('otherDetails')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>

@endsection
