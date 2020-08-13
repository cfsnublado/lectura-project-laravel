<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EnumTrait;

class ProjectUser extends Model
{
    use EnumTrait;

    public $timestamps = true;

    protected $table = 'project_user';
    protected $with = ['user.profile', 'project'];

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
        1 => 'admin',
        2 => 'editor',
        3 => 'author',
    ];

}