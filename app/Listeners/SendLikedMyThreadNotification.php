<?php

namespace App\Listeners;

use App\Events\LikedMyThread;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendLikedMyThreadNotification
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
     * @param  LikedMyThread  $event
     * @return void
     */
    public function handle(LikedMyThread $event)
    {
        //
    }
}
