<?php

//use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Auth\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\User\PasswordController;
use App\Http\Controllers\User\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Test route !NOG VERWIJDEREN
Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(AuthenticationController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('reset-password', [ForgotPasswordController::class, 'sendPasswordResetLink']);
Route::post('reset/password', [ResetPasswordController::class, 'callResetPassword']);


//Auth Routes
Route::group(['middleware' => 'auth:sanctum'] , function(){
    Route::post('logout', [AuthenticationController::class, 'logout']);
    Route::get('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    Route::controller(ProfileController::class)->group(function(){
        route::get('profile', 'show');
        route::post('profile', 'update');
        route::delete('profile', 'destroy');
    });
    Route::post('password', [PasswordController::class, 'update']);
    
});
