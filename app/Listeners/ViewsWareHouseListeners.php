<?php

namespace App\Listeners;

use App\Events\ViewsWareHouseEvents;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViewsWareHouseListeners
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ViewsWareHouseEvents  $event
     * @return void
     */
    public function handle(ViewsWareHouseEvents $event)
    {
        // dd($event->viewware);
        $event->viewware->increment('count_view');
        
    }
}
