<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\PostbackEvent;
use Revolution\Line\Facades\Bot;

class PostbackEventListener
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
     * @param  PostbackEvent  $event
     * @return void
     */
    public function handle(PostbackEvent $event)
    {
        //
    }
}
