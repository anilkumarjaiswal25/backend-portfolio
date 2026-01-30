<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/init-db', function () {
    try {
        Artisan::call('migrate:fresh', ['--force' => true]);
        return "Database Migrated Successfully!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
