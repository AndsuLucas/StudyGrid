<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SectionController;

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

Route::get('/', [ContentController::class, 'index']);

Route::resource('content', ContentController::class);

Route::resource('section', SectionController::class);

Route::controller(SectionController::class)->group(function(){
    Route::get('section/{section}/contents', 'contents');
});

require __DIR__.'/auth.php';
