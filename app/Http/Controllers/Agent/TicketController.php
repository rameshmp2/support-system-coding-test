<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplyRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(private readonly TicketService $service) {}

    public function index(Request $request)
    {
        $tickets = $this->service->listForAgent(
            $request->string('search')->trim()->value() ?: null
        );

        
        if ($request->ajax()) {
            return view('agent.tickets._table', compact('tickets'))->render();
        }

        return view('agent.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket = $this->service->viewAsAgent($ticket);

        return view('agent.tickets.show', compact('ticket'));
    }

    public function reply(StoreReplyRequest $request, Ticket $ticket)
    {
        $this->service->reply($ticket, $request->user()->id, $request->validated()['message']);

        if ($request->wantsJson()) {
            $ticket->load(['replies' => fn ($q) => $q->oldest()]);
            return view('agent.tickets._thread', compact('ticket'))->render();
        }

        return redirect()->route('agent.tickets.show', $ticket)
            ->with('status', 'Reply sent to the customer.');
    }

    public function close(Ticket $ticket)
    {
        $this->service->close($ticket);

        return redirect()->route('agent.tickets.show', $ticket)
            ->with('status', 'Ticket closed.');
    }
}
