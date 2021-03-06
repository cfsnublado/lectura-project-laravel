<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class PostAudio extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'audio_url' => $this->audio_url,
            'creator_id' => $this->creator_id,
            'creator_username' => $this->creator->username,
            'creator_first_name' => $this->creator->first_name,
            'creator_last_name' => $this->creator->last_name,
            'post_id' => $this->post_id,
            'post_name' => $this->post->name,
            'post_slug' => $this->post->slug,
            'post_url' => route(
                'api.blog.post.show',
                ['post' => $this->post_id]
            ),
        ];
    }
}
