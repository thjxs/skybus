<?php

namespace App\Policies;

use App\User;
use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create()
    {
        return true;
    }

    public function update(User $authUser, Thread $thread)
    {
        return $thread->user_id === $authUser->id;
    }

    public function delete(User $authUser, Thread $thread)
    {
        return $thread->user_id === $authUser->id;
    }
}
