<?php

namespace App\Listeners;

use App\Events\SubscribedMyThread;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSubscribedMyThreadNotification
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
     * @param  SubscribedMyThread  $event
     * @return void
     */
    public function handle(SubscribedMyThread $event)
    {
        //
    }
}
