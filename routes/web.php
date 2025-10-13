<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubmissionController;
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
});

Route::get('/submission-response', function() {
    return view('submission-response');
});

Route::get('/create-submission', [SubmissionController::class, 'getCreateSubmissionView'])->name('create.submission.view');
Route::get('/admin/submissions', [SubmissionController::class, 'getAdminSubmissionView'])->name('admin.submission.view');
Route::get('admin', [AdminController::class, 'getAdminView'])->name('admin.view');
