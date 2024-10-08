<?php

namespace App\Listeners\Line;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\Webhook\Model\GroupSource;
use LINE\Webhook\Model\JoinEvent;
use LINE\Webhook\Model\RoomSource;
use LINE\Webhook\Model\StickerMessageContent;
use LINE\Webhook\Model\TextMessageContent;

class JoinListener
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
    public function handle(JoinEvent $event): void
    {
        $source = $event->getSource();

        if ($source instanceof GroupSource) {
            $id = $source->getGroupId();
        }

        info($source);
    }
}
