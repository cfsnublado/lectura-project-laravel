<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Interfaces\LanguageExclusive;

class Post extends Model implements LanguageExclusive
{
    use HasFactory;
    
    public $timestamps = true;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $with = ['creator.profile', 'project'];
    protected $fillable = [
        'project_id', 'creator_id', 'language',
        'name', 'description', 'content'
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
     *
     */
    public function setLanguageAttribute($value)
    {
        if (array_key_exists($value, self::LANGUAGES)) {
            $this->attributes['language'] = $value;
        }
    }

   /**
    * 
    */
   public function getLanguageValueAttribute()
   {
      return self::LANGUAGES[$this->attributes['language']];
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

    public function post_audios()
    {
        return $this->hasMany('App\Models\Blog\PostAudio', 'post_id');
    }
}
