<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});







Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login'); // Admin Login Page
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit'); // Admin Login Action
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout'); // Admin Logout

    // Route::middleware(['auth.admin'])->group(function () {
    //     Route::get('/dashboard', function () {
    //         return view('admin.dashboard');
    //     })->name('admin.dashboard'); // Admin Dashboard Route (Protected)
    // });
// ye wrong but abhi ke liye
    Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');



});


