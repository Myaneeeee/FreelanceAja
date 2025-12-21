<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractWorkflowController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LocaleController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/locale/{locale}', [LocaleController::class, 'setLocale'])->name('locale.set');

// --- AUTHENTICATED ROUTES GROUP ---
Route::middleware(['auth'])->group(function () {

    // --- SHARED CONTRACT WORKFLOW ROUTES ---
    // The main "Workroom" view
    Route::get('/contracts/{id}', [ContractWorkflowController::class, 'show'])->name('contracts.show');
    
    // Actions
    Route::post('/contracts/{id}/submit-work', [ContractWorkflowController::class, 'submitWork'])->name('contracts.submit_work');
    Route::post('/contracts/{id}/approve', [ContractWorkflowController::class, 'approveWork'])->name('contracts.approve');
    Route::post('/contracts/{id}/reject', [ContractWorkflowController::class, 'rejectWork'])->name('contracts.reject');
    Route::post('/contracts/{id}/mark-paid', [ContractWorkflowController::class, 'markPaid'])->name('contracts.mark_paid');
    Route::post('/contracts/{id}/confirm-payment', [ContractWorkflowController::class, 'confirmPayment'])->name('contracts.confirm_payment');

    // Freelancer routes
    Route::prefix('freelancer')->name('freelancer.')->group(function () {
        Route::get('/home', [FreelancerController::class, 'home'])->name('home');
        Route::get('/jobs', [FreelancerController::class, 'jobsIndex'])->name('jobs.index');
        Route::get('/jobs/{id}', [FreelancerController::class, 'jobShow'])->name('jobs.show');
        Route::post('/jobs/{id}/proposals', [FreelancerController::class, 'submitProposal'])->name('jobs.proposals.submit');
        Route::get('/skills', [FreelancerController::class, 'skillsEdit'])->name('skills.edit');
        Route::post('/skills', [FreelancerController::class, 'skillsUpdate'])->name('skills.update');
        Route::get('/contracts', [FreelancerController::class, 'contractsIndex'])->name('contracts.index');
        Route::get('/proposals', [FreelancerController::class, 'proposalsIndex'])->name('proposals.index');
        Route::get('/profile', [FreelancerController::class, 'profileShow'])->name('profile.show');
        Route::get('/profile/edit', [FreelancerController::class, 'profileEdit'])->name('profile.edit');
        Route::post('/profile', [FreelancerController::class, 'profileUpdate'])->name('profile.update');
    });

    // Client routes
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/home', [ClientController::class, 'home'])->name('home');
        Route::get('/jobs/create', [ClientController::class, 'jobCreate'])->name('jobs.create');
        Route::post('/jobs', [ClientController::class, 'jobStore'])->name('jobs.store');
        Route::get('/jobs', [ClientController::class, 'jobsIndex'])->name('jobs.index');
        Route::get('/jobs/{id}/proposals', [ClientController::class, 'jobProposals'])->name('jobs.proposals');
        Route::post('/proposals/{id}/accept', [ClientController::class, 'proposalAccept'])->name('proposals.accept');
        Route::post('/proposals/{id}/reject', [ClientController::class, 'proposalReject'])->name('proposals.reject');
        Route::post('/jobs/{id}/proposals/reject-all', [ClientController::class, 'proposalRejectAll'])->name('proposals.reject_all');
        Route::get('/contracts', [ClientController::class, 'contractsIndex'])->name('contracts.index');
        Route::get('/contracts/create', [ClientController::class, 'contractCreate'])->name('contracts.create');
        Route::post('/contracts', [ClientController::class, 'contractStore'])->name('contracts.store');

        // NEW: Client Profile Routes
        Route::get('/profile', [ClientController::class, 'profileShow'])->name('profile.show');
        Route::get('/profile/edit', [ClientController::class, 'profileEdit'])->name('profile.edit');
        Route::post('/profile', [ClientController::class, 'profileUpdate'])->name('profile.update');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});