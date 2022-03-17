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

class HeatmapUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function broadcastOn()
    {
        return new Channel('Home');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->unit->id,
            'status' => $this->unit->status,
            'latitude' => $this->unit->latitude,
            'longitude' => $this->unit->longitude,
        ];
    }
}
