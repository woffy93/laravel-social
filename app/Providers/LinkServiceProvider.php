<?php

namespace App\Providers;

use App\Service\FollowService;
use App\Service\FollowServiceInterface;
use App\Service\LinkService;
use App\Service\LinkServiceInterface;
use Illuminate\Support\ServiceProvider;

class LinkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(LinkServiceInterface::class, function (){
            return new LinkService();
        });
        $this->app->bind(FollowServiceInterface::class, function (){
            return new FollowService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
