<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PostAudio extends Model
{
    use HasFactory;
    
    public $timestamps = true;

    protected $table = 'post_audios';
    protected $primaryKey = 'id';
    protected $with = ['creator.profile', 'post.project'];
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
        return $this->belongsTo('App\Models\User\User', 'creator_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Blog\Post', 'post_id');
    }
}
