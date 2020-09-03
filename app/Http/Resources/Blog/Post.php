<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'project_url' => route(
                'api.blog.project.show',
                ['project' => $this->project_id]
            ),
            'post_audios_url' => route(
                'api.blog.post.post_audios.list',
                ['post' => $this->id]
            )
        ];
    }
}
