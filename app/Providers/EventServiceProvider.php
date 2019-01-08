<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\CommentMyThread;
use App\Events\LikedMyThread;
use App\Events\MentionedMe;
use App\Events\NewFollower;
use App\Events\SubscribedMyThread;
use App\Listeners\SendCommentMyThreadNotification;
use App\Listeners\SendLikedMyThreadNotification;
use App\Listeners\SendMentionedMeNotification;
use App\Listeners\SendNewFollowerNotification;
use App\Listeners\SendSubscribedMyThreadNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentMyThread::class => [
            SendCommentMyThreadNotification::class,
        ],
        LikedMyThread::class => [
            SendLikedMyThreadNotification::class,
        ],
        MentionedMe::class => [
            SendMentionedMeNotification::class,
        ],
        NewFollower::class => [
            SendNewFollowerNotification::class,
        ],
        SubscribedMyThread::class => [
            SendSubscribedMyThreadNotification::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\Weixin\WeixinExtendSocialite@handle'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
