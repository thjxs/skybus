<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Redis;
use App\Notifications\CommentMyThread;

class User extends Authenticatable
{
    use Notifiable, MustVerifyEmail, HasApiTokens, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'avatar', 'realname', 'phone',
        'bio', 'extends', 'settings', 'level', 'is_admin', 'cache', 'gender',
        'last_active_at', 'banned_at', 'github_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'phone',
    ];

    protected $dates = [
        'last_active_at', 'banned_at', 'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->name = $user->username;
        });
    }

    public function getLastWeekActivity()
    {
        $lastWeek = now()->subWeek()->weekOfYear;
        if (Redis::EXISTS('activity-'.now()->year.$lastWeek)) {
            $lastWeekRecord = [];
            $startOfWeek = now()->subWeek()->startOfWeek();
            $endOfWeek = now()->subWeek()->endOfWeek();
            for ($i=0; $i < $endOfWeek; $i++) {
                $lastWeekRecord[] = $startOfWeek->addDays($i)->toDateString();
            }
             static::setWeekActivityRecord(now()->year, $lastWeek, $lastWeekRecord);
        }
        return Redis::GETBIT('activity-'.now()->year.'-'.$lastWeek, $this->id);
    }

    public static function setWeekActivityRecord($year, $weekOfYear)
    {
        Redis::BITOP('AND', "activity-{$year}-{$weekOfYear}", $wholeWeekRecord);
    }

    public function getWeekActivityRecord($year, $weekOfYear)
    {
        return Redis::GETBIT("activity-{$year}-{$weekOfYear}", $this->id);
    }

    public function setDaysActivity($date)
    {
        Redis::SETBIT("activity-{$date}", $this->id, 1);
    }

    public function getDaysActivityRecord($date)
    {
        Redis::GETBIT("activity-{$date}", $this->id);
    }

    public function recordActivity()
    {
        $this->setDaysActivity(now()->toDateString());
    }

    public function sendCommentMyThreadNotification($comment)
    {
        $this->notify(new CommentMyThread($comment));
    }
}
