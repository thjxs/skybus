<?php

namespace App\Traits;

use App\User;

trait Followable
{
    public function likers()
    {
        return $this->morphToMany(User::class, 'followable', 'followables')
            ->wherePivot('relation', '=', 'like')
            ->withPivot('followable_type', 'relation', 'created_at');
    }

    public function subscribers()
    {
        return $this->morphToMany(User::class, 'followable', 'followables')
            ->wherePivot('relation', '=', 'subscribe')
            ->withPivot('followable_type', 'relation', 'created_at');
    }

    public function upvoters()
    {
        return $this->morphToMany(User::class, 'followable', 'followables')
            ->wherePivot('relation', '=', 'upvote')
            ->withPivot('followable_type', 'relation', 'created_at');
    }

    public function downvoters()
    {
        return $this->morphToMany(User::class, 'followable', 'followables')
            ->wherePivot('relation', '=', 'downvote')
            ->withPivot('followable_type', 'relation', 'created_at');
    }

    public function getHasDownVotedAttribute()
    {
        return $this->downvoters->contains(auth()->user());
    }

    public function getHasUpVotedAttribute()
    {
        return $this->upvoters->contains(auth()->user());
    }

    public function getHasSubscribedAttribute()
    {
        return $this->subscribers->contains(auth()->user());
    }

    public function getHasLikedAttribute()
    {
        return $this->likers->contains(auth()->user());
    }

    public function getUpVotersCountAttribute()
    {
        return $this->upvoters()->count();
    }

    public function getDownVotersCountAttribute()
    {
        return $this->downvoters()->count();
    }
}
