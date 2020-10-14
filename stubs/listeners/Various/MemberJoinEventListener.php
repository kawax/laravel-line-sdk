<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MemberJoinEvent;
use Revolution\Line\Facades\Bot;

class MemberJoinEventListener
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
     * @param  MemberJoinEvent  $event
     * @return void
     */
    public function handle(MemberJoinEvent $event)
    {
        //
    }
}
