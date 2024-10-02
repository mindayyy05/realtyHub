<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ListingController;
use PhpParser\Builder\Property;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Auth\AuthController;

Route::get('/admin/login', function () {
    return view('auth.admin-login'); // Create a view for admin login or reuse the existing one
})->name('admin.login.form');

Route::post('/admin/login', [AuthController::class, 'LoginAdmin'])->name('admin.login');



// Route group with authentication middleware
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Main route for authenticated users
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard route to handle additional actions
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

//admin
Route::get('/dashboard', function () {
    return view('dashboard'); // Make sure this view exists
})->name('dashboard');




//properties listed

Route::get('/properties/listed', [PropertiesController::class, 'listed'])->name('properties.listed');
Route::post('/listings/{id}/publish', [ListingController::class, 'publish'])->name('listings.publish');


Route::get('/properties/listed', [PropertiesController::class, 'listed'])->name('properties.listed');
Route::get('/properties/published', [PropertiesController::class, 'published'])->name('listings.published');
Route::get('/properties/pending', [PropertiesController::class, 'pending'])->name('listings.pending');


Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::resource('users', AuthController::class);
Route::put('/users/{id}', [AuthController::class, 'update'])->name('users.update');
Route::delete('/listings/{id}', [ListingController::class, 'destroy'])->name('listings.destroy');
Route::put('/listings/{id}', [ListingController::class, 'update'])->name('listings.update');
