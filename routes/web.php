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
// customers create
Route::livewire('/customers/create', 'pages::admin.customers.create')->name('admin.customers.create');
// customers edit
Route::livewire('/customers/edit/{id}', 'pages::admin.customers.edit')->name('admin.customers.edit');
// shoetype
Route::livewire('/shoetype', 'pages::admin.shoetype.index')->name('admin.shoetype.index');
// shoetype create
Route::livewire('/shoetype/create', 'pages::admin.shoetype.create')->name('admin.shoetype.create');
// shoetype edit
Route::livewire('/shoetype/edit/{id}', 'pages::admin.shoetype.edit')->name('admin.shoetype.edit');
// services 
Route::livewire('/services', 'pages::admin.services.index')->name('admin.services.index');

// services create
Route::livewire('/services/create', 'pages::admin.services.create')->name('admin.services.create');
// services edit
Route::livewire('/services/edit/{id}', 'pages::admin.services.edit')->name('admin.services.edit');



require __DIR__.'/auth.php';
