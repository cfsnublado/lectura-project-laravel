<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PostAudio extends Model
{
    public $timestamps = true;

    protected $table = 'post_audios';
    protected $primaryKey = 'id';
    protected $with = ['creator.profile'];


    /**
     * Relationships
     */

    public function creator()
    {
        return $this->belongsTo('App\Model\User', 'creator_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Model\Post', 'post_id');
    }
}
