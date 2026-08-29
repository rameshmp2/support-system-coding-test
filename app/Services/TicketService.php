<?php

namespace App\Services;

use App\Mail\TicketAcknowledgement;
use App\Mail\TicketReplied;
use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TicketService
{
    public function __construct(
        private readonly TicketRepositoryInterface $tickets
    ) {}

    public function openTicket(array $data): Ticket
    {
        $data['reference'] = $this->generateUniqueReference();

        $ticket = $this->tickets->create($data);

        // ticket opened email to customer
        Mail::to($ticket->email)->queue(new TicketAcknowledgement($ticket));

        return $ticket;
    }

    public function listForAgent(?string $search): LengthAwarePaginator
    {
        return $this->tickets->paginateForAgent($search);
    }

    public function viewAsAgent(Ticket $ticket): Ticket
    {
        // Opening the ticket marks it as seen 
        $this->tickets->markAsOpened($ticket);

        return $ticket->load(['replies' => fn ($q) => $q->oldest()]);
    }

    public function reply(Ticket $ticket, string $agentId, string $message): void
    {
        $reply = $this->tickets->addReply($ticket, $agentId, $message);

        Mail::to($ticket->email)->queue(new TicketReplied($ticket, $reply));
    }

    public function close(Ticket $ticket): void
    {
        $this->tickets->close($ticket);
    }

    public function findByReference(string $reference): ?Ticket
    {
        return $this->tickets->findByReference($reference);
    }

    // generate unique reference for ticket
    private function generateUniqueReference(): string
    {
        do {
            $reference = 'OSS-' . strtoupper(Str::random(16));
        } while ($this->tickets->existsByReference($reference));

        return $reference;
    }
}