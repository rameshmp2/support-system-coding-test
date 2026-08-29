<div class="table-wrap">
    <table class="table">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Status</th>
                <th>Opened</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr class="{{ $ticket->isNew() ? 'row--new' : '' }}">
                    <td class="mono">{{ $ticket->reference }}</td>
                    <td>{{ $ticket->customer_name }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td><span class="badge {{ $ticket->status->badge() }}">{{ $ticket->status->label() }}</span></td>
                    <td>{{ $ticket->created_at->format('d M Y, H:i') }}</td>
                    <td><a class="btn btn--sm" href="{{ route('agent.tickets.show', $ticket) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted center">No tickets found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination">
    {{ $tickets->links() }}
</div>