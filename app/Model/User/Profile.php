<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public $timestamps = true;

    protected $table = 'profiles';
    protected $primaryKey = 'id';
    

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo('App\Model\User\User', 'user_id');
    }   
}
