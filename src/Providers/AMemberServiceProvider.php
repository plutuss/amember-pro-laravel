<?php

namespace Plutuss\AMember\Providers;

use Illuminate\Support\ServiceProvider;
use Plutuss\AMember\Contracts\AMemberInterface;
use Plutuss\AMember\Services\AMemberService;

class AMemberServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton('amember.app', AMemberInterface::class);

        $this->app->singleton(AMemberInterface::class, function ($app)  {
            return new AMemberService();
        });
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
