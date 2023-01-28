<?php

namespace App\Listeners\Various;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use LINE\LINEBot\Event\AccountLinkEvent;
use Revolution\Line\Facades\Bot;

class AccountLinkEventListener
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
     * @param  AccountLinkEvent  $event
     * @return void
     */
    public function handle(AccountLinkEvent $event): void
    {
        //
    }
}
