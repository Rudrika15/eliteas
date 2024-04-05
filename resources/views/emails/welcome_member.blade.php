@component('mail::message')
# Welcome to UBN

Your username is: {{ $user->email }}

Your password is: {{ $user->password }}

Please keep this information secure.

Thank you,
The UBN Team
@endcomponent