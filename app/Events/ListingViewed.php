<?php

namespace App\Events;

use App\Listing;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;

class ListingViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Listing $listing)
    {
        $this->data = [
            'listing' => $listing,
            'current_user' => Auth::user()->id
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('listing'.$this->data['listing']->id);
    }
}
