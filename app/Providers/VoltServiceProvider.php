<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

use Illuminate\Support\Facades\Gate;

class VoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Volt::mount([
            config('livewire.view_path', resource_path('views/livewire')),
            resource_path('views/pages'),
        ]);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

    }
}
