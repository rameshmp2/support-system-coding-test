<?php

use App\Http\Controllers\Agent\TicketController as AgentTicketController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


// ---- Public ----
Route::get('/', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])
    ->middleware('throttle:10,1')            // anti-spam on ticket creation
    ->name('tickets.store');

Route::get('/status', [TicketController::class, 'statusForm'])->name('status.index');
Route::post('/status', [TicketController::class, 'status'])
    ->middleware('throttle:15,1')            // anti-enumeration on reference lookup
    ->name('status.check');

// ---- Auth ----
Route::middleware('guest')->group(function () {
    Route::get('/agent/login', [LoginController::class, 'show'])->name('login');
    Route::post('/agent/login', [LoginController::class, 'login']);
});
Route::post('/agent/logout', [LoginController::class, 'logout'])
    ->middleware('auth')->name('logout');

// ---- Agent (protected) ----
Route::middleware('auth')->prefix('agent')->name('agent.')->group(function () {
    Route::get('/tickets', [AgentTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AgentTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [AgentTicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{ticket}/close', [AgentTicketController::class, 'close'])->name('tickets.close');
});