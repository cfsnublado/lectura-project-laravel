<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    public $timestamps = true;

    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $with = ['owner.profile'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id', 'name', 'description',
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

    public function owner()
    {
        return $this->belongsTo('App\Model\User\User', 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Model\Blog\Post', 'project_id');
    }
}
