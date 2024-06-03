<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Events\TaskDelete;
use App\Listeners\TaskDeleteRun;

class EventServiceProvider extends ServiceProvider
{
    
    
    protected $listen = [
        TaskDelete::class => [
            TaskDeleteRun::class,
        ],
    ];

    
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
        //
    }
}
