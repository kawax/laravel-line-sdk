<?php

namespace App\Listeners\Line;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\Webhook\Model\FollowEvent;

class FollowListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FollowEvent $event): void
    {
        $source = $event->getSource();
        $follow = $event->getFollow();

        info($source);
    }
}
