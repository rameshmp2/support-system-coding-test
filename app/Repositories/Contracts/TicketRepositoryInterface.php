<?php

namespace App\Repositories\Contracts;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TicketRepositoryInterface
{
    public function create(array $data): Ticket;

    public function findByReference(string $reference): ?Ticket;

    public function existsByReference(string $reference): bool;

    public function paginateForAgent(?string $search, int $perPage = 10): LengthAwarePaginator;

    public function markAsOpened(Ticket $ticket): void;

    public function addReply(Ticket $ticket, string $userId, string $message): TicketReply;

    public function close(Ticket $ticket): void;
}