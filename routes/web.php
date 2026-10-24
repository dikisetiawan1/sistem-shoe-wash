<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



Route::get('/dashboard', function () {
         return view('admin.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // dashboard admin
    Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');
    // dashboard admin
    Route::livewire('/report-daily', 'pages::admin.reports.daily')->name('admin.reports.daily');
    // masterdata-sidebar
    Route::livewire('/masterdata', 'pages::sidebarcard.masterdata.index')->name('sidebarcard.masterdata.index');
    // transactions-sidebar
    Route::livewire('/transactions', 'pages::sidebarcard.transactions.index')->name('sidebarcard.transactions.index');
    // reports-sidebar
    Route::livewire('/reports', 'pages::sidebarcard.reports.index')->name('sidebarcard.reports.index');
     // settings-sidebar
    Route::livewire('/settings', 'pages::sidebarcard.settings.index')->name('sidebarcard.settings.index');
    // branch
    Route::livewire('/branches', 'pages::admin.branches.index')->name('admin.branches.index');
    // branch create
    Route::livewire('/branches/create', 'pages::admin.branches.create')->name('admin.branches.create');
    // branch edit
    Route::livewire('/branches/{id}', 'pages::admin.branches.edit')->name('admin.branches.edit');
    // orders
    Route::livewire('/orders', 'pages::admin.orders.index')->name('admin.orders.index');
    // orders create
    Route::livewire('/orders/create', 'pages::admin.orders.create')->name('admin.orders.create');
    // orders history
    Route::livewire('/orders/history', 'pages::admin.orders.history')->name('admin.orders.history');
    // orders update status
    Route::livewire('/orders/updatestatus', 'pages::admin.orders.updatestatus')->name('admin.orders.updatestatus');
    // orders edit
    Route::livewire('/orders/edit/{id}', 'pages::admin.orders.edit')->name('admin.orders.edit');
    // order antrean
    Volt::route('/orders/washqueue', 'pages::admin.washqueue.index')->name('admin.washqueue.index');
    // orders detail
    Volt::route('/orders/{id}', 'pages::admin.orderdetail.index')->name('admin.orderdetail.index');
    // orders print
    Route::livewire('/orders/{id}/invoice', 'pages::admin.orders.invoice')->name('admin.orders.invoice');
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
    });

   


require __DIR__.'/auth.php';
