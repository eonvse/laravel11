<?php

use Illuminate\Support\Facades\Route;

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/laravel11/public/livewire/livewire.js', $handle);
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/laravel11/public/livewire/update', $handle)
        ->middleware(['auth', 'verified']); 
});
