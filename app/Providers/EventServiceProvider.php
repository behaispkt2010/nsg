<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ViewsCompanyEvents' => [
            'App\Listeners\ViewsCompanyListeners',
        ],
        'App\Events\ViewsWareHouseEvents' => [
            'App\Listeners\ViewsWareHouseListeners',
        ],
        'App\Events\ViewsProductEvents' => [
            'App\Listeners\ViewsProductListeners',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
