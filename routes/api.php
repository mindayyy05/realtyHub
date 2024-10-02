<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\LikePropertyController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/signup', [AuthController::class, 'signUp']);

Route::post('/login', [AuthController::class, 'LoginUser']);

Route::post('/sell', [ListingController::class, 'sell']);
Route::post('/pay', [TransactionController::class, 'pay']);

Route::get('/listings', [ListingController::class, 'getListings']);
Route::get('/rentlistings', [ListingController::class, 'getRentListings']);
Route::get('/salelistings', [ListingController::class, 'getSaleListings']);
Route::get('/apartmentlistings', [ListingController::class, 'getApartmentListings']);
Route::get('/commerciallistings', [ListingController::class, 'getCommercialListings']);
Route::get('/townhouselistings', [ListingController::class, 'getTownhouseListings']);
Route::get('/townhouselistings', [ListingController::class, 'getTownhouseListings']);
Route::get('/trincolistings', [ListingController::class, 'getTrincoListings']);
Route::get('/colombolistings', [ListingController::class, 'getColomboListings']);

Route::post('/like-property', [ListingController::class, 'likeProperty'])->middleware('auth');

// Route for liking a property
Route::post('/like-property', [LikePropertyController::class, 'like'])->middleware('auth');

// Route for unliking a property (optional)
Route::post('/unlike-property', [LikePropertyController::class, 'unlike'])->middleware('auth');

//transactions
