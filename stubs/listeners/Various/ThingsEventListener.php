<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\ThingsEvent;
use Revolution\Line\Facades\Bot;

class ThingsEventListener
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
     * @param  ThingsEvent  $event
     * @return void
     */
    public function handle(ThingsEvent $event)
    {
        //
    }
}
