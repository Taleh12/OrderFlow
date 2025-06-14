<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;

use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        \App\Events\OrderCreated::class => [
            \App\Listeners\SendOrderNotification::class,
        ],
    ];
}
