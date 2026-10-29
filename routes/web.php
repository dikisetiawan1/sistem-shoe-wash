<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PublicTrackingController;


// Route publik tracking berdasarkan ID atau Resi Order
Route::get('/tracking-order/{id}', [PublicTrackingController::class, 'show']);

Route::get('/dashboard', function () {
         return view('admin.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // dashboard admin
    Route::livewire('/settings/user', 'pages::admin.user.index')->name('admin.user.index');
    // dashboard admin
    Route::livewire('/settings/user/create', 'pages::admin.user.create')->name('admin.user.create');
    // dashboard admin
    Route::livewire('/settings/user/edit/{id}', 'pages::admin.user.edit')->name('admin.user.edit');
    // dashboard admin
    Route::livewire('/dashboard', 'pages::admin.dashboard')->name('admin.dashboard');
     // tracking create
    Route::livewire('/tracking', 'pages::admin.tracking.create')->name('admin.tracking.create');
    // tracking show
    Route::livewire('/tracking-show', 'pages::admin.tracking.show')->name('admin.tracking.show');
    // dashboard report-daily
    Route::livewire('/report-daily', 'pages::admin.reports.daily')->name('admin.reports.daily');
    // dashboard report-monthly
    Route::livewire('/report-monthly', 'pages::admin.reports.monthly')->name('admin.reports.monthly');
    // masterdata-sidebar
    Route::livewire('/masterdata', 'pages::sidebarcard.masterdata.index')->name('sidebarcard.masterdata.index');
    // transactions-sidebar
    Route::livewire('/transactions', 'pages::sidebarcard.transactions.index')->name('sidebarcard.transactions.index');
    // reports-sidebar
    Route::livewire('/reports', 'pages::sidebarcard.reports.index')->name('sidebarcard.reports.index');
     // settings-sidebar
    Route::livewire('/settings', 'pages::sidebarcard.settings.index')->name('sidebarcard.settings.index');
    // branch
    Route::livewire('/masterdata/branches', 'pages::admin.branches.index')->name('admin.branches.index');
    // branch create
    Route::livewire('/masterdata/branches/create', 'pages::admin.branches.create')->name('admin.branches.create');
    // branch edit
    Route::livewire('/masterdata/branches/edit/{id}', 'pages::admin.branches.edit')->name('admin.branches.edit');
    // orders
    Route::livewire('/transactions/orders/payment-confirmation', 'pages::admin.orders.payment-confirmation')->name('admin.orders.payment-confirmation');
    // orders
    Route::livewire('/transactions/orders', 'pages::admin.orders.index')->name('admin.orders.index');
    // orders create
    Route::livewire('/transactions/orders/create', 'pages::admin.orders.create')->name('admin.orders.create');
    // orders history
    Route::livewire('/transactions/orders/history', 'pages::admin.orders.history')->name('admin.orders.history');
    // orders update status
    Route::livewire('/transactions/orders/updatestatus', 'pages::admin.orders.updatestatus')->name('admin.orders.updatestatus');
    // orders edit
    Route::livewire('/transactions/orders/edit/{id}', 'pages::admin.orders.edit')->name('admin.orders.edit');
    // order antrean
    Volt::route('/orders/washqueue', 'pages::admin.washqueue.index')->name('admin.washqueue.index');
    // orders detail
    Volt::route('/transactions/orders/{id}', 'pages::admin.orderdetail.index')->name('admin.orderdetail.index');
    // orders print
    Route::livewire('/orders/{id}/invoice', 'pages::admin.orders.invoice')->name('admin.orders.invoice');
    // customers
    Route::livewire('/masterdata/customers', 'pages::admin.customers.index')->name('admin.customers.index');
    // customers create
    Route::livewire('/masterdata/customers/create', 'pages::admin.customers.create')->name('admin.customers.create');
    // customers edit
    Route::livewire('/masterdata/customers/edit/{id}', 'pages::admin.customers.edit')->name('admin.customers.edit');
    // shoetype
    Route::livewire('/shoetype', 'pages::admin.shoetype.index')->name('admin.shoetype.index');
    // shoetype create
    Route::livewire('/shoetype/create', 'pages::admin.shoetype.create')->name('admin.shoetype.create');
    // shoetype edit
    Route::livewire('/shoetype/edit/{id}', 'pages::admin.shoetype.edit')->name('admin.shoetype.edit');
    // services 
    Route::livewire('/masterdata/services', 'pages::admin.services.index')->name('admin.services.index');
    // services create
    Route::livewire('/masterdata/services/create', 'pages::admin.services.create')->name('admin.services.create');
    // services edit
    Route::livewire('/masterdata/services/edit/{id}', 'pages::admin.services.edit')->name('admin.services.edit');
    });

   


require __DIR__.'/auth.php';
