@extends('layouts.app')
@section('title', 'Agent login')

@section('content')
<div class="auth-wrap">
    <div class="card card--narrow">
        <h1>Agent login</h1>

        @if($errors->any())
            <div class="alert alert--error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="login-actions">
                <!-- <label class="checkbox">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label> -->
                <button type="submit" class="btn btn--primary">Login</button>
            </div>
        </form>
    </div>
</div>