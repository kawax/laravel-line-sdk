<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\UnknownEvent;
use Revolution\Line\Facades\Bot;

class UnknownEventListener
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
     * @param  UnknownEvent  $event
     * @return void
     */
    public function handle(UnknownEvent $event): void
    {
        //
    }
}
