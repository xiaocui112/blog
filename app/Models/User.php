<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use Traits\ActiveUserHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'introduction',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * 回去完整的图片的完整路径
     *
     * @return string
     */
    public function avatarFullUrls(): string
    {
        if (str_contains((string)$this->avatar, "http")) {
            return $this->avatar;
        } else {
            $url = Storage::url($this->avatar);
            return $url;
        }
    }
    /**
     * 用户一对多帖子
     *
     * @return HasMany
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
    /**
     * 用户的所有评论
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }
    /**
     * 自定义通知
     *
     * @param Notification $instance
     * @return void
     */
    public function customNtify($instance)
    {
        if ($this->id == Auth::id()) {
            return;
        }
        if (method_exists($instance, 'toDatabase')) {
            $this->increment('notification_count', 1);
        }
        $this->notify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
