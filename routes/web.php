<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CompanyController;
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
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('admin.includes.dashboard');
})->name('dashboard');

Route::view('/admin/dashboard', 'admin.includes.dashboard.');


Route::resource('company', CompanyController::class);

Route::controller(UserController::class)->group(function () {
    Route::resource('users', UserController::class);
});
