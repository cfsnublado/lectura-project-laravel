<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = true;

    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $with = ['owner.profile'];

    /**
     * Relationships
     */

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Post', 'project_id');
    }

}
