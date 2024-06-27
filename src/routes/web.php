<?php

use App\Http\Controllers\ProxyController;
use App\Http\Middleware\EnsureProxiesFormIsValid;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('proxy/check', [ProxyController::class, 'check']);
Route::get('proxy/index', [ProxyController::class, 'index']);