<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customers', 'index')->name('customer.list');
    Route::post('/customers/create', 'save')->name('customer.create');
    Route::post('/customers/{customerId}', 'save')->name('customer.update');
    Route::delete('/customers/{customerId}', 'delete')->name('customer.destroy');
});
