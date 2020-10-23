<?php

namespace Zorb\GoSMS;

use Illuminate\Support\ServiceProvider;

class GoSMSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/config/gosms.php' => config_path('gosms.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/config/gosms.php', 'gosms');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(GoSMS::class);
    }
}
