<?php

namespace App\Events;

use App\NotificationAdmin;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationAdminSender implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

	public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(NotificationAdmin $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notifications-admin-channel');
    }

	public function broadcastAs()
	{
		return 'notificacion-enviada';
	}

}
