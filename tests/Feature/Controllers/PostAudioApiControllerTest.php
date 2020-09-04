<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\User\User;
use App\Models\Blog\Project;
use App\Models\Blog\Post;
use App\Models\Blog\PostAudio;

class PostAudioApiControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $superuser;
    private $user;
    private $projectOwner;
    private $project;
    private $post;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('users')->delete();
        $this->superuser = factory(User::class)->create([
            'is_superuser' => true
        ]);
        $this->user = factory(User::class)->create();
        $this->projectOwner = factory(User::class)->create();
        $this->project = factory(Project::class)->create([
            'owner_id' => $this->projectOwner,
            'name' => 'Test Project A'
        ]);
        $this->post = factory(Post::class)->create([
            'creator_id' => $this->projectOwner->id,
            'project_id' => $this->project->id,
            'name' => 'Test Post A'
        ]);
    }
    
    /**
     *
     * @return void
     */
    public function testNestedIndex()
    {
        $numAudios = 20;
        $paginationNum = 10;

        for ($x=0; $x<$numAudios; $x++) {
            factory(PostAudio::class)->create([
                'creator_id' => $this->projectOwner->id,
                'post_id' => $this->post->id,
                'name' => 'Post Audio ' . $x
            ]);
        }

        // Pagination default
        $response = $this->get(
            route(
                'api.blog.post.post_audios.list',
                ['post' => $this->post->id]
            )
        );
        $response->assertStatus(200);
        $json = json_decode($response->getContent());
        $this->assertEquals(count($json->data), $paginationNum);
        $this->assertTrue(property_exists($json, 'links'));
        $this->assertTrue(property_exists($json, 'meta'));

        // Pagination specified
        $response = $this->get(
            route(
                'api.blog.post.post_audios.list',
                ['post' => $this->post->id, 'pagination' => true]
            )
        );
        $response->assertStatus(200);
        $json = json_decode($response->getContent());
        $this->assertEquals(count($json->data), $paginationNum);
        $this->assertTrue(property_exists($json, 'links'));
        $this->assertTrue(property_exists($json, 'meta'));

        // No pagination
        $response = $this->get(
            route(
                'api.blog.post.post_audios.list',
                ['post' => $this->post->id, 'pagination' => false]
            )
        );
        $response->assertStatus(200);
        $json = json_decode($response->getContent());
        $this->assertEquals(count($json->data), $numAudios);
        $this->assertFalse(property_exists($json, 'links'));
        $this->assertFalse(property_exists($json, 'meta'));

        //dd($json);
    }
}
