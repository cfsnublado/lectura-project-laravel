<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    public $timestamps = true;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $with = ['creator.profile', 'project'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'creator_id', 'name',
        'description',
    ];

    /**
     * Set the name and
     * corresponding slug.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    /**
     * Relationships
     */

    public function creator()
    {
        return $this->belongsTo('App\Model\User\User', 'creator_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Model\Blog\Project', 'project_id');
    }

    public function postAudios()
    {
        return $this->hasMany('App\Model\Blog\PostAudio', 'post_id');
    }
}
