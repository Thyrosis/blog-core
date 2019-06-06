<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostHash extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function aPostCanGenerateARandomHash()
    {
        $post = factory(Post::class)->create();

        $this->assertEquals(null, $post->fresh()->hash);

        $hash = $post->generateHash();

        $this->assertEquals($hash, $post->fresh()->hash);
    }

    /**
     * @test
     */
    public function anUnpublishedPostWithoutHashCantBeViewedByGuest()
    {
        $post = factory(Post::class)->create();

        $response = $this->get($post->link);

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function anUnpublishedPostWithHashStillCantBeViewedByGuest()
    {
        $post = factory(Post::class)->create();
        $hash = $post->generateHash();

        $response = $this->get($post->link);

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function anUnpublishedPostWithHashCanBeViewedByGuestWithHash()
    {
        $post = factory(Post::class)->create();
        $hash = $post->generateHash();

        $response = $this->get($post->link.'?hash='.$post->hash);

        $response->assertStatus(200);
    }
}
