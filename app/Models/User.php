<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

/**
 * Class User   用户模型
 * @package App\Models
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * boot 方法会在用户模型类完成初始化之后进行加载
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }

    /**
     * 用于头像和侧边栏功能
     * @param string $size
     * @return string
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * 用于用户重置密码操作
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * 指明用户和微博的关系是一对多 使用了微博动态的复数形式 statuses 来作为定义的函数名
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * 获取当前用户发表过的微博信息
     * @return $this
     */
    public function feed()
    {
        return $this->statuses()->orderBy('created_at', 'desc');
    }
}
