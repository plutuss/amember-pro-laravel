<?php

namespace Plutuss\AMember\Providers;

use Illuminate\Support\ServiceProvider;
use Plutuss\AMember\Services\AMemberInterface;
use Plutuss\AMember\Services\AMemberService;

class AMemberServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/amember.php', 'amember');

        $this->app->singleton(AMemberInterface::class, AMemberService::class);
        $this->app->alias(AMemberInterface::class, 'amember.app');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/amember.php' => config_path('amember.php'),
        ]);
    }
}
