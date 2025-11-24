<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\ClientController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Freelancer routes
Route::prefix('freelancer')->name('freelancer.')->group(function () {
    Route::get('/home', [FreelancerController::class, 'home'])->name('home');

    // Jobs: list/search/filter + show + propose
    Route::get('/jobs', [FreelancerController::class, 'jobsIndex'])->name('jobs.index');
    Route::get('/jobs/{id}', [FreelancerController::class, 'jobShow'])->name('jobs.show');
    Route::post('/jobs/{id}/proposals', [FreelancerController::class, 'submitProposal'])->name('jobs.proposals.submit');

    // Skills: view/edit
    Route::get('/skills', [FreelancerController::class, 'skillsEdit'])->name('skills.edit');
    Route::post('/skills', [FreelancerController::class, 'skillsUpdate'])->name('skills.update');

    // Contracts: current + history
    Route::get('/contracts', [FreelancerController::class, 'contractsIndex'])->name('contracts.index');

    // Profile: view/edit
    Route::get('/profile', [FreelancerController::class, 'profileShow'])->name('profile.show');
    Route::get('/profile/edit', [FreelancerController::class, 'profileEdit'])->name('profile.edit');
    Route::post('/profile', [FreelancerController::class, 'profileUpdate'])->name('profile.update');
});

// Client routes
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/home', [ClientController::class, 'home'])->name('home');

    // Jobs: create + list
    Route::get('/jobs/create', [ClientController::class, 'jobCreate'])->name('jobs.create');
    Route::post('/jobs', [ClientController::class, 'jobStore'])->name('jobs.store');
    Route::get('/jobs', [ClientController::class, 'jobsIndex'])->name('jobs.index');

    // Proposals: review per job
    Route::get('/jobs/{id}/proposals', [ClientController::class, 'jobProposals'])->name('jobs.proposals');

    // Contracts: create from accepted proposal
    Route::get('/contracts/create', [ClientController::class, 'contractCreate'])->name('contracts.create');
    Route::post('/contracts', [ClientController::class, 'contractStore'])->name('contracts.store');

    // Optional: accept / reject proposal
    Route::post('/proposals/{id}/accept', [ClientController::class, 'proposalAccept'])->name('proposals.accept');
    Route::post('/proposals/{id}/reject', [ClientController::class, 'proposalReject'])->name('proposals.reject');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');