<?php

namespace App\Listeners\Message;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Revolution\Line\Facades\Bot;
use LINE\LINEBot\Event\MessageEvent\VideoMessage;

class VideoMessageListener
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
     * @param  VideoMessage  $event
     * @return void
     */
    public function handle(VideoMessage $event)
    {
        //
    }
}
