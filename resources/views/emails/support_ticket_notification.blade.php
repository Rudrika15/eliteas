@component('mail::message')
# New Support Ticket Created for UBN from {{ $ticket->user->firstName }} {{ $ticket->user->lastName }}

A new support ticket has been created.

**Subject:** {{ $ticket->subject }}
**Priority:** {{ $ticket->priority }}
**Status:** {{ $ticket->status }}

**Description:**
{{ $ticket->description }}

@component('mail::button', ['url' => route('support.index')])
View Ticket
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
