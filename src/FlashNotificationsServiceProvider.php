<?php

declare(strict_types=1);

namespace GranadaPride\LaravelFlash;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class FlashNotificationsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('flash', function () {
            return new Flash();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/flash-notifications.php' => config_path('flash-notifications.php'),
        ], 'flash-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/flash-notifications'),
        ], 'flash-views');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'flash-notifications');

        Blade::component('flash-messages', \GranadaPride\LaravelFlash\View\Components\FlashMessages::class);

        view()->composer('*', function ($view) {
            $view->with('flash', app('flash'));
        });
    }
}
