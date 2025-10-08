<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;

// Route::get('/', function () {
//     return view('landing');
// });

Route::get('/', [HomeController::class, 'index'])->name('landing');

Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/profiles/freelancer/{id}', [ProfileController::class, 'showFreelancer'])->name('profiles.freelancer');
Route::get('/profiles/client/{id}', [ProfileController::class, 'showClient'])->name('profiles.client');
