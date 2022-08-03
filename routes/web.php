<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RankController;
use App\Http\Controllers\OrderController;

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

// Route::get('/', function () {
// return view('welcome');
// });

Route::get('/', [RankController::class, 'index']);
Route::get('/most-valueable-sale', [RankController::class, 'mvs']);
Route::get('/most-orders-by-customer', [OrderController::class, 'mostOrders']);
Route::get('/most-spents-by-customer', [OrderController::class, 'mostSpents']);
