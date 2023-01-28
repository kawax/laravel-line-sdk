<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\UnfollowEvent;
use Revolution\Line\Facades\Bot;

class UnfollowEventListener
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
     * @param  UnfollowEvent  $event
     * @return void
     */
    public function handle(UnfollowEvent $event): void
    {
        //
    }
}
