<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\FollowEvent;
use Revolution\Line\Facades\Bot;

class FollowEventListener
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
     * @param  FollowEvent  $event
     * @return void
     */
    public function handle(FollowEvent $event): void
    {
        //
    }
}
