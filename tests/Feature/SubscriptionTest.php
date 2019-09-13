<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use App\Subscription;
use App\Comment;
use Illuminate\Support\Facades\DB;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function aReaderCanSubscribeToAPost()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->post(route('subscription.store'), ['emailaddress' => 'subscriber@domain.ext', 'post_id' => $post->id]);
        $response->assertStatus(302);

        $this->assertCount(1, Subscription::all());
        $this->assertDatabaseHas('subscriptions', ["emailaddress" => "subscriber@domain.ext"]);
    }

    /**
     * @test
     */
    public function eachEmailAddressCanOnlySubscribeOnce()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->post(route('subscription.store'), ['emailaddress' => 'subscriber@domain.ext', 'post_id' => $post->id]);
        $response->assertStatus(302);

        $response = $this->post(route('subscription.store'), ['emailaddress' => 'subscriber@domain.ext', 'post_id' => $post->id]);
        $response->assertStatus(302);

        $this->assertCount(1, Subscription::all());
        $this->assertDatabaseHas('subscriptions', ["emailaddress" => "subscriber@domain.ext"]);
    }

    /**
     * @test
     */
    public function subscriptionsAreRelatedToPosts()
    {
        $post = factory(Post::class)->create();

        $response = $this->post(route('subscription.store'), ['emailaddress' => 'subscriber@domain.ext', 'post_id' => $post->id]);
        $response = $this->post(route('subscription.store'), ['emailaddress' => 'subscriber2@domain.ext', 'post_id' => $post->id]);

        // See if we can pull up the Subscriptions from the Post
        $this->assertCount(2, $post->fresh()->subscriptions);

        // If we have a Subscription, we should be able to find the Post too
        $this->assertEquals(Subscription::first()->post->id, $post->id);
    }

    /**
     * @test
     */
    public function aNotificationIsSentToSubscriptions()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->post(route('subscription.store'), ['emailaddress' => 'subscriber@domain.ext', 'post_id' => $post->id]);
        $response = $this->post(route('subscription.store'), ['emailaddress' => 'subscriber2@domain.ext', 'post_id' => $post->id]);

        $this->assertCount(2, $post->fresh()->subscriptions);

        if (\App\Setting::get('mail.useQueue') !== null) {
            $comment = factory(Comment::class)->make(['post_id' => $post->id]);

            $result = $this->post(route('comment.store'), $comment->toArray());

            $this->assertEquals(2, DB::table('jobs')->count());
        }        
    }
}
