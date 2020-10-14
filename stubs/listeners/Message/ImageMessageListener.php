<?php

namespace App\Listeners\Message;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MessageEvent\ImageMessage;
use Revolution\Line\Facades\Bot;

class ImageMessageListener
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
     * @param  ImageMessage  $event
     * @return void
     */
    public function handle(ImageMessage $event)
    {
        //
    }
}
