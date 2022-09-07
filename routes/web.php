<?php

use App\Http\Controllers\GatewayController;
use App\Http\Controllers\PaymentController;
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

Route::get('/', [GatewayController::class, 'gateway1'])->name('gateway.gateway');
Route::get('/g1', [GatewayController::class, 'gateway1'])->name('gateway.gateway1');
Route::get('/g2', [GatewayController::class, 'gateway2'])->name('gateway.gateway2');

Route::post('/', [PaymentController::class, 'store'])->name('payment.store')->middleware(['payment.signed', 'throttle:payment']);
