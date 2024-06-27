<?php

namespace App\Providers;

use App\Clients\IpApiClient;
use App\Clients\ProxyCheckerClient;
use App\Clients\ProxyConnectionTestClient;
use App\Jobs\ProcessProxyIp;
use App\Jobs\ProcessProxyTest;
use App\Services\ProxyService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bindMethod([ProcessProxyIp::class, 'handle'], function (ProcessProxyIp $job, Application $app) {
            return $job->handle(
                $app->make(ProxyService::class),
                $app->make(ProxyCheckerClient::class) // $app->make(IpApiClient::class), // Запасной вариант, можно реализовать использование 2х сервисов если первый выкинет ошибку например
            );
        });

        $this->app->bindMethod([ProcessProxyTest::class, 'handle'], function (ProcessProxyTest $job, Application $app) {
            return $job->handle(
                $app->make(ProxyConnectionTestClient::class)
            );
        });

        Paginator::useBootstrapFive();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
