<?php

namespace Chrishenrique\LaravelAssets;

use Chrishenrique\LaravelAssets\Commands\ClearAssetsCommand;
use Chrishenrique\LaravelAssets\Commands\ListAssetsCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class LaravelAssetsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/laravel-assets.php', 'laravel-assets');
        
        $this->app->singleton('asset.manager', function ($app) {
            return new AssetManager();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/laravel-assets.php' => config_path('laravel-assets.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                ListAssetsCommand::class,
                ClearAssetsCommand::class,
            ]);
        }

        Blade::directive('renderStyles', function () {
            return "<?php echo \Chrishenrique\LaravelAssets\Facades\AssetManager::renderStyles(); ?>";
        });

        Blade::directive('renderScripts', function ($position) {
            return "<?php echo \Chrishenrique\LaravelAssets\Facades\AssetManager::renderScripts($position); ?>";
        });
    }
}