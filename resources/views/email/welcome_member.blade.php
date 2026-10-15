@component('mail::message')
    Dear {{ $name }},

    Welcome to <b style="color: #0d6efd;">UBN</b>!

    We’re delighted to have you as part of the UBN community. Your account has been successfully created. Please find your login details below:

    <b>Username:</b> {{ $username }}
    <b>Mobile Number:</b> {{ $contactNo }}
    <b>Password:</b> {{ $password }}

    You may now log in using your registered mobile number.

    For security reasons, we strongly recommend that you keep your login credentials confidential and do not share them with anyone.

    If you require any assistance or have any questions, please feel free to contact our support team — we’re always happy to help.

    We look forward to your active participation and valuable contributions to the community.

    Warm regards,
    <b style="color: #0d6efd;">Team UBN</b>
@endcomponent
{{-- @component('mail::message')
   
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="https://portal.ubncommunity.com/img/logo2.jpg" alt="UBN Logo" style="height: 60px;">
    </div>

   
    <h2 style="text-align: center; color: #0d6efd; margin-bottom: 10px;">
        Welcome to UBN
    </h2>

    <p style="text-align: center; color: #555;">
        We’re delighted to have you join our community.
    </p>

    ---

   
    <p>Dear {{ $name }},</p>

    <p>
        Your account has been successfully created. Please find your login details below:
    </p>

   
    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border: 1px solid #e0e0e0; margin: 20px 0;">

        <p><b>Username:</b> {{ $username }}</p>
        <p><b>Mobile Number:</b> {{ $contactNo }}</p>
        <p><b>Password:</b> {{ $password }}</p>

    </div>


    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ url('/login') }}" style="background-color: #0d6efd; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold;">
            Login Now
        </a>
    </div>

    <p>
        You can log in using your registered mobile number. For security reasons, please do not share your login credentials with anyone.
    </p>

    <p>
        If you need any assistance, feel free to contact us — we’re here to help.
    </p>

    <p>
        We look forward to your active participation in the community.
    </p>

    ---

    <p style="margin-top: 30px;">
        Warm regards,<br>
        <b style="color:#0d6efd;">Team UBN</b>
    </p>
@endcomponent  --}}
