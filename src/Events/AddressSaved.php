<?php

declare(strict_types=1);

namespace Rinvex\Addresses\Events;

use Illuminate\Broadcasting\Channel;
use Rinvex\Addresses\Models\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddressSaved implements ShouldBroadcast
{
    use SerializesModels;
    use InteractsWithSockets;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'events';

    /**
     * The model instance passed to this event.
     *
     * @var \Rinvex\Addresses\Models\Address
     */
    public $address;

    /**
     * Create a new event instance.
     *
     * @param \Rinvex\Addresses\Models\Address $address
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new Channel($this->formatChannelName());
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'rinvex.addresses.saved';
    }

    /**
     * Format channel name.
     *
     * @return string
     */
    protected function formatChannelName(): string
    {
        return 'rinvex.addresses.list';
    }
}
