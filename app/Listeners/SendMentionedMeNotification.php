<?php

namespace App\Listeners;

use App\Events\MentionedMe;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMentionedMeNotification
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
     * @param  MentionedMe  $event
     * @return void
     */
    public function handle(MentionedMe $event)
    {
        //
    }
}
