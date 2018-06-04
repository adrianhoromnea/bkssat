<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\DetaliuProgramarePlataManual::observe(\App\Observers\DetaliuProgramarePlataManualObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
