<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
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

Route::get('/', [AuthenticationController::class, 'home'])->name('home');


Route::resource('users', UserController::class);
Route::post('register', [AuthenticationController::class, 'register'])->name('register');
Route::post('login', [AuthenticationController::class, 'login'])->name('login');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
