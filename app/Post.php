<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;

    protected $table = 'posts';
    protected $primaryKey = 'id';

    /**
     * Relationships
     */

    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id');
    }

    public function postAudios()
    {
        return $this->hasMany('App\PostAudio', 'post_id');
    }
}
