<?php

namespace App\Model;

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
        return $this->belongsTo('App\User', 'user_id');
    }   
}
