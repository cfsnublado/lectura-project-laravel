<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostAudio extends Model
{
    public $timestamps = true;

    protected $table = 'post_audios';
    protected $primaryKey = 'id';
    protected $with = ['creator.profile'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'creator_id', 'name',
        'description', 'audio_url'
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

    public function post()
    {
        return $this->belongsTo('App\Model\Blog\Post', 'post_id');
    }
}
