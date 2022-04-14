<?php

namespace App\Events;

use App\Models\Unit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnitUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $unit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('Units');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->unit->id,
            'status' => $this->unit->status,
            'formatted_address' => $this->unit->formatted_address,
            'updated_at' => $this->unit->updated_at,
        ];
    }
}
