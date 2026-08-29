@extends('layouts.app')
@section('title', 'Open a support ticket')

@section('content')
<div class="card card--narrow">
    <h1>Open a support ticket</h1>
    <p class="muted">Fill in the details below and we’ll email you a reference number.</p>

    {{-- Success panel (shown after AJAX or redirect) --}}
    <div id="ticket-success" class="alert alert--success {{ session('reference') ? '' : 'hidden' }}">
        Ticket created! Your reference number is
        <strong id="ticket-reference">{{ session('reference') }}</strong>.
        Save it to check your ticket status later.
    </div>

    <form id="ticket-form" method="POST" action="{{ route('tickets.store') }}" novalidate>
        @csrf
        <div class="field">
            <label for="customer_name">Your name</label>
            <input type="text" id="customer_name" name="customer_name" required>
            <span class="error" data-error-for="customer_name"></span>
        </div>

        <div class="grid-2">
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="error" data-error-for="email"></span>
            </div>
            <div class="field">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" required>
                <span class="error" data-error-for="phone"></span>
            </div>
        </div>

        <div class="field">
            <label for="ticket_description">Describe your problem</label>
            <textarea id="ticket_description" name="ticket_description" rows="5" required></textarea>
            <span class="error" data-error-for="ticket_description"></span>
        </div>

        <button type="submit" class="btn btn--primary">Submit ticket</button>
    </form>
</div>
@endsection