<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dummy login route untuk mengatasi error "Route [login] not defined"
Route::get('/login', function () {
    return response()->json(['message' => 'This is web login page. Use API endpoints for authentication.']);
})->name('login');
