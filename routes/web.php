<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Provisorio hasta conectar el Auth Controller administrativo
    return back()->with('status', 'Controlador de autenticación administrativo en configuración.');
});

// !INFO: Don’t forget to run php artisan queue:listen to process the jobs.
Route::webhooks('my-project/webhook', 'my-project');
