@extends('layouts.app')
@section('title', 'Tickets')

@section('content')
<div class="card">
    <div class="list-head">
        <h1>Support tickets</h1>
        <input type="search" id="ticket-search" placeholder="Search by customer name…"
               value="{{ request('search') }}" autocomplete="off">
    </div>

    <div id="tickets-table" data-url="{{ route('agent.tickets.index') }}">
        @include('agent.tickets._table', ['tickets' => $tickets])
    </div>
</div>
@endsection