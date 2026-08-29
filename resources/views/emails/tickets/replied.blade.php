<x-mail::message>
# Hi {{ $ticket->customer_name }}

A support agent has replied to your ticket **{{ $ticket->reference }}**:

<x-mail::panel>
{{ $reply->message }}
</x-mail::panel>

<x-mail::button :url="route('status.index')">
View full conversation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>