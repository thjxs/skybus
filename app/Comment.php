<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Followable;

class Comment extends Model
{
    use SoftDeletes, Followable;

    protected $fillable = [
        'commentable_id', 'commentable_type', 'user_id', 'cache',
    ];

    protected $dates = [
        'banned_at',
    ];

    protected $with = [
        'user', 'content',
    ];

    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'cache' => 'object',
    ];

    protected $appends = [
        'has_up_voted', 'has_down_voted', 'up_voters_count', 'down_voters_count'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            $comment->user_id = auth()->user()->id;
        });

        $saveContent = function ($comment) {
            if (request()->has('content')) {
                $data = ['body' => request()->get('content')];
                $comment->content()->updateOrCreate(['contentable_id' => $comment->id], $data);
                $comment->loadMissing('content');
            }
        };

        static::updated($saveContent);
        static::created($saveContent);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function content()
    {
        return $this->morphOne(Content::class, 'contentable');
    }
}
