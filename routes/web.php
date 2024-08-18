<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventImageController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketTypeController;



Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'events', 'middleware' => 'auth'], function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/', [EventController::class, 'store'])->name('events.store');
    Route::get('/{id}', [EventController::class, 'show'])->name('events.show');
    Route::get('/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/{id}', [EventController::class, 'destroy'])->name('events.destroy');
});

Route::group(['prefix' => 'events/{eventId}/images', 'middleware' => 'auth'], function () {
    Route::post('/', [EventImageController::class, 'store']);
    Route::delete('/{id}', [EventImageController::class, 'destroy']);
});

Route::group(['prefix' => 'tickets', 'middleware' => 'auth'], function () {
    Route::get('/', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::get('/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/{id}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/{id}/download', [TicketController::class, 'downloadQrCode'])->name('tickets.downloadQr');
    Route::get('/{id}/confirm', [TicketController::class, 'confirmTicket'])->name('tickets.confirm');
    Route::get('/{id}/cancel', [TicketController::class, 'cancelTicket'])->name('tickets.cancel');
    Route::post('/{qrCode}/scan', [TicketController::class, 'scanQrCode'])->name('tickets.check');
    Route::get('/search-by-ci', [TicketController::class, 'searchByCi'])->name('search.by.ci');

});

Route::group(['prefix' => 'ticket_types', 'middleware' => 'auth'], function () {
    Route::get('/', [TicketTypeController::class, 'index'])->name('ticket_types.index');
    Route::post('/', [TicketTypeController::class, 'store'])->name('ticket_types.store');
    Route::get('/create', [TicketTypeController::class, 'create'])->name('ticket_types.create');
    Route::get('/{id}', [TicketTypeController::class, 'show'])->name('ticket_types.show');
    Route::get('/{id}/edit', [TicketTypeController::class, 'edit'])->name('ticket_types.edit');
    Route::put('/{id}', [TicketTypeController::class, 'update'])->name('ticket_types.update');
    Route::delete('/{id}', [TicketTypeController::class, 'destroy'])->name('ticket_types.destroy');
    
});
Route::group(['prefix' => 'reports', 'middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::post('/generate-by-event', [App\Http\Controllers\ReportController::class, 'generateByEvent'])->name('reports.generateByEvent');
});

Route::get('/scan', [App\Http\Controllers\QrController::class, 'scan'])->name('qr.scan');
Route::post('/check', [App\Http\Controllers\QrController::class, 'check'])->name('qr.check');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');