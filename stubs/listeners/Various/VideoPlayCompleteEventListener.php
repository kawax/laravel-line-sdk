<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\VideoPlayCompleteEvent;
use Revolution\Line\Facades\Bot;

class VideoPlayCompleteEventListener
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
     * @param  VideoPlayCompleteEvent  $event
     * @return void
     */
    public function handle(VideoPlayCompleteEvent $event): void
    {
        //
    }
}
