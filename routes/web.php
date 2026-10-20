<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//!INFO: Don’t forget to run php artisan queue:listen to process the jobs.
Route::webhooks('my-project/webhook', 'my-project');
