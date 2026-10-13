<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// dashboard admin
Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');

// orders
Route::livewire('/orders', 'pages::admin.orders.index')->name('admin.orders.index');

// customers
Route::livewire('/customers', 'pages::admin.customers.index')->name('admin.customers.index');

Route::livewire('/customers/create', 'pages::admin.customers.create')->name('admin.customers.create');







require __DIR__.'/auth.php';
