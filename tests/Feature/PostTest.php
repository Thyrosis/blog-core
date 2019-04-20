<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;
use Illuminate\Validation\ValidationException;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aPostCanBeRead()
    {
        $this->withoutExceptionHandling();

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
        $this->withoutExceptionHandling();
        
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
        $this->withoutExceptionHandling();
        
        $this->signInAdmin();

        $post = factory(Post::class)->states('publishing')->make()->toArray();

        try {
            $response = $this->post(route('admin.post.store'), $post);
        } catch (ValidationException $e) {
            dd($e);
        }

        // dd($response->getContent());
        $response->assertSessionHas('success');
    }

    /**
     * @test
     */
    public function aPostCanBeEdited()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $post = factory(Post::class)->create();

        $post->title = "Edited";

        try {
            $response = $this->patch(route('admin.post.update', $post), $post->toArray());
        } catch (ValidationException $e) {
            dd($e);
        }
        

        $response->assertSessionHas('success');
    }

    /**
     * @test
     */
    public function aPostCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $this->signInAdmin();

        $post = factory(Post::class)->create();

        $response = $this->delete(route('admin.post.destroy', $post));

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('posts', ['title' => $post['title']]);
    }
}
