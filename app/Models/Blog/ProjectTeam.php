<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

use App\Traits\EnumTrait;

class ProjectTeam extends Model
{
    use EnumTrait;

    public $timestamps = true;

    protected $table = 'project_teams';
    protected $with = ['member.profile', 'project'];
    protected $fillable = [
        'member_id', 'project_id', 'role'
    ];
    /**
     * The attributes that are enum.
     *
     * @var array enumName => attribute
     */
    protected static $enums = [
        'ROLES' => 'role'
    ];

    /**
     * Project users' roles
     * 
     * @var array
     */
    public const ROLES = [
        1 => 'author',
        2 => 'editor',
        3 => 'admin',
    ];

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