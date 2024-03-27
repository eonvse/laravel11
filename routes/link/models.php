<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use App\Models\Task;

Route::middleware('auth', 'verified')->group(function () {

    Route::view('/colors', 'colors')->name('colors');

    Volt::route('tasks', 'pages.tasks.index')
    ->middleware(['permission:task.view'])
    ->name('tasks');

    Route::get('/tasks/{task}/{editable?}', [\App\Http\Controllers\ModelController::class,'taskEdit'])
    ->middleware(['permission:task.view|task.edit'])
    ->name('tasks.edit');


});
