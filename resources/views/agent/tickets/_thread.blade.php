@forelse($ticket->replies as $reply)
    <div class="reply">
        <div class="reply__meta">You · {{ $reply->created_at->diffForHumans() }}</div>
        <div class="prewrap">{{ $reply->message }}</div>
    </div>
@empty
    <p class="muted">No replies yet.</p>
@endforelse