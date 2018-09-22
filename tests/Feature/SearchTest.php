<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use App\Search;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function aSearchCanBePerformed()
    {
        $response = $this->post(route('search.store'), ['term' => 'beautiful']);

        $this->assertEquals(1, Search::all()->count());

        $search = Search::first();

        $response->assertRedirect(route('search.show', $search));
    }

    /**
     * @test
     */
    public function aSearchReturnsMatchingResults()
    {
        $this->signIn();

        $post = factory(Post::class)->create(['title' => 'Beautiful post']);
        $post2 = factory(Post::class)->create(['title' => 'Different post']);

        $response = $this->post(route('search.store'), ['term' => 'beautiful']);

        $search = Search::first();

        $response->assertRedirect(route('search.show', $search));

        $this->assertArrayHasKey(0, $search->result);
        $this->assertArrayNotHasKey(1, $search->result);

        $this->assertEquals($search->result[0], $post->id);
    }

    /**
     * @test
     */
    public function aSearchWillNotReturnANotMatchingResult()
    {
        $this->signIn();

        $post = factory(Post::class)->create(['title' => 'Beautiful post']);
        $post2 = factory(Post::class)->create(['title' => 'Different post']);

        $response = $this->post(route('search.store'), ['term' => 'beautiful']);

        $search = Search::first();

        $response->assertRedirect(route('search.show', $search));

        $this->assertArrayHasKey(0, $search->result);
        $this->assertArrayNotHasKey(1, $search->result);

        $this->assertNotEquals($search->result[0], $post2->id);
    }

    /**
     * @test
     */
    public function aSearchIsPerformedInDifferentColumns()
    {
        $this->signIn();

        $post = factory(Post::class)->create(['title' => 'A beautiful post']);
        $post2 = factory(Post::class)->create(['longTitle' => 'This is a beautiful post.']);
        $post3 = factory(Post::class)->create(['summary' => 'Beautiful posts are hard to find these days. Heres how you can.']);
        $post4 = factory(Post::class)->create(['body' => 'To find a beautiful post in the modern day and age, you have to look far and wide.']);

        $response = $this->post(route('search.store'), ['term' => 'beautiful']);

        $search = Search::first();

        $response->assertRedirect(route('search.show', $search));

        $this->assertArrayHasKey(0, $search->result);
        $this->assertArrayHasKey(1, $search->result);
        $this->assertArrayHasKey(2, $search->result);
        $this->assertArrayHasKey(3, $search->result);
    }
}
