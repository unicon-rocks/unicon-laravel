<?php

declare(strict_types=1);

namespace Hedger\Unicon;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class IconServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge the default configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/unicon.php', 'unicon');

        // Bind the IconRenderer to the container
        $this->app->bind(IconRenderer::class, function (Application $app) {
            return new IconRenderer(
                cache: $app->make(IconCache::class),
                downloader: $app->make(IconDownloader::class),
            );
        });

        // Register the Blade component
        Blade::component(
            class: Icon::class,
            alias: config('unicon.name', 'icon'),
        );
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/unicon.php' => config_path('unicon.php'),
            ], 'unicon-config');

            $this->commands([
                Commands\IconsPreloadCommand::class,
            ]);
        }
    }
}
