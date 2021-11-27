<?php

use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\JobTypeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

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

Route::get('', [AuthController::class,'form'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.post');

Route::prefix('admin')->middleware(['loginCheck'])->group(function () {
    Route::get('logout', [AuthController::class, 'signOut'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //applicants
    Route::get('applicants',[ApplicantController::class,'index'])->name('applicants');
    Route::get('applicant-detail/{id}',[ApplicantController::class,'detail'])->name('applicant.detail');
    Route::delete('delete/applicant/{id}',[CommonController::class,'delete']);
    //job types
    Route::get('job-types',[JobTypeController::class,'index'])->name('job-types');
    Route::get('create-job-type',[JobTypeController::class,'create'])->name('job-type.create');
    Route::post('store-job-type',[JobTypeController::class,'store'])->name('store.job-type');
    Route::get('edit-job-type/{id}',[JobTypeController::class,'edit'])->name('edit.job-type');
    Route::put('update-job-type',[JobTypeController::class,'update'])->name('update.job-type');
    Route::delete('delete/job_types/{id}',[CommonController::class,'delete']);
    //jobs
    Route::get('jobs',[JobController::class,'index'])->name('jobs');
    Route::get('create-job',[JobController::class,'create'])->name('job.create');
    Route::post('store-job',[JobController::class,'store'])->name('store.job');
    Route::get('edit-job/{id}',[JobController::class,'edit'])->name('edit.job');
    Route::put('update-job',[JobController::class,'update'])->name('update.job');
    Route::delete('delete/jobs/{id}',[CommonController::class,'delete']);

    //common
    Route::put('job-type-status',[CommonController::class,'statusChange'])->name('status.update');
});
