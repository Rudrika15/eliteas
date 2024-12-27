@extends('layouts.master')

@section('title', 'UBN - Change Password')
@section('content')

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card border-3 shadow-lg rounded-lg">
                    <div class="card-header text-center"
                        style="background-color: #1d3268; color: #ffffff; font-weight: bold;">
                        {{ __('Change Password') }}
                    </div>

                    <div class="card-body" style="background-color: #f7f9fc;">
                        <form method="POST" action="{{ route('changePassword') }}">
                            @csrf

                            <div class="form-group row mb-4 mt-3">
                                <label for="current_password" class="col-md-4 col-form-label text-md-right"
                                    style="font-weight: bold;">
                                    {{ __('Current Password') }}
                                </label>

                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="current_password" type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            name="current_password" required autocomplete="current-password"
                                            placeholder="Enter current password"
                                            style="border-radius: 6px 0px 0px 6px; border: 1px solid #ced4da; padding: 12px;">

                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="showHidePassword('current_password')"
                                            style="border-color: #ced4da; background-color: #fff;"
                                            onmouseover="this.style.backgroundColor='#1d2856';"
                                            onmouseout="this.style.backgroundColor='#fff';">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </button>

                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="password" class="col-md-4 col-form-label text-md-right"
                                    style="font-weight: bold;">
                                    {{ __('New Password') }}
                                </label>

                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password" placeholder="Enter new password"
                                            style="border-radius: 6px 0px 0px 6px; border: 1px solid #ced4da; padding: 12px"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$"
                                            oninput="this.setCustomValidity('')"
                                            oninvalid="this.setCustomValidity('Must contain at least one lowercase letter, one uppercase letter, one number, one special character, and at least 8 characters.')">

                                        <button class="btn btn-outline-secondary" type="button" id="passwordEye"
                                            onclick="togglePassword()"style="border-color: #ced4da; background-color: #fff;"
                                            onmouseover="this.style.backgroundColor='#1d2856';"
                                            onmouseout="this.style.backgroundColor='#fff';">
                                            <i class="bi bi-eye" id="passwordEyeIcon"></i>
                                        </button>

                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right"
                                    style="font-weight: bold;">
                                    {{ __('Confirm Password') }}
                                </label>

                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password"
                                            placeholder="Confirm new password"
                                            style="border-radius: 6px 0px 0px 6px; border: 1px solid #ced4da; padding: 12px"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$"
                                            oninput="this.setCustomValidity('')"
                                            oninvalid="this.setCustomValidity('Must contain at least one lowercase letter, one uppercase letter, one number, one special character, and at least 8 characters.')">

                                        <button class="btn btn-outline-secondary" type="button" id="passwordEyeConfirm"
                                            onclick="togglePasswordConfirm()"
                                            style="border-color: #ced4da; background-color: #fff;"
                                            onmouseover="this.style.backgroundColor='#1d2856';"
                                            onmouseout="this.style.backgroundColor='#fff';">
                                            <i class="bi bi-eye" id="passwordEyeConfirmIcon"></i>
                                        </button>

                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-bg-orange px-4 py-2 rounded-pill">
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

<script>
    function showHidePassword(id) {
        var x = document.getElementById(id);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function togglePassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            document.getElementById("passwordEyeIcon").classList.add("fa-eye-slash");
            document.getElementById("passwordEyeIcon").classList.remove("fa-eye");
        } else {
            x.type = "password";
            document.getElementById("passwordEyeIcon").classList.add("fa-eye");
            document.getElementById("passwordEyeIcon").classList.remove("fa-eye-slash");
        }
    }

    function togglePasswordConfirm() {
        var x = document.getElementById("password-confirm");
        if (x.type === "password") {
            x.type = "text";
            document.getElementById("passwordEyeConfirmIcon").classList.add("fa-eye-slash");
            document.getElementById("passwordEyeConfirmIcon").classList.remove("fa-eye");
        } else {
            x.type = "password";
            document.getElementById("passwordEyeConfirmIcon").classList.add("fa-eye");
            document.getElementById("passwordEyeConfirmIcon").classList.remove("fa-eye-slash");
        }
    }
</script>
