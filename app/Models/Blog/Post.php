<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    public $timestamps = true;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $with = ['creator.profile', 'project'];
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
        return $this->belongsTo('App\Models\User\User', 'creator_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Blog\Project', 'project_id');
    }

    public function postAudios()
    {
        return $this->hasMany('App\Models\Blog\PostAudio', 'post_id');
    }
}
