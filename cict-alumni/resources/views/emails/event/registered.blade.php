@component('mail::message')
# Hello {{ $alumni->first_name }},

You have successfully registered for the event:

**{{ $event->title }}**  
📅 {{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y h:i A') }}  
📍 {{ $event->location }}

We’re excited to see you there!

Thanks,  
CICT Alumni Team
@endcomponent
