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

Route::middleware('permission')->middleware('verified')->group(function (){
    Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);

    Route::post('/clients/{id}/get-contact', [App\Http\Controllers\ClientController::class, 'getContact']);
    Route::post('/clients/{filter}/{sort?}/{orientation?}', [App\Http\Controllers\ClientController::class, 'filter']);
    Route::resource('clients', App\Http\Controllers\ClientController::class);

    Route::get('salons/get-usr/{salon_id}/{user_id}', [App\Http\Controllers\SalonController::class, 'getUser'])->name('salons.get.user');
    Route::post('salons/add-user', [App\Http\Controllers\SalonController::class, 'addUser'])->name('salons.add.user');
    Route::resource('salons', App\Http\Controllers\SalonController::class);

    Route::get('/orders/filter/{field}/{sort?}/{orientation?}', [App\Http\Controllers\OrdersController::class, 'filter']);
    Route::post('/orders/{id}/status', [App\Http\Controllers\OrdersController::class, 'updateStatus'])->name('orders.status.change');
    Route::resource('orders', App\Http\Controllers\OrdersController::class)->except('delete');

    Route::get('finances/{type}', [App\Http\Controllers\FinanceController::class, 'detail'])->whereIn('type', ['incomes', 'expenses']);
    Route::resource('finances', App\Http\Controllers\FinanceController::class)->except('show', 'destroy');

    Route::get('settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
});
