<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    public const ROLE_AUTHOR = 1;
    public const ROLE_EDITOR = 2;
    public const ROLE_ADMIN = 3;

    /**
     * Project user roles
     * 
     * @var array
     */
    public const ROLES = [
        self::ROLE_AUTHOR => 'author',
        self::ROLE_EDITOR => 'editor',
        self::ROLE_ADMIN => 'admin',
    ];

    public $timestamps = true;

    protected $table = 'project_members';
    protected $with = ['member.profile', 'project'];
    protected $fillable = [
        'role', 'member_id', 'project_id',
    ];

    /**
     *
     */
    public function setRoleAttribute($value)
    {
        if (array_key_exists($value, self::ROLES)) {
            $this->attributes['role'] = $value;
        }
    }

   /**
    * Get user role value.
    */
   public function getRoleValueAttribute()
   {
      return self::ROLES[$this->attributes['role']];
   }

    /**
     * Relationships
     *
     * Note that this model is a standalone model and not a pivot model, although
     * it handles the many to many relationship between projects and users. Just use
     * this model directly.
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Blog\Project', 'project_id');
    }

    public function member()
    {
        return $this->belongsTo('App\Models\User\User', 'member_id');
    }
}