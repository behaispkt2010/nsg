<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Product;

class ViewsProductEvents
{
    use InteractsWithSockets, SerializesModels;
    public $viewproduct;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Product $viewproduct)
    {
        $this->viewproduct = $viewproduct;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
