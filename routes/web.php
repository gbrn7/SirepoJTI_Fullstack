<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\userController;
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

Route::get('/', [HomeController::class, 'welcomeView'])->name('welcome');

Route::get('/getSuggestionTitle', [HomeController::class, 'getSuggestionTitle'])->name('getSuggestionTitle');
Route::get('/getSuggestionAuthor', [HomeController::class, 'getSuggestionAuthor'])->name('getSuggestionAuthor');

Route::group(['prefix' => 'home'], function() {
    Route::get('/', [HomeController::class, 'homeView'])->name('home');
    Route::get('/detailDocument', [HomeController::class, 'detailDocument'])->name('detail.document');

});

// Route::middleware(['auth'])->group(function () {
    Route::resource('my-document', userController::class);
// });

Route::get('/signIn', [AuthController::class, 'userSignin'])->name('signIn.user');
Route::get('/signIn/admin', [AuthController::class, 'adminSignin'])->name('signIn.admin');

