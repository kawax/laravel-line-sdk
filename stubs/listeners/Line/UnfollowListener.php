<?php

namespace App\Listeners\Line;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\Webhook\Model\UnfollowEvent;
use LINE\Webhook\Model\UserSource;

class UnfollowListener
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
    public function handle(UnfollowEvent $event): void
    {
        $source = $event->getSource();

        if ($source instanceof UserSource) {
            $id = $source->getUserId();
        }

        info($source);
    }
}
