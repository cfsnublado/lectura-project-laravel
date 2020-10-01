<?php

namespace App\Validation\Blog;

class ProjectValidation
{
    public static function rulesStore()
    {
       return [
            'language' => 'required',
            'name' => 'required|unique:projects,name',
            'description' => ''
        ];
    }

    public static function rulesUpdate($id)
    {
       return [
            'language' => 'required',
            'name' => 'required|unique:projects,name,' . $id,
            'description' => ''
        ];
    }
}