<?php

namespace Akoziol\RankingPackage;

use Illuminate\Support\ServiceProvider;
use Akoziol\RankingPackage\Services\RankingService;
use Akoziol\RankingPackage\Repositories\RankingRepository;
use Illuminate\Database\DatabaseManager;

class RankingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/Config/ranking.php', 'ranking');

        $this->app->bind(RankingRepository::class, function ($app) {
            return new RankingRepository($app->make(DatabaseManager::class));
        });

        $this->app->bind(RankingService::class, function ($app) {
            return new RankingService($app->make(RankingRepository::class));
        });
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/Routes/api.php');
        $this->loadViewsFrom(__DIR__.'/Resources/views', 'ranking');
        $this->publishes([
            __DIR__.'/Config/ranking.php' => config_path('ranking.php'),
            __DIR__.'/Resources/views' => resource_path('views/vendor/ranking'),
        ], 'ranking-assets');
    }
}
