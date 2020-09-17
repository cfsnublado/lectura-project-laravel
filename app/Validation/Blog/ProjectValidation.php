<?php

namespace App\Validation\Blog;

class ProjectValidation
{
    public static function rulesStore()
    {
       return [
            'name' => 'required|unique:projects,name',
            'description' => ''
        ];
    }

    public static function rulesUpdate($id)
    {
       return [
            'name' => 'required|unique:projects,name,' . $id,
            'description' => ''
        ];
    }
}