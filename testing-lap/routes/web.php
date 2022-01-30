<?php

use App\Http\Controllers\ExternalPostSuggestionController;
use App\Models\BlogPost;
use App\Models\ExternalPostSuggestion;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;

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

Route::get('/', function () {
    return view('welcome', [
        'posts' => BlogPost::all()
    ]);
})->name('index');

Route::post('/external', ExternalPostSuggestionController::class);
