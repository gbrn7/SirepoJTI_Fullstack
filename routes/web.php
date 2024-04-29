<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MyDocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\userController;
use App\Http\Controllers\UserDocumentManagementController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/signIn', [AuthController::class, 'userSignin'])->name('signIn.user');
Route::post('/signIn', [AuthController::class, 'authenticate'])->name('signIn.user.authenticate');
Route::post('/signOut', [AuthController::class, 'signOut'])->name('signIn.user.signOut');
Route::get('/signIn/admin', [AuthController::class, 'adminSignin'])->name('signIn.admin');

Route::get('/getSuggestionTitle', [HomeController::class, 'getSuggestionTitle'])->name('getSuggestionTitle');
Route::get('/getSuggestionAuthor', [HomeController::class, 'getSuggestionAuthor'])->name('getSuggestionAuthor');

Route::group(['prefix' => 'home'], function() {
    Route::get('/', [HomeController::class, 'homeView'])->name('home');

    Route::group(['prefix' => 'document'], function() {
        Route::get('/{id}', [DocumentController::class, 'detailDocument'])->name('detail.document');
        Route::get('/download/{fileName}', [DocumentController::class, 'downloadDocument'])->name('detail.document.download');
        Route::get('/user/{id}', [DocumentController::class, 'userDocument'])->name('user.document');
        Route::get('/user/{id}/getSuggestionTitle', [DocumentController::class, 'getSuggestionTitle'])->name('user.document.getSuggestionTitle');
    });

    Route::group(['middleware' => ['auth:web,admin']], function() {
        Route::group(['prefix' => 'user'], function() {
            Route::get('/{id}', [userController::class, 'editProfile'])->name('user.editProfile');
            Route::post('/{id}', [userController::class, 'updateProfile'])->name('user.updateProfile');
        });
    
    
        Route::resource('my-document', MyDocumentController::class)->middleware('role:user');
    
        Route::group(['middleware' => ['role:admin']], function() {
            Route::resource('categories', CategoryController::class)->only([
                'index',
                'store',
                'update',
                'destroy'
            ]);
            
            Route::resource('user-management', UserManagementController::class)->except('show');
            
            Route::resource('user-management.document-management', UserDocumentManagementController::class)->except('show');
        });

    });
});

Route::any('/{any}', function () {
    if(Auth::guard('web')->check() || Auth::guard('admin')->check())return redirect()->route('home');
  return redirect()->route('signIn.user');
  })->where('any', '.*');
