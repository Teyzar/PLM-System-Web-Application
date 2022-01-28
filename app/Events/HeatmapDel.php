<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HeatmapDel implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $phone_number;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('heatmap-updates');
    }

    public function broadcastAs()
    {
        return 'App\\Events\\HeatmapUpdate';
    }

    public function broadcastWith()
    {
        return ['data' => ['phone_number' => $this->phone_number], 'state' => 'del'];
    }
}
