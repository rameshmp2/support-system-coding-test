@extends('layouts.app')
@section('title', 'Check ticket status')

@section('content')
<div class="card card--narrow">
    <h1>Check your ticket status</h1>
    <p class="muted">Enter the reference number we emailed you.</p>

    <form id="status-form" method="POST" action="{{ route('status.check') }}">
        @csrf
        <div class="field">
            <label for="reference">Reference number</label>
            <input type="text" id="reference" name="reference" placeholder="OSS-XXXXXXXXXXXXXXXX" required>
            <span class="error" data-error-for="reference"></span>
        </div>
        <button type="submit" class="btn btn--primary">Check status</button>
    </form>

    <div id="status-result">
        @isset($ticket)
            @if($ticket)
                @include('tickets._status_result', ['ticket' => $ticket])
            @else
                <div class="alert alert--error">No ticket found for that reference.</div>
            @endif
        @endisset
    </div>
</div>
@endsection