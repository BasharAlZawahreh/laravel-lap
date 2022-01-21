<?php

use App\Http\Controllers\Aramex\CalculateRate;
use App\Http\Controllers\Aramex\CreateOrder;
use App\Models\CreateOrderRequestFromVetrina;
use App\Models\RateRequestFromVetrina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/vetrina-rate-json',RateRequestFromVetrina::class);
Route::get('/vetrina-create-order-json',CreateOrderRequestFromVetrina::class);

Route::post('/aramex/rate', [CalculateRate::class, 'calculate'])->name('aramex.rate');
Route::post('/aramex/create-order', [CreateOrder::class, 'create'])->name('aramex.create');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
