<?php

use App\Http\Controllers\Auth\SocialiteUserController;
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

Route::get('/login/{socialite_provider}', [SocialiteUserController::class, 'getSocialiteRedirect']);
Route::get('/login/{socialite_provider}/callback', [SocialiteUserController::class, 'getSocialiteCallback']);


//vue router will handle all routing
Route::get('/{any}', function () {
    return view('home');
})->where('any', '.*');
