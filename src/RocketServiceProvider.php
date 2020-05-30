<?php

namespace Hector\V2bAdapter;

use Illuminate\Support\ServiceProvider;

class RocketServiceProvider extends ServiceProvider{

    public function register()
    {
        $this->registerRouteMiddleware();
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->registerPublishing();
    }


    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/config' => config_path()], 'rocket-config');
        }
    }

    protected $routeMiddleware = [
        'rocket.auth'       => Middleware\User::class,
    ];

    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }
    }
}
