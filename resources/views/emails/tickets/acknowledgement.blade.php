<x-mail::message>
# Thanks, {{ $ticket->customer_name }}

We’ve received your support request and our team will get back to you shortly.

**Your reference number:**

<x-mail::panel>
{{ $ticket->reference }}
</x-mail::panel>

Keep this reference safe - you’ll need it to check the status of your ticket.

<x-mail::button :url="route('status.index')">
Check ticket status
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>