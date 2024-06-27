<?php

use App\Http\Controllers\ProxyController;
use App\Http\Controllers\QueryController;
use App\Http\Middleware\EnsureProxiesFormIsValid;
use App\Models\Query;
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

Route::post('query/store', [QueryController::class, 'store']);
Route::get('query', [QueryController::class, 'index']);
Route::get('query/{query}', [QueryController::class, 'view']);