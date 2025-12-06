<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Trix file upload endpoint
    Route::post('/trix/upload', [App\Http\Controllers\TicketAttachmentController::class, 'upload'])->name('trix.upload');

    // Client Routes
    Route::middleware(['role:client'])->prefix('client')->name('client.')->group(function () {
        Route::view('/tickets/create', 'livewire.client.create-ticket-view')->name('tickets.create');
        Route::view('/tickets', 'livewire.client.my-tickets-view')->name('tickets.index');
        Route::get('/tickets/{ticket}', function ($ticket) {
            return view('livewire.client.show-ticket-view', ['ticket' => $ticket]);
        })->name('tickets.show');
    });
});
