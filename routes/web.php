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
    Route::post('/records/filter', [App\Http\Controllers\RecordsController::class, 'filter']);
    Route::resource('records', App\Http\Controllers\RecordsController::class);
});
