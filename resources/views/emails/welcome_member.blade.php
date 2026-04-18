@component('mail::message')
    Dear {{ $name }},

    Welcome to <b style="color: #0d6efd;">UBN</b>!

    We’re delighted to have you as part of the UBN community. Your account has been successfully created. Please find your login details below:

    <b>Username:</b> {{ $username }}
    <b>Password:</b> {{ $password }}

    <b>Login URL:</b><br>
    <a href="{{ $loginUrl }}" target="_blank" rel="noopener noreferrer">
        {{ $loginUrl }}
    </a>
    You may now log in using your registered mobile number.

    For security reasons, we strongly recommend that you keep your login credentials confidential and do not share them with anyone.

    If you require any assistance or have any questions, please feel free to contact our support team — we’re always happy to help.

    We look forward to your active participation and valuable contributions to the community.

    Warm regards,
    <b style="color: #0d6efd;">Team UBN</b>
@endcomponent
