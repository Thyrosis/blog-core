<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aPostCanBeRead()
    {
        $post = factory(Post::class)->create();

        $this->assertDatabaseHas('posts', $post->toArray());

        $response = $this->get($post->link);

        $response->assertStatus(200);

        $response->assertSee($post->body);

        // Depending on the theme in use, either title or longTitle is shown
        try {
            $response->assertSee($post->title);    
        } catch (\Exception $e) {
            $response->assertSee($post->longTitle);
        }        
    }

    /**
     * @test
     */
    public function anUnpublishedPostWontShowOnIndex()
    {
        $posts = factory(Post::class, 4)->create();
        $unpublishedPost = factory(Post::class)->create();
        $unpublishedPost->update(['title' => 'NotShowing', 'published' => 0]);

        $this->assertCount(5, Post::all());

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }

        $response->assertDontSee($unpublishedPost->title);
    }

    /**
     * @test
     */
    public function anUnpublishedPostCantBeRead()
    {
        $post = factory(Post::class)->create();
        $post->update(['published' => 0]);

        $this->assertDatabaseHas('posts', $post->toArray());

        $response = $this->get($post->link);

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function aFuturePostWontShowOnIndex()
    {
        $posts = factory(Post::class, 3)->create();
        $unpublishedPost = factory(Post::class)->create();
        $unpublishedPost->update(['title' => 'NotShowing', 'published_at' => Carbon::now()->addWeeks(3)->format('Y-m-d H:i:s')]);

        $this->assertCount($posts->count() + 1, Post::all());

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }

        $response->assertDontSee($unpublishedPost->title);
    }

    /**
     * @test
     */
    public function aFuturePostCantBeRead()
    {
        $post = factory(Post::class)->create();
        $post->update(['published' => 1, 'published_at' => Carbon::now()->addWeeks(3)->format('Y-m-d H:i:s')]);

        $this->assertDatabaseHas('posts', $post->toArray());

        $response = $this->get($post->link);

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function theHomepageShowsAllPostTitlesAndSummaries()
    {
        $posts = factory(Post::class, 4)->create();
        
        $this->assertCount(4, Post::all());

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
    }

    /**
     * @test
     */
    public function aPostCanBeCreated()
    {
        $this->signIn();

        $post = factory(Post::class)->make()->toArray();

        $response = $this->post(route('admin.post.store'), $post);

        $response->assertSessionHas('success');
    }

    /**
     * @test
     */
    public function aPostCanBeEdited()
    {
        $this->signIn();

        $post = factory(Post::class)->create();

        $post->title = "Edited";

        $response = $this->patch(route('admin.post.update', $post), $post->toArray());

        $response->assertSessionHas('success');
    }

    /**
     * @test
     */
    public function aPostCanBeDeleted()
    {
        $this->signIn();

        $post = factory(Post::class)->make()->toArray();

        $response = $this->post(route('admin.post.store'), $post);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('posts', ['title' => $post['title']]);

        $response2 = $this->get(route('admin.post.destroy', $post));

        $response2->assertSessionHas('success');
        $this->assertDatabaseMissing('posts', ['title' => $post['title']]);
    }
}
