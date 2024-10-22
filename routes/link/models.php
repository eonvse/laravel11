<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth', 'verified')->group(function () {

    Route::view('/colors', 'colors')->name('colors');

    Volt::route('tasks', 'pages.tasks.index')
    ->middleware(['permission:task.view'])
    ->name('tasks');

    Volt::route('events', 'pages.events.index')
    ->middleware(['permission:event.view'])
    ->name('events');

    Volt::route('timedata', 'pages.timedata.index')
    ->middleware(['permission:timedata.view'])
    ->name('timedata');

    Route::get('/tasks/{task}/{editable?}', [\App\Http\Controllers\ModelController::class,'taskEdit'])
    ->middleware(['permission:task.view|task.edit'])
    ->name('tasks.edit');


});
