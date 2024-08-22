@extends('layouts.master')

@section('title', 'UBN - Change Password')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-lg">
                <div class="card-header  text-center" style="font-weight: bold; color: #1d3268;">
                    {{ __('Change Password') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('changePassword') }}">
                        @csrf

                        <div class="form-group row mb-4">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right"
                                style="font-weight: bold;">
                                {{ __('Current Password') }}
                            </label>

                            <div class="col-md-8">
                                <input id="current_password" type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" required autocomplete="current-password"
                                    placeholder="Enter current password"
                                    style="border-radius: 8px; border: 1px solid #e6e6e6; padding: 12px">

                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-right"
                                style="font-weight: bold;">
                                {{ __('New Password') }}
                            </label>

                            <div class="col-md-8">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password" placeholder="Enter new password"
                                    style="border-radius: 8px; border: 1px solid #e6e6e6; padding: 12px">

                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right"
                                style="font-weight: bold;">
                                {{ __('Confirm Password') }}
                            </label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm new password"
                                    style="border-radius: 8px; border: 1px solid #e6e6e6; padding: 12px">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-bg-blue px-4 py-2 rounded-pill">
                                    {{ __('SUBMIT') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection