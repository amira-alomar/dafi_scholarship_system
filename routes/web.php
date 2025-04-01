<?php

use App\Http\Controllers\AllUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidiateDashController;
use App\Http\Controllers\ScholarshipController;


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/', [CandidiateDashController::class, "welcome"])
    ->name('welcome');


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

//Auth controller
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


//Admin
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});


// Student
Route::middleware(['auth', 'role:Student'])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
    //================================================================================================
});

//Candidate
Route::middleware(['auth', 'role:Candidate'])->group(function () {
    Route::get('/candidate/dashboard', [CandidiateDashController::class, "index"])
    ->name('candidate.dashboard');
    Route::get('/scholarship/{id}', [ScholarshipController::class, 'show'])
    ->name('scholarship_details');
    Route::get('/track_your_application', [CandidiateDashController::class, 'Track'])
    ->name('track_your_application');
    Route::get('/apply/{scholarship}', [CandidiateDashController::class, 'apply'])
    ->name('apply');

    
});
