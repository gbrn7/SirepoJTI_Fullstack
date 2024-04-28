<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MyDocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\userController;
use App\Http\Controllers\UserManagementController;
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

    Route::group(['prefix' => 'document'], function() {
        Route::get('/{id}', [DocumentController::class, 'detailDocument'])->name('detail.document');
        Route::get('/{id}/download', [DocumentController::class, 'downloadDocument'])->name('detail.document.download');
        Route::get('/user/{id}', [DocumentController::class, 'userDocument'])->name('user.document');
        Route::get('/user/{id}/getSuggestionTitle', [DocumentController::class, 'getSuggestionTitle'])->name('user.document.getSuggestionTitle');
    });

    Route::resource('categories', CategoryController::class);

    Route::group(['prefix' => 'user'], function() {
        Route::get('/{id}', [userController::class, 'editProfile'])->name('user.editProfile');
        Route::post('/{id}', [userController::class, 'updateProfile'])->name('user.updateProfile');
    });
});

Route::resource('my-document', MyDocumentController::class);
Route::resource('user-management', UserManagementController::class);


Route::get('/signIn', [AuthController::class, 'userSignin'])->name('signIn.user');
Route::post('/signIn', [AuthController::class, 'authenticate'])->name('signIn.user.authenticate');
Route::get('/signOut', [AuthController::class, 'logout'])->name('signIn.user.logout');

Route::get('/signIn/admin', [AuthController::class, 'adminSignin'])->name('signIn.admin');
Route::post('/signIn/admin', 'Auth\AdminLoginController@login')->name('admin.login.post');
