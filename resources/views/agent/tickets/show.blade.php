@extends('layouts.app')
@section('title', 'Ticket ' . $ticket->reference)

@section('content')
<a href="{{ route('agent.tickets.index') }}" class="back">← Back to tickets</a>

<div class="card">
    <div class="ticket-view__head">
        <h1>{{ $ticket->reference }}</h1>
        <span class="badge {{ $ticket->status->badge() }}">{{ $ticket->status->label() }}</span>

        @unless($ticket->isClosed())
            <form method="POST" action="{{ route('agent.tickets.close', $ticket) }}"
                  onsubmit="return confirm('Close this ticket? The customer won\'t be able to get further replies unless a new ticket is opened.');">
                @csrf
                <button type="submit" class="btn btn--sm">Close ticket</button>
            </form>
        @endunless
    </div>

    <dl class="meta-grid">
        <div><dt>Customer</dt><dd>{{ $ticket->customer_name }}</dd></div>
        <div><dt>Email</dt><dd>{{ $ticket->email }}</dd></div>
        <div><dt>Phone</dt><dd>{{ $ticket->phone }}</dd></div>
        <div><dt>Opened</dt><dd>{{ $ticket->created_at->format('d M Y, H:i') }}</dd></div>
    </dl>

    <h3>Problem</h3>
    <p class="prewrap">{{ $ticket->ticket_description }}</p>

    <h3>Conversation</h3>
    <div id="thread">
        @include('agent.tickets._thread', ['ticket' => $ticket])
    </div>

    @if(session('status'))
        <div class="alert alert--success">{{ session('status') }}</div>
    @endif

    @if($ticket->isClosed())
        <div class="alert alert--success">This ticket is closed.</div>
    @else
        <h3>Reply to customer</h3>
        <form id="reply-form" method="POST" action="{{ route('agent.tickets.reply', $ticket) }}">
            @csrf
            <div class="field">
                <textarea name="message" rows="4" required placeholder="Type your reply…"></textarea>
                <span class="error" data-error-for="message"></span>
            </div>
            <button type="submit" class="btn btn--primary">Send reply</button>
            <span id="reply-flash" class="flash hidden">Reply sent ✓</span>
        </form>
    @endif
</div>
@endsection