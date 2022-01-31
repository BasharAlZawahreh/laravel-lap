<?php

use App\Http\Controllers\BlogPostAdminController;
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

Route::get('/', function () {
    return view('welcome');
})->name('index');


Route::middleware(['auth','admin'])
->prefix('/admin')
->group(function(){
    Route::get('/',function(){
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/blog',[BlogPostAdminController::class,'index']);

    Route::get('/blog/new',[BlogPostAdminController::class,'create']);
    Route::post('/blog/new',[BlogPostAdminController::class,'store']);

    Route::get('/blog/{post}/edit',[BlogPostAdminController::class,'edit']);
    Route::post('/blog/{post}/edit',[BlogPostAdminController::class,'update']);

    Route::post('/blog/{post}/delete',[BlogPostAdminController::class,'destroy']);
});
