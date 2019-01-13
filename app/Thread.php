<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Followable;

class Thread extends Model
{
    use SoftDeletes, Followable;

    protected $fillable = [
        'title', 'user_id', 'node_id', 'published_at', 'cache', 'cache->views_count',
    ];

    protected $dates = [
        'published_at', 'excellent_at', 'pinned_at', 'frozen_at', 'banned_at',
    ];

    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'cache' => 'array',
    ];

    protected $appends = [
        'has_pinned', 'has_banned', 'has_excellent', 'has_frozen', 'has_liked',
        'has_subscribed', //'created_at_timeago', 'updated_at_timeago',
    ];

    protected $with = ['user'];

    const CACHE_FIELDS = [
        'views_count' => 0,
        'comments_count' => 0,
        'likes_count' => 0,
        'subscriptions_count' => 0,
        'last_reply_user_id' => 0,
        'last_reply_user_name' => null,
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($thread) {
            if (request()->get('is_draft')) {
                $thread->published_at = null;
            } else {
                $thread->published_at = now();
            }
        });
    }

    public function content()
    {
        return $this->morphOne(Content::class, 'contentable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function node()
    {
        return $this->belongsTo(Node::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCacheAttribute()
    {
        return array_merge(self::CACHE_FIELDS,
            json_decode($this->attributes['cache'] ?? '{}', true));
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
            ->whereHas('user', function ($q) {
                $q->whereNull('banned_at');
            });
    }

    public function scopeWithOrder($query, $order, $sort)
    {
        return $query->orderBy($order, $sort);
    }

    public function getHasPinnedAttribute()
    {
        return (bool) $this->pinned_at;
    }

    public function getHasBannedAttribute()
    {
        return (bool) $this->banned_at;
    }

    public function getHasExcellentAttribute()
    {
        return (bool) $this->excellent_at;
    }

    public function getHasFrozenAttribute()
    {
        return (bool) $this->frozen_at;
    }

    public function markThreadAsBanned()
    {
        return $this->forceFill([
            'banned_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function markThreadAsExcellent()
    {
        return $this->forceFill([
            'excellent_at' => $this->freshTimestamp(),
        ])->save();
    }
}
