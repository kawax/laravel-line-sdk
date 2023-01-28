<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\MemberLeaveEvent;
use Revolution\Line\Facades\Bot;

class MemberLeaveEventListener
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
     * @param  MemberLeaveEvent  $event
     * @return void
     */
    public function handle(MemberLeaveEvent $event): void
    {
        //
    }
}
