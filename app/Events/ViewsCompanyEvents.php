<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\NewsCompany;

class ViewsCompanyEvents
{
    use InteractsWithSockets, SerializesModels;
    public $viewcompany;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(NewsCompany $viewcompany)
    {
        $this->viewcompany = $viewcompany;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
        // return new PrivateChannel('channel-name');
    }
}
