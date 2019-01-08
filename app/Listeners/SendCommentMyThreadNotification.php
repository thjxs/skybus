<?php

namespace App\Listeners;

use App\Events\CommentMyThread;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommentMyThreadNotification
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
     * @param  CommentMyThread  $event
     * @return void
     */
    public function handle(CommentMyThread $event)
    {
        if ($event->user->id !== $event->comment->user_id) {
            $event->user->sendCommentMyThreadNotification($event->comment);
        }
    }
}
