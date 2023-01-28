<?php

namespace App\Listeners\Message;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MessageEvent\LocationMessage;
use Revolution\Line\Facades\Bot;

class LocationMessageListener
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
     * @param  LocationMessage  $event
     * @return void
     */
    public function handle(LocationMessage $event): void
    {
        //
    }
}
