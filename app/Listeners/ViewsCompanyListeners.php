<?php

namespace App\Listeners;

use App\Events\ViewsCompanyEvents;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ViewsCompanyListeners
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
     * @param  ViewsCompanyEvents  $event
     * @return void
     */
    public function handle(ViewsCompanyEvents $event)
    {
        // dd($event->viewcompany);
        $event->viewcompany->increment('view_count');
    }
}
