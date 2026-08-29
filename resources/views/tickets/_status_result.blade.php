<div class="ticket-view">
    <div class="ticket-view__head">
        <h2>Ticket {{ $ticket->reference }}</h2>
        <span class="badge {{ $ticket->status->badge() }}">{{ $ticket->status->label() }}</span>
    </div>

    <p><strong>Problem:</strong></p>
    <p class="prewrap">{{ $ticket->ticket_description }}</p>

    <h3>Replies</h3>
    @forelse($ticket->replies as $reply)
        <div class="reply">
            <div class="reply__meta">Support agent · {{ $reply->created_at->diffForHumans() }}</div>
            <div class="prewrap">{{ $reply->message }}</div>
        </div>
    @empty
        <p class="muted">No replies yet. We’ll email you when an agent responds.</p>
    @endforelse
</div>