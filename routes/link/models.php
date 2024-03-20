<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth', 'verified')->group(function () {

    Route::view('/colors', 'colors')->name('colors');

    Route::group(['middleware' => ['permission:task.view']],function () {

        Volt::route('tasks', 'pages.tasks.index')       ->name('tasks');

    });


});
