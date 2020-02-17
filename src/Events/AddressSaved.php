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
