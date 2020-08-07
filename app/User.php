<?php

namespace App;

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
        'created' => \App\Events\UserCreated::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'username', 'password',
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

    /**
     * Relationships
     */
    public function profile()
    {
        return $this->hasOne('App\Profile', 'user_id');
    }

    public function projects()
    {
        return $this->hasMany('App\Project', 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'creator_id');
    }

    public function postAudios()
    {
        return $this->hasMany('App\PostAudio', 'creator_id');
    }
}
