<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $with = ['creator.profile'];

    /**
     * Relationships
     */

    public function creator()
    {
        return $this->belongsTo('App\Model\User', 'creator_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Model\Project', 'project_id');
    }

    public function postAudios()
    {
        return $this->hasMany('App\Model\PostAudio', 'post_id');
    }
}
