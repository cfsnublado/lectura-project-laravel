<?php

namespace App\Validation\Blog;

class PostAudioValidation
{
    public static function rulesStore()
    {
        return [
            'name' => 'required|unique:post_audios,name',
            'description' => '',
            'audio_url' => 'required|url',
        ];
    }

    public static function rulesUpdate($id)
    {
        return [
            'name' => 'required|unique:post_audios,name,' . $id,
            'description' => '',
            'audio_url' => 'required|url',
        ];
    }
}