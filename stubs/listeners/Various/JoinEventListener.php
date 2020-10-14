<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\JoinEvent;
use Revolution\Line\Facades\Bot;

class JoinEventListener
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
     * @param  JoinEvent  $event
     * @return void
     */
    public function handle(JoinEvent $event)
    {
        //
    }
}
