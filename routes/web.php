<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\CustomersController;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('leads', LeadsController::class);
    Route::put('leads/{lead}/status', [LeadsController::class, 'updateStatus'])->name('leads.updateStatus');
    Route::post('leads/{lead}/convert', [LeadsController::class, 'convert'])->name('leads.convert');

    Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
});

require __DIR__.'/auth.php';
