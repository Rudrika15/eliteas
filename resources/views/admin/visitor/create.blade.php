@extends('layouts.master')

@section('header', 'Visitor')
@section('content')

<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Create Visitor</h5>
        <a href="{{ route('visitors.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="visitorForm" enctype="multipart/form-data" method="post"
        action="{{ route('visitors.store') }}" novalidate>
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
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
                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
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
                    <input type="text" class="form-control @error('mobileNo') is-invalid @enderror" id="mobileNo"
                        name="mobileNo" placeholder="Mobile No" pattern="[0-9]{10}"
                        oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                        oninvalid="this.setCustomValidity('Please enter a valid 10-digit mobile number');"
                        oninput="this.setCustomValidity('')">
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
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    <label for="email">Email</label>
                    @error('email')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="businessName" name="businessName"
                        placeholder="Business Name">
                    <label for="businessName">Business Name</label>
                    @error('businessName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City">
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
                    <select class="form-select" id="businessCategory" name="businessCategory">
                        <option value="">Select Business Category</option>
                        @foreach ($businessCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
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
                    <input type="text" class="form-control" id="invitedBy" name="invitedBy" placeholder="Invited By">
                    <label for="invitedBy">Reffered By</label>
                    @error('invitedBy')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-floating">
                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"></textarea>
                    <label for="remarks">Remarks</label>
                    @error('remarks')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection