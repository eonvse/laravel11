<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth', 'verified')->group(function () {

    Route::group(['middleware' => ['permission:role.view']],function () {
        Volt::route('roles', 'pages.dashboard.roles')
        ->name('roles');
    });

    Route::group(['middleware' => ['permission:user.view']],function () {
        Volt::route('users', 'pages.dashboard.users')
        ->name('users');
    });

});
