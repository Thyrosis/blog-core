<?php

namespace Tests\Feature;

use App\Tag;
use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aPostCanBelongToATag()
    {
        $tag = factory(Tag::class)->create();

        $this->assertDatabaseHas('tags', $tag->toArray());

        $post = factory(Post::class)->create();

        $this->assertDatabaseHas('posts', $post->toArray());

        $post->tags()->sync([$tag->id]);

        $this->assertEquals(1, $post->fresh()->tags->count());
    }

    /**
     * @test
     */
    public function aTagCanHaveAPost()
    {
        $tag = factory(Tag::class)->create();

        $this->assertDatabaseHas('tags', $tag->toArray());

        $post = factory(Post::class)->create();

        $this->assertDatabaseHas('posts', $post->toArray());

        $tag->posts()->sync([$post->id]);

        $this->assertEquals(1, $tag->fresh()->posts->count());
    }

    /**
     * @test
     */
    public function aTagCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $tag = factory(Tag::class)->make();

        $this->post(route('admin.tag.store'), $tag->toArray());

        $this->assertDatabaseHas('tags', $tag->toArray());
    }

    /**
     * @test
     */
    public function aTagCanBeEdited()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $tag = factory(Tag::class)->make();

        $this->post(route('admin.tag.store'), $tag->toArray());

        $this->assertDatabaseHas('tags', $tag->toArray());

        $tag->name = "New Title";
        $tag->description = "New description";

        $this->patch(route('admin.tag.update', $tag), $tag->toArray());

        $this->assertDatabaseHas('tags', $tag->toArray());
    }

    /**
     * @test
     */
    public function aTagCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $tag = factory(Tag::class)->make();

        $this->post(route('admin.tag.store'), $tag->toArray());

        $this->assertDatabaseHas('tags', $tag->toArray());

        $this->delete(route('admin.tag.destroy', $tag));

        $this->assertDatabaseMissing('tags', $tag->toArray());
    }

    /**
     * @test
     */
    public function whenATagIsDeletedExistingPostsRemain()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $tag = factory(Tag::class)->create();
        $post = factory(Post::class)->create();
        $tag->posts()->sync([$post->id]);

        $this->assertEquals(1, Post::count());
        $this->assertEquals(1, $post->tags()->count());

        $this->delete(route('admin.tag.destroy', $tag));

        $this->assertEquals(1, Post::count());
        $this->assertEquals(0, Tag::count());
        $this->assertEquals(0, $post->fresh()->tags()->count());
    }

}
