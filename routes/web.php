<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MeetingGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/submission-response', function () {
    return view('submission-response');
});

Route::get('/create-submission', [SubmissionController::class, 'getCreateSubmissionView'])
    ->name('create.submission.view');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'getAdminView'])->name('admin.view');
    Route::get('/admin/submissions', [SubmissionController::class, 'getAdminSubmissionView'])
        ->name('admin.submission.view');
    
    Route::get('/admin/meeting-groups', [MeetingGroupController::class, 'index'])
        ->name('meeting-groups.index');
    Route::post('/admin/meeting-groups', [MeetingGroupController::class, 'store'])
        ->name('meeting-groups.store');
    Route::patch('/admin/meeting-groups/{meetingGroup}', [MeetingGroupController::class, 'update'])
        ->name('meeting-groups.update');
    Route::delete('/admin/meeting-groups/{meetingGroup}', [MeetingGroupController::class, 'destroy'])
        ->name('meeting-groups.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
