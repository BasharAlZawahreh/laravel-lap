<?php

use App\Http\Controllers\Aramex\CalculateRate;
use App\Models\RequestFromVetrina;
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

Route::get('/vetrina-json',RequestFromVetrina::class);

Route::post('/aramex/rate', [CalculateRate::class, 'calculate'])->name('aramex.rate');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
