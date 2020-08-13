<?php

namespace App\Models\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $with = ['profile'];
    protected $dispatchesEvents = [
        'creating' => \App\Events\UserCreating::class,
        'created' => \App\Events\UserCreated::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name', 'last_name',
        'email', 'username', 'password',
        'is_superuser',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function username()
    {
        return 'username';
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    /**
     * Get the boolean value of is_superuser.
     *
     * @param  int  $value
     * @return boolean
     */
    public function getIsSuperuserAttribute($value)
    {
        return boolval($value);
    }

    /**
     * Relationships
     */
    public function profile()
    {
        return $this->hasOne('App\Models\User\Profile', 'user_id');
    }

    public function projects()
    {
        return $this->hasMany('App\Models\Blog\Project', 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Blog\Post', 'creator_id');
    }

    public function postAudios()
    {
        return $this->hasMany('App\Models\Blog\PostAudio', 'creator_id');
    }
}
