<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventImageController;
use App\Http\Controllers\TicketController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');