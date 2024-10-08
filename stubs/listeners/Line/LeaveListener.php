<?php

namespace App\Listeners\Line;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\Webhook\Model\GroupSource;
use LINE\Webhook\Model\LeaveEvent;
use LINE\Webhook\Model\RoomSource;

class LeaveListener
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
    public function handle(LeaveEvent $event): void
    {
        $source = $event->getSource();

        if ($source instanceof GroupSource) {
            $id = $source->getGroupId();
        } elseif ($source instanceof RoomSource) {
            $id = $source->getRoomId();
        }

        info($source);
    }
}
