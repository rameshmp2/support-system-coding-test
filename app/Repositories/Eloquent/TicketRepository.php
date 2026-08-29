<?php

namespace App\Repositories\Eloquent;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Repositories\Contracts\TicketRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TicketRepository implements TicketRepositoryInterface
{
    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function findByReference(string $reference): ?Ticket
    {
        return Ticket::query()
            // Eager load replies 
            ->with(['replies' => fn ($q) => $q->oldest()])
            ->where('reference', $reference)
            ->first();
    }

    public function existsByReference(string $reference): bool
    {
        return Ticket::query()->where('reference', $reference)->exists();
    }

    public function paginateForAgent(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        return Ticket::query()
            ->select(['id', 'reference', 'customer_name', 'email', 'status', 'created_at', 'opened_at'])
            ->search($search)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function markAsOpened(Ticket $ticket): void
    {
        if ($ticket->status === TicketStatus::New) {
            $ticket->forceFill([
                'status'    => TicketStatus::Opened,
                'opened_at' => now(),
            ])->save();
        }
    }

    public function addReply(Ticket $ticket, string $userId, string $message): TicketReply
    {
        return DB::transaction(function () use ($ticket, $userId, $message) {
            $reply = $ticket->replies()->create([
                'user_id' => $userId,
                'message' => $message,
            ]);

            $ticket->update(['status' => TicketStatus::Replied]);

            return $reply;
        });
    }

    public function close(Ticket $ticket): void
    {
        if ($ticket->status !== TicketStatus::Closed) {
            $ticket->update(['status' => TicketStatus::Closed]);
        }
    }
}