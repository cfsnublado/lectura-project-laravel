<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Interfaces\LanguageExclusive;

class Project extends Model implements LanguageExclusive
{
    use HasFactory;
    
    public $timestamps = true;

    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $with = ['owner.profile'];
    protected $fillable = [
        'owner_id', 'language', 'name', 'description',
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

    public function owner()
    {
        return $this->belongsTo('App\Models\User\User', 'owner_id');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Blog\Post', 'project_id');
    }
}
