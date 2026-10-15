@component('mail::message')

Dear {{ $name }},

Welcome to **UBN**!

We’re delighted to have you as part of the UBN community. Your account has been successfully created. Please find your login details below:

**Username:** {{ $username }}  
**Password:** {{ $password }}

**Login URL:**  
{{ $loginUrl }}

You may now log in using your registered mobile number.

For security reasons, we strongly recommend that you keep your login credentials confidential and do not share them with anyone.

If you require any assistance or have any questions, please feel free to contact our support team — we’re always happy to help.

We look forward to your active participation and valuable contributions to the community.

Warm regards,  
**Team UBN**

@endcomponent
