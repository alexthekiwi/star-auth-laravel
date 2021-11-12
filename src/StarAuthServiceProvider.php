<?php

namespace AlexClark\StarAuth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;
use AlexClark\StarAuth\Http\Middleware\IsAuth;

class StarAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(Kernel $kernel)
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('star-auth.php'),
            ], 'config');
        }

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth.star', IsAuth::class);
    }

    // protected function registerRoutes()
    // {
    //     Route::group($this->routeConfiguration(), function () {
    //         $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    //     });
    // }

    // protected function routeConfiguration()
    // {
    //     return [
    //         'prefix' => config('star-auth.prefix'),
    //         'middleware' => config('star-auth.middleware'),
    //     ];
    // }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'star-auth');

        // Register middleware
        // app('router')->aliasMiddleware('auth.star', IsAuth::class);
        // $router = $this->app['router'];
        // $router->aliasMiddleware('auth.star', IsAuth::class);

        // Register the main class to use with the facade
        $this->app->singleton('star-auth', function () {
            return new StarAuth(config('star-auth.url'), session('access_token', ''));
        });
    }
}
