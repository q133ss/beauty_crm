<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
Auth::routes(['verify' => true]);

Route::get('logout', function (){
    Auth::logout();
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/orders/filter/{field}/{sort?}/{orientation?}', [App\Http\Controllers\OrdersController::class, 'filter']);
Route::post('/orders/{id}/status', [App\Http\Controllers\OrdersController::class, 'updateStatus'])->name('orders.status.change');
Route::resource('orders', App\Http\Controllers\OrdersController::class)->except('delete');

Route::middleware('permission')->middleware('verified')->group(function (){
    Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);

    Route::get('/clients/salon/filter/{salon_id}', [App\Http\Controllers\ClientController::class, 'salonFilter']);
    Route::get('/clients/client/filter/{client_id}', [App\Http\Controllers\ClientController::class, 'clientFilter']);
    Route::get('/clients/search/{request}', [App\Http\Controllers\ClientController::class, 'search']);
    Route::get('/clients/{id}/contact/', [App\Http\Controllers\ClientController::class, 'getContacts']);
    Route::resource('clients', App\Http\Controllers\ClientController::class);
});
