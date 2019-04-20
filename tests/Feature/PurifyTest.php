<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurifyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function nameAttributeIsAllowedOnParagraph()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create(['body' => '<p class="someClass" id="someID">This is a IDd paragraph</p>']);

        $this->assertEquals($post->body(), $post->body);
    }

    /**
     * @test
     *
     * @return void
     */
    public function nameAttributeIsAllowedOnAnchor()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create(['body' => '<a class="someClass" href="/" id="someID">This is an IDd anchor</a>']);

        $this->assertEquals($post->body(), $post->body);
    }

    /**
     * @test
     */
    public function anExternalLinkIsTargettedToBlank()
    {
        $post = factory(Post::class)->create(['body' => '<a href="http://example.com">Blank example</a>']);

        $this->assertEquals('<a href="http://example.com" target="_blank" rel="noreferrer noopener">Blank example</a>', $post->body);
    }

    /**
     * @test
     */
    public function anInternalLinkIsTargettedToBlank()
    {
        $post = factory(Post::class)->create(['body' => "<a href='/'>Blank example</a>"]);

        $this->assertEquals('<a href="/">Blank example</a>', $post->body);
    }
}
