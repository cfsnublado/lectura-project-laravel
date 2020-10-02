<?php

namespace App\Validation\Blog;

class PostValidation
{
    public static function rulesStore($projectId)
    {
        return [
            'name' => 'required|unique:posts,name,NULL,id,project_id,' . $projectId,
            'language' => 'required',
            'description' => '',
            'content' => 'required',
        ];
    }

    public static function rulesUpdate($id, $projectId)
    {
        return [
            'name' => 'required|unique:posts,name,' . $id . ',id,project_id,' . $projectId,
            'language' => 'required',
            'description' => '',
            'content' => 'required',
        ];
    }
}