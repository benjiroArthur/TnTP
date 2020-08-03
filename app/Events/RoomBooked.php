<?php

namespace App\Events;

use App\Booking;
use App\Hotel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomBooked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $book;
    /**
     * Create a new event instance.
     * @param $book
     * @return void
     */
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('roomBooked.'.$this->book['user_id']);
    }

    public function broadcastWith(){
        return ["book" => $this->book];
    }
}
