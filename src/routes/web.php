<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LecturerManagementController;
use App\Http\Controllers\ThesisSubmissionController;
use App\Http\Controllers\userController;
use App\Http\Controllers\StudentManagementController;
use App\Http\Controllers\ThesisTopicController;
use App\Http\Controllers\ThesisTypeController;
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

Route::get('/filter/year', [HomeController::class, 'yearFilterView'])->name('filter.year.view');
Route::get('/filter/program-study', [HomeController::class, 'studyProgramFilterView'])->name('filter.program-study.view');
Route::get('/filter/topic', [HomeController::class, 'topicFilterView'])->name('filter.topic.view');
Route::get('/filter/author', [HomeController::class, 'authorFilterView'])->name('filter.author.view');
Route::get('/filter/thesis-type', [HomeController::class, 'thesisTypeFilterView'])->name('filter.thesis-type.view');

Route::get('/logIn', [AuthController::class, 'studentSignin'])->name('signIn.student');
Route::post('/logIn', [AuthController::class, 'authenticate'])->name('signIn.user.authenticate');
Route::post('/signOut', [AuthController::class, 'signOut'])->name('signIn.user.signOut');
Route::get('/logIn/admin', [AuthController::class, 'adminSignin'])->name('signIn.admin');
Route::get('/logIn/lecturer', [AuthController::class, 'lecturerSignin'])->name('signIn.lecturer');

Route::get('/getSuggestionTitle', [HomeController::class, 'getSuggestionThesisTitle'])->name('getSuggestionTitle');
Route::get('/getSuggestionAuthor', [HomeController::class, 'getSuggestionAuthor'])->name('getSuggestionAuthor');
Route::get('/getSuggestionAuthorByUsername', [HomeController::class, 'getSuggestionAuthorByUsername'])->name('getSuggestionAuthorByUsername');

Route::group(['prefix' => 'home'], function () {
    Route::get('/', [HomeController::class, 'homeView'])->name('home');

    Route::group(['prefix' => 'document'], function () {
        Route::get('/{ID}', [DocumentController::class, 'detailDocument'])->name('detail.document');
        Route::get('/download/{thesis_id}', [DocumentController::class, 'downloadDocument'])->name('detail.document.download')->middleware('auth:student,admin,lecturer');
        Route::get('/user/{id}', [DocumentController::class, 'userDocument'])->name('user.document');
        Route::get('/user/{id}/getSuggestionTitle', [DocumentController::class, 'getSuggestionTitle'])->name('user.document.getSuggestionTitle');
    });

    Route::group(['middleware' => ['auth:student,admin,lecturer']], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/{id}', [userController::class, 'editProfile'])->name('user.editProfile');
            Route::post('/{id}', [userController::class, 'updateProfile'])->name('user.updateProfile');
        });

        Route::resource('thesis-submission', ThesisSubmissionController::class)->middleware('role:student');

        Route::group(['middleware' => ['auth:admin,lecturer']], function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        });

        Route::group(['middleware' => ['role:admin']], function () {
            Route::resource('thesis-topic-management', ThesisTopicController::class)->only([
                'index',
                'store',
                'update',
                'destroy'
            ]);

            Route::resource('thesis-type-management', ThesisTypeController::class)->only([
                'index',
                'store',
                'update',
                'destroy'
            ]);

            Route::resource('lecturer', ThesisSubmissionController::class)->middleware('role:student');

            Route::resource('student-management', StudentManagementController::class);
            Route::get('/getUserImportTemplate', [StudentManagementController::class, 'getStudentImportTemplate'])->name('getStudentImportTemplate');
            Route::post('student-management/importStudentExcelData', [StudentManagementController::class, 'importStudentExcelData'])->name('importStudentExcelData');

            Route::put('document-management/submission-status', [DocumentController::class, 'bulkUpdateSubmissionStatus'])->name('document-management.update-submission-status');

            Route::resource('document-management', DocumentController::class)->only([
                'index',
                'create',
                'store',
                'edit',
                'update',
                'show',
                'destroy'
            ]);

            Route::resource('lecturer-management', LecturerManagementController::class);
            Route::get('/getLecturerImportTemplate', [LecturerManagementController::class, 'getLecturerImportTemplate'])->name('getLecturerImportTemplate');
            Route::post('lecturer-management/importLecturerExcelData', [LecturerManagementController::class, 'importLecturerExcelData'])->name('importLecturerExcelData');
        });

        Route::group(['middleware' => ['auth:lecturer']], function () {
            route::get('/thesis-submission-lecturer', [DocumentController::class, 'thesisSubmissionLecturer'])->name('thesis-submission-lecturer.index');
        });
    });
});

Route::any('/{any}', function () {
    abort(404);
})->where('any', '.*');
