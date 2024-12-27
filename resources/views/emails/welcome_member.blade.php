@component('mail::message')

# Welcome to <b style="color:blue">UBN</b>

Your username is: <b>{{ $username }}</b>

Your Mobile No is: <b>{{ $contactNo }}</b>

{{-- Your password is: {{$password}} --}}

You can now Login with your Mobile No using <b>OTP</b>.

<b style="color:red">Do not share your OTP with anyone. Please keep this Information Secure.</b>


<b style="color: red">Thank you,</b><br>
<b style="color: blue">The UBN Team</b>
@endcomponent