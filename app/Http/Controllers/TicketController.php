<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckStatusRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(private readonly TicketService $service) {}

    public function create()
    {
        return view('tickets.create');
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->service->openTicket($request->validated());

        
        if ($request->wantsJson()) {
            return response()->json([
                'message'   => 'Your ticket has been created.',
                'reference' => $ticket->reference,
            ], 201);
        }

        return redirect()->route('tickets.create')
            ->with('reference', $ticket->reference);
    }

    public function statusForm()
    {
        return view('tickets.status');
    }

    public function status(CheckStatusRequest $request)
    {
        $ticket = $this->service->findByReference($request->validated()['reference']);

        if ($request->wantsJson()) {
            return $ticket
                ? view('tickets._status_result', compact('ticket'))->render()
                : response()->json(['message' => 'No ticket found for that reference.'], 404);
        }

        return view('tickets.status', compact('ticket'));
    }
}
