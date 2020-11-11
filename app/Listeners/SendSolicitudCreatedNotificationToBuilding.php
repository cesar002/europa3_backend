<?php

namespace App\Listeners;

use App\Events\SolicitudCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSolicitudCreatedNotificationToBuilding
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SolicitudCreated  $event
     * @return void
     */
    public function handle(SolicitudCreated $event)
    {
		$message = $event->message;
		$edificio = $message->edificio()->first();
		$edificio->notify(new \App\Notifications\NotificationSolicitudCreated($message));
    }
}
