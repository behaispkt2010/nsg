<?php

namespace App\Listeners;

use App\Events\ViewsProductEvents;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViewsProductListeners
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
     * @param  ViewsProductEvents  $event
     * @return void
     */
    public function handle(ViewsProductEvents $event)
    {
        $event->viewproduct->increment('count_view');
    }
}
